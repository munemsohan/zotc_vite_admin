<?php

namespace App\Http\Controllers;

use AizPackages\CombinationGenerate\Services\CombinationService;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductTranslation;
use App\Models\Category;
use App\Models\AttributeValue;
use App\Models\Cart;
use App\Models\ProductCategory;
use App\Models\ProductStock;
use App\Models\Upload;
use App\Models\Wishlist;
use App\Models\User;
use App\Notifications\ShopProductNotification;
use Carbon\Carbon;
use CoreComponentRepository;
use Artisan;
use Cache;
use App\Services\ProductService;
use App\Services\ProductTaxService;
use App\Services\ProductFlashDealService;
use App\Services\ProductStockService;
use App\Services\FrequentlyBoughtProductService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Str;

class ProductController extends Controller
{
    protected $productService;
    protected $productTaxService;
    protected $productFlashDealService;
    protected $productStockService;
    protected $FrequentlyBoughtProductService;

    public function __construct(
        ProductService $productService,
        ProductTaxService $productTaxService,
        ProductFlashDealService $productFlashDealService,
        ProductStockService $productStockService,
        FrequentlyBoughtProductService $FrequentlyBoughtProductService
    ) {
        $this->productService = $productService;
        $this->productTaxService = $productTaxService;
        $this->productFlashDealService = $productFlashDealService;
        $this->productStockService = $productStockService;
        $this->FrequentlyBoughtProductService = $FrequentlyBoughtProductService;

        // Staff Permission Check
        $this->middleware(['permission:add_new_product'])->only('create');
        $this->middleware(['permission:show_all_products'])->only('all_products');
        $this->middleware(['permission:show_in_house_products'])->only('admin_products');
        $this->middleware(['permission:show_seller_products'])->only('seller_products');
        $this->middleware(['permission:product_edit'])->only('admin_product_edit', 'seller_product_edit');
        $this->middleware(['permission:product_duplicate'])->only('duplicate');
        $this->middleware(['permission:product_delete'])->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_products(Request $request)
    {
        CoreComponentRepository::instantiateShopRepository();

        $type = 'In House';
        $col_name = null;
        $query = null;
        $sort_search = null;

        $products = Product::where('added_by', 'admin')->where('auction_product', 0)->where('wholesale_product', 0);

        if ($request->type != null) {
            $var = explode(",", $request->type);
            $col_name = $var[0];
            $query = $var[1];
            $products = $products->orderBy($col_name, $query);
            $sort_type = $request->type;
        }
        if ($request->search != null) {
            $sort_search = $request->search;
            $products = $products
                ->where('name', 'like', '%' . $sort_search . '%')
                ->orWhereHas('stocks', function ($q) use ($sort_search) {
                    $q->where('sku', 'like', '%' . $sort_search . '%');
                });
        }

        $products = $products->where('digital', 0)->orderBy('created_at', 'desc')->paginate(15);

        return view('backend.product.products.index', compact('products', 'type', 'col_name', 'query', 'sort_search'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function seller_products(Request $request, $product_type)
    {
        $col_name = null;
        $query = null;
        $seller_id = null;
        $sort_search = null;
        $products = Product::where('added_by', 'seller')->where('auction_product', 0)->where('wholesale_product', 0);
        if ($request->has('user_id') && $request->user_id != null) {
            $products = $products->where('user_id', $request->user_id);
            $seller_id = $request->user_id;
        }
        if ($request->search != null) {
            $products = $products
                ->where('name', 'like', '%' . $request->search . '%');
            $sort_search = $request->search;
        }
        if ($request->type != null) {
            $var = explode(",", $request->type);
            $col_name = $var[0];
            $query = $var[1];
            $products = $products->orderBy($col_name, $query);
            $sort_type = $request->type;
        }
        $products = $product_type == 'physical' ? $products->where('digital', 0) : $products->where('digital', 1);
        $products = $products->orderBy('created_at', 'desc')->paginate(15);
        $type = 'Seller';

        if ($product_type == 'digital') {
            return view('backend.product.digital_products.index', compact('products', 'sort_search', 'type'));
        }
        return view('backend.product.products.index', compact('products', 'type', 'col_name', 'query', 'seller_id', 'sort_search'));
    }

    public function all_products(Request $request)
    {
        $col_name = null;
        $query = null;
        $seller_id = null;
        $sort_search = null;
        $products = Product::where('auction_product', 0)->where('wholesale_product', 0);
        if (get_setting('vendor_system_activation') != 1) {
            $products = $products->where('added_by', 'admin');
        }
        if ($request->has('user_id') && $request->user_id != null) {
            $products = $products->where('user_id', $request->user_id);
            $seller_id = $request->user_id;
        }
        if ($request->search != null) {
            $sort_search = $request->search;
            $products = $products
                ->where('name', 'like', '%' . $sort_search . '%')
                ->orWhereHas('stocks', function ($q) use ($sort_search) {
                    $q->where('sku', 'like', '%' . $sort_search . '%');
                });
        }
        if ($request->type != null) {
            $var = explode(",", $request->type);
            $col_name = $var[0];
            $query = $var[1];
            $products = $products->orderBy($col_name, $query);
            $sort_type = $request->type;
        }

        $products = $products->orderBy('created_at', 'desc')->paginate(15);
        $type = 'All';

        return view('backend.product.products.index', compact('products', 'type', 'col_name', 'query', 'seller_id', 'sort_search'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        CoreComponentRepository::initializeCache();

        $categories = Category::where('parent_id', 0)
            ->where('digital', 0)
            ->with('childrenCategories')
            ->get();

        return view('backend.product.products.create', compact('categories'));
    }

    public function add_more_choice_option(Request $request)
    {
        $all_attribute_values = AttributeValue::with('attribute')->where('attribute_id', $request->attribute_id)->get();

        $html = '';

        foreach ($all_attribute_values as $row) {
            $html .= '<option value="' . $row->value . '">' . $row->value . '</option>';
        }

        echo json_encode($html);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $thumbnail_img = null;
        if (!is_null($request->photos)) {
            $images = explode(',', $request->photos);
            $thumbnail_img = (int)$images[0];

            foreach ($images as $image_id) {
                $imageUpload = Upload::find($image_id);

                // Ensure the image exists in the database
                if ($imageUpload) {
                    $imagePath = $imageUpload->file_name;
                    $thumbnailPath = $imageUpload->thumbnail;

                    $randomFilename = Str::random(10);

                    // Process main image if it exists and needs resizing
                    $imageUpload->file_name = $this->processImage($randomFilename, $imagePath, 500);
                    $imageUpload->save();

                    // Process thumbnail
                    $imageUpload->thumbnail = $this->processThumbnail($randomFilename, $imagePath, $thumbnailPath, 200, 200);
                    $imageUpload->save();

                    // Delete original image file if it's not a WebP
                    if (pathinfo(public_path($imagePath), PATHINFO_EXTENSION) !== 'webp') {
                        unlink(public_path($imagePath));
                    }
                }
            }
        }

        $request->merge(['thumbnail_img' => $thumbnail_img]);

        $product = $this->productService->store($request->except([
            '_token', 'sku', 'choice', 'tax_id', 'tax', 'tax_type', 'flash_deal_id', 'flash_discount', 'flash_discount_type'
        ]));

        if (isset($request->minimum_pay_with_shipping)) {
            $minimum_pay_with_shipping = 1;
        } else {
            $minimum_pay_with_shipping = 0;
        }

        $product->minimum_pay_with_shipping = $minimum_pay_with_shipping;

        $productUrl = route('product', ['slug' => $product->slug]);
        $response = makeTinyUrl($productUrl);
        $shortenedUrl = $response ?? $productUrl;
        $product->tiny_url = $shortenedUrl;
        $product->save();


        if ($request->dropship_price && count($request->dropship_price) > 0) {
            $dropshop_price = '';

            for ($i = 0; $i < count($request->dropship_price); $i++) {
                if ($request->dropship_range[$i] && $request->dropship_price[$i]) {
                    $dropshop_price .= $request->dropship_range[$i] . '-' . $request->dropship_price[$i] . ',';
                }
            }

            // Remove trailing comma if present
            $dropshop_price = rtrim($dropshop_price, ',');

            // Only proceed if dropshop_price is not empty
            if (!empty($dropshop_price)) {
                $product->dropshop_price = $dropshop_price;
                $product->save();

                // Switch to the dynamic database
                DB::connection('dynamic_db')->statement("USE zotc_nazmart");

                $slug = get_free_domain_slug();
                $productData = [
                    'slug' => $slug,
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->unit_price,
                ];

                // Insert the product data into the products table
                DB::connection('dynamic_db')->table('products')->insert($productData);
            }
        }

        $request->merge(['product_id' => $product->id]);

        //Product categories
        $product->categories()->attach($request->category_ids);

        //VAT & Tax
        if ($request->tax_id) {
            $this->productTaxService->store($request->only([
                'tax_id', 'tax', 'tax_type', 'product_id'
            ]));
        }

        //Flash Deal
        $this->productFlashDealService->store($request->only([
            'flash_deal_id', 'flash_discount', 'flash_discount_type'
        ]), $product);

        //Product Stock
        $this->productStockService->store($request->only([
            'colors_active', 'colors', 'choice_no', 'unit_price', 'sku', 'current_stock', 'product_id'
        ]), $product);

        // Frequently Bought Products
        $this->FrequentlyBoughtProductService->store($request->only([
            'product_id', 'frequently_bought_selection_type', 'fq_brought_product_ids', 'fq_brought_product_category_id'
        ]));

        // Product Translations
        $request->merge(['lang' => env('DEFAULT_LANGUAGE')]);
        ProductTranslation::create($request->only([
            'lang', 'name', 'unit', 'description', 'product_id'
        ]));

        flash(translate('Product has been inserted successfully'))->success();

        Artisan::call('view:clear');
        Artisan::call('cache:clear');

        return redirect()->route('products.admin');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function admin_product_edit(Request $request, $id)
    {
        CoreComponentRepository::initializeCache();

        $product = Product::findOrFail($id);

        // dd($product);
        if ($product->digital == 1) {
            return redirect('admin/digitalproducts/' . $id . '/edit');
        }

        $lang = $request->lang;
        $tags = json_decode($product->tags);
        $categories = Category::where('parent_id', 0)
            ->where('digital', 0)
            ->with('childrenCategories')
            ->get();
        return view('backend.product.products.edit', compact('product', 'categories', 'tags', 'lang'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function seller_product_edit(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        if ($product->digital == 1) {
            return redirect('digitalproducts/' . $id . '/edit');
        }
        $lang = $request->lang;
        $tags = json_decode($product->tags);
        // $categories = Category::all();
        $categories = Category::where('parent_id', 0)
            ->where('digital', 0)
            ->with('childrenCategories')
            ->get();

        return view('backend.product.products.edit', compact('product', 'categories', 'tags', 'lang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $thumbnail_img = null;

        if (!is_null($request->photos)) {
            $images = explode(',', $request->photos);
            $thumbnail_img = (int)$images[0];

            foreach ($images as $image_id) {
                $imageUpload = Upload::find($image_id);

                // Ensure the image exists in the database
                if ($imageUpload) {
                    $imagePath = $imageUpload->file_name;
                    $thumbnailPath = $imageUpload->thumbnail;

                    $randomFilename = Str::random(10);

                    // Process main image if it exists and needs resizing
                    $imageUpload->file_name = $this->processImage($randomFilename, $imagePath, 500);
                    $imageUpload->save();

                    // Process thumbnail
                    $imageUpload->thumbnail = $this->processThumbnail($randomFilename, $imagePath, $thumbnailPath, 200, 200);
                    $imageUpload->save();

                    // Delete original image file if it's not a WebP
                    if (pathinfo(public_path($imagePath), PATHINFO_EXTENSION) !== 'webp') {
                        unlink(public_path($imagePath));
                    }
                }
            }
        }

        $request->merge(['thumbnail_img' => $thumbnail_img]);

        $oldSlug = $product->slug;

        //Product
        $product = $this->productService->update($request->except([
            '_token', 'sku', 'choice', 'tax_id', 'tax', 'tax_type', 'flash_deal_id', 'flash_discount', 'flash_discount_type'
        ]), $product);

        if (isset($request->minimum_pay_with_shipping)) {
            $minimum_pay_with_shipping = 1;
        } else {
            $minimum_pay_with_shipping = 0;
        }

        if (isset($request->minimum_pay_each_product)) {
            $minimum_pay_each_product = 1;
        } else {
            $minimum_pay_each_product = 0;
        }

        $product->minimum_pay_with_shipping = $minimum_pay_with_shipping;
        $product->minimum_pay_each_product = $minimum_pay_each_product;

        if ($oldSlug !== $product->slug || is_null($product->tiny_url)) {
            $productUrl = route('product', ['slug' => $product->slug]);
            $response = makeTinyUrl($productUrl);
            $shortenedUrl = $response ?? $productUrl;
            $product->tiny_url = $shortenedUrl;
        }

        $product->save();

        $slug = get_free_domain_slug();

        if ($request->dropship_price && count($request->dropship_price) > 0) {
            $dropshop_price = '';

            for ($i = 0; $i < count($request->dropship_price); $i++) {
                if ($request->dropship_range[$i] && $request->dropship_price[$i]) {
                    $dropshop_price .= $request->dropship_range[$i] . '-' . $request->dropship_price[$i] . ',';
                }
            }

            // Remove trailing comma if present
            $dropshop_price = rtrim($dropshop_price, ',');

            // Only proceed if dropshop_price is not empty
            if (!empty($dropshop_price)) {
                $product->dropshop_price = $dropshop_price;
                $product->save();

                // DB::connection('dynamic_db')->statement("USE zotc_nazmart");

                // $productData = [
                //     'product_id' => $product->id,
                //     'name' => $product->name,
                //     'price' => $product->unit_price,
                // ];

                // // Check if the product exists
                // $productExists = DB::connection('dynamic_db')
                //     ->table('products')
                //     ->where('slug', $slug)
                //     ->where('product_id', $product->id)
                //     ->exists();

                // if ($productExists) {
                //     // Update the product if it exists
                //     DB::connection('dynamic_db')
                //         ->table('products')
                //         ->where('slug', $slug)
                //         ->where('product_id', $product->id)
                //         ->update($productData);
                // } else {
                //     // Add the slug to the product data
                //     $productData['slug'] = $slug;

                //     // Insert the product if it does not exist
                //     DB::connection('dynamic_db')
                //         ->table('products')
                //         ->insert($productData);
                // }
            } else {
                // $product->dropshop_price = null;
                // $product->save();

                // DB::connection('dynamic_db')
                //     ->table('products')
                //     ->where('slug', $slug)
                //     ->where('product_id', $product->id)
                //     ->delete();
            }
        } else {
            $product->dropshop_price = null;
            $product->save();

            // DB::connection('dynamic_db')
            //     ->table('products')
            //     ->where('slug', $slug)
            //     ->where('product_id', $product->id)
            //     ->delete();
        }

        $request->merge(['product_id' => $product->id]);

        //Product categories
        $product->categories()->sync($request->category_ids);

        //Product Stock
        $product->stocks()->delete();
        $this->productStockService->store($request->only([
            'colors_active', 'colors', 'choice_no', 'unit_price', 'sku', 'current_stock', 'product_id'
        ]), $product);

        //Flash Deal
        $this->productFlashDealService->store($request->only([
            'flash_deal_id', 'flash_discount', 'flash_discount_type', 'discount', 'discount_type', 'discount_start_date', 'discount_end_date'
        ]), $product);

        //VAT & Tax
        if ($request->tax_id) {
            $product->taxes()->delete();
            $this->productTaxService->store($request->only([
                'tax_id', 'tax', 'tax_type', 'product_id'
            ]));
        }

        // Frequently Bought Products
        $product->frequently_bought_products()->delete();
        $this->FrequentlyBoughtProductService->store($request->only([
            'product_id', 'frequently_bought_selection_type', 'fq_brought_product_ids', 'fq_brought_product_category_id'
        ]));

        // Product Translations
        ProductTranslation::updateOrCreate(
            $request->only([
                'lang', 'product_id'
            ]),
            $request->only([
                'name', 'unit', 'description'
            ])
        );

        flash(translate('Product has been updated successfully'))->success();

        Artisan::call('view:clear');
        Artisan::call('cache:clear');
        if ($request->has('tab') && $request->tab != null) {
            return Redirect::to(URL::previous() . "#" . $request->tab);
        }
        return back();
    }

    private function processImage($randomFilename, $imagePath, $desiredWidth)
    {
        $slug = get_zotc_setting('img_slug') ?: 'all';

        if ($imagePath) {
            $imageContent = file_get_contents(public_path($imagePath));
            $image = imagecreatefromstring($imageContent);

            if ($image) {
                $originalWidth = imagesx($image);

                // Check if the image is already a WebP with the desired size
                $isWebp = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION)) === 'webp';

                if (!($isWebp && $originalWidth == $desiredWidth)) {
                    $uploadedPath = "uploads/{$slug}/{$randomFilename}.webp";
                    resizeAndSaveWebpImage($image, $uploadedPath, $desiredWidth);

                    return $uploadedPath;
                }

                return $imagePath;
            }
        }

        return null;
    }

    private function processThumbnail($randomFilename, $imagePath, $thumbnailPath, $desiredWidth, $desiredHeight)
    {
        $slug = get_zotc_setting('img_slug') ?: 'all';

        if ($thumbnailPath) {
            $thumbnailContent = file_get_contents(public_path($thumbnailPath));
            $thumbnail = imagecreatefromstring($thumbnailContent);

            if ($thumbnail) {
                $thumbnailWidth = imagesx($thumbnail);
                $thumbnailHeight = imagesy($thumbnail);

                if (!($thumbnailWidth == $desiredWidth && $thumbnailHeight == $desiredHeight)) {
                    $uploadedPath = "uploads/{$slug}/{$randomFilename}x{$desiredWidth}.webp";
                    resizeAndSaveWebpImage($thumbnail, $uploadedPath, $desiredWidth, $desiredHeight);

                    return $uploadedPath;
                }

                return $thumbnailPath;
            }
        } else {
            $imageContent = file_get_contents(public_path($imagePath));
            $image = imagecreatefromstring($imageContent);

            $uploadedPath = "uploads/{$slug}/{$randomFilename}x{$desiredWidth}.webp";
            resizeAndSaveWebpImage($image, $uploadedPath, $desiredWidth, $desiredHeight);

            return $uploadedPath;
        }

        return null;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        $product->product_translations()->delete();
        $product->categories()->detach();
        $product->stocks()->delete();
        $product->taxes()->delete();
        $product->frequently_bought_products()->delete();

        // DB::connection('dynamic_db')->statement("USE zotc_nazmart");
        // DB::connection('dynamic_db')
        //     ->table('products')
        //     ->where('slug', get_free_domain_slug())
        //     ->where('product_id', $product->id)
        //     ->delete();

        if (Product::destroy($id)) {
            Cart::where('product_id', $id)->delete();
            Wishlist::where('product_id', $id)->delete();

            flash(translate('Product has been deleted successfully'))->success();

            Artisan::call('view:clear');
            Artisan::call('cache:clear');

            return back();
        } else {
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    public function bulk_product_delete(Request $request)
    {
        if ($request->id) {
            foreach ($request->id as $product_id) {
                $this->destroy($product_id);
            }
        }

        return 1;
    }

    /**
     * Duplicates the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function duplicate(Request $request, $id)
    {
        $product = Product::find($id);

        //Product
        $product_new = $this->productService->product_duplicate_store($product);

        //Product Stock
        $this->productStockService->product_duplicate_store($product->stocks, $product_new);

        //VAT & Tax
        $this->productTaxService->product_duplicate_store($product->taxes, $product_new);

        // Product Categories
        foreach ($product->product_categories as $product_category) {
            ProductCategory::insert([
                'product_id' => $product_new->id,
                'category_id' => $product_category->category_id,
            ]);
        }

        // Frequently Bought Products
        $this->FrequentlyBoughtProductService->product_duplicate_store($product->frequently_bought_products, $product_new);

        flash(translate('Product has been duplicated successfully'))->success();
        if ($request->type == 'In House')
            return redirect()->route('products.admin');
        elseif ($request->type == 'Seller')
            return redirect()->route('products.seller');
        elseif ($request->type == 'All')
            return redirect()->route('products.all');
    }

    public function get_products_by_brand(Request $request)
    {
        $products = Product::where('brand_id', $request->brand_id)->get();
        return view('partials.product_select', compact('products'));
    }

    public function updateTodaysDeal(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->todays_deal = $request->status;
        $product->save();
        Cache::forget('todays_deal_products');
        return 1;
    }

    public function updatePublished(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->published = $request->status;

        if ($product->added_by == 'seller' && addon_is_activated('seller_subscription') && $request->status == 1) {
            $shop = $product->user->shop;
            if (
                $shop->package_invalid_at == null
                || Carbon::now()->diffInDays(Carbon::parse($shop->package_invalid_at), false) < 0
                || $shop->product_upload_limit <= $shop->user->products()->where('published', 1)->count()
            ) {
                return 0;
            }
        }

        $product->save();

        Artisan::call('view:clear');
        Artisan::call('cache:clear');
        return 1;
    }

    public function updateProductApproval(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->approved = $request->approved;

        if ($product->added_by == 'seller' && addon_is_activated('seller_subscription')) {
            $shop = $product->user->shop;
            if (
                $shop->package_invalid_at == null
                || Carbon::now()->diffInDays(Carbon::parse($shop->package_invalid_at), false) < 0
                || $shop->product_upload_limit <= $shop->user->products()->where('published', 1)->count()
            ) {
                return 0;
            }
        }

        $product->save();

        $product_type   = $product->digital ==  0 ? 'physical' : 'digital';
        $status         = $request->approved == 1 ? 'approved' : 'rejected';
        $users          = User::findMany([User::where('user_type', 'admin')->first()->id, $product->user_id]);
        Notification::send($users, new ShopProductNotification($product_type, $product, $status));

        Artisan::call('view:clear');
        Artisan::call('cache:clear');
        return 1;
    }

    public function updateFeatured(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->featured = $request->status;
        if ($product->save()) {
            Artisan::call('view:clear');
            Artisan::call('cache:clear');
            return 1;
        }
        return 0;
    }

    public function sku_combination(Request $request)
    {
        $options = array();
        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
            $colors_active = 1;
            array_push($options, $request->colors);
        } else {
            $colors_active = 0;
        }

        $unit_price = $request->unit_price;
        $product_name = $request->name;

        if ($request->has('choice_no')) {
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_' . $no;
                // foreach (json_decode($request[$name][0]) as $key => $item) {
                if (isset($request[$name])) {
                    $data = array();
                    foreach ($request[$name] as $key => $item) {
                        // array_push($data, $item->value);
                        array_push($data, $item);
                    }
                    array_push($options, $data);
                }
            }
        }

        $combinations = (new CombinationService())->generate_combination($options);
        return view('backend.product.products.sku_combinations', compact('combinations', 'unit_price', 'colors_active', 'product_name'));
    }

    public function sku_combination_edit(Request $request)
    {
        $product = Product::findOrFail($request->id);

        $options = array();
        if ($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0) {
            $colors_active = 1;
            array_push($options, $request->colors);
        } else {
            $colors_active = 0;
        }

        $product_name = $request->name;
        $unit_price = $request->unit_price;

        if ($request->has('choice_no')) {
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_' . $no;
                // foreach (json_decode($request[$name][0]) as $key => $item) {
                if (isset($request[$name])) {
                    $data = array();
                    foreach ($request[$name] as $key => $item) {
                        // array_push($data, $item->value);
                        array_push($data, $item);
                    }
                    array_push($options, $data);
                }
            }
        }

        $combinations = (new CombinationService())->generate_combination($options);
        return view('backend.product.products.sku_combinations_edit', compact('combinations', 'unit_price', 'colors_active', 'product_name', 'product'));
    }

    public function product_search(Request $request)
    {
        $products = $this->productService->product_search($request->except(['_token']));
        return view('partials.product.product_search', compact('products'));
    }

    public function get_selected_products(Request $request)
    {
        $products = product::whereIn('id', $request->product_ids)->get();
        return view('partials.product.frequently_brought_selected_product', compact('products'));
    }

    public function product_stock_update(Request $request)
    {
        $stock = ProductStock::find($request->stock_id);
        if ($stock) {
            $stock->qty = $request->quantity;
            $stock->save();

            $product = Product::find($request->product_id);
            if ($product && $product->variant_product == 0) {
                $product->current_stock = $request->quantity;
                $product->save();
            }

            return response()->json(['status' => 'success', 'message' => 'Stock updated successfully']);
        }

        return response()->json(['status' => 'error', 'message' => 'Stock not found'], 404);
    }
}
