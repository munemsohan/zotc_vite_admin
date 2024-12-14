<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\User;
use App\Models\ProductsImport;
use App\Models\ProductsExport;
use App\Models\Upload;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use Auth;
use DB;

class ProductBulkUploadController extends Controller
{
    public function __construct()
    {

        $this->middleware(['permission:product_bulk_import'])->only('index');
        $this->middleware(['permission:product_bulk_export'])->only('export');
    }

    public function index()
    {
        if (Auth::user()->user_type == 'seller') {
            if (Auth::user()->shop->verification_status) {
                return view('seller.product_bulk_upload.index');
            } else {
                flash(translate('Your shop is not verified yet!'))->warning();
                return back();
            }
        } elseif (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff') {
            return view('backend.product.bulk_upload.index');
        }
    }

    public function dropshop_index()
    {
        return view('backend.product.dropshop_upload.index');
    }

    public function fetchDropshopCategories(Request $request)
    {
        $source = $request->input('source');
        $sitesConnection = DB::connection('dynamic_db');
        $sitesConnection->getPdo()->exec("USE " . $source);

        // Fetch categories
        $categories = $sitesConnection->table('categories')->get();

        // Fetch products for each category
        $categories->each(function ($category) use ($sitesConnection) {
            $category->products = $sitesConnection->table('products')
                ->where('category_id', $category->id)
                ->get();
        });

        return response()->json(['success' => true, 'categories' => $categories]);
    }

    public function dropshipping()
    {
        return view('backend.product.dropshipping.index');
    }

    public function export()
    {
        return Excel::download(new ProductsExport, 'products.xlsx');
    }

    public function pdf_download_category()
    {
        $categories = Category::all();

        return PDF::loadView('backend.downloads.category', [
            'categories' => $categories,
        ], [], [])->download('category.pdf');
    }

    public function pdf_download_brand()
    {
        $brands = Brand::all();

        return PDF::loadView('backend.downloads.brand', [
            'brands' => $brands,
        ], [], [])->download('brands.pdf');
    }

    public function pdf_download_seller()
    {
        $users = User::where('user_type', 'seller')->get();

        return PDF::loadView('backend.downloads.user', [
            'users' => $users,
        ], [], [])->download('user.pdf');
    }

    public function bulk_upload(Request $request)
    {
        if ($request->hasFile('bulk_file')) {
            $import = new ProductsImport;
            Excel::import($import, request()->file('bulk_file'));
        }

        return back();
    }

    public function uploadDropshopProducts(Request $request)
    {
        $product_count = 0;
        $db_source = $request->input('db_source');
        $selected_products = $request->input('products');
        $commission_type = $request->input('commission_type');
        $commission_amount = $request->input('commission_amount');

        // Connect to the source database
        $sitesConnection = DB::connection('dynamic_db');
        $sitesConnection->getPdo()->exec("USE " . $db_source);

        // Fetch the selected products from the source database
        $source_products = $sitesConnection->table('products')
            ->whereIn('id', $selected_products)
            ->get();

        foreach ($source_products as $source_product) {
            $product_count += $this->handleProduct($source_product, $db_source, $commission_type, $commission_amount, $sitesConnection);
        }

        flash(translate($product_count . ' Products imported successfully.'))->success();
        return back();
    }

    private function handleProduct($source_product, $db_source, $commission_type, $commission_amount, $sitesConnection)
    {
        $existing_product = Product::where('remote_shop', $db_source)
            ->where('remote_id', $source_product->id)
            ->first();

        if ($existing_product) {
            // Assuming $new_product is already defined and has id and category_id attributes
            $productCategory = ProductCategory::firstOrNew(
                ['product_id' => $existing_product->id]
            );

            $productCategory->category_id = $existing_product->category_id;
            $productCategory->save();
            return 0;
        }

        $product_data = (array) $source_product;
        unset($product_data['id']); // Remove the ID to avoid conflicts
        $product_data['added_by'] = 'admin';
        $product_data['user_id'] = 1;

        $this->handleCategory($product_data, $source_product->category_id, $sitesConnection); // Set the category ID
        $this->handleProductBrand($product_data, $source_product->brand_id, $sitesConnection);
        $this->handleProductSlug($product_data, $source_product);
        $this->handleProductImages($product_data, $source_product, $sitesConnection);
        $this->adjustProductPrice($product_data, $source_product, $commission_type, $commission_amount);

        $product_data['remote_shop'] = $db_source;
        $product_data['remote_id'] = $source_product->id;
        unset($product_data['tiny_url']);

        $new_product = Product::create($product_data);

        // Assuming $new_product is already defined and has id and category_id attributes
        $productCategory = ProductCategory::firstOrNew(
            ['product_id' => $new_product->id]
        );

        $productCategory->category_id = $new_product->category_id;
        $productCategory->save();

        // Handle product stocks
        $this->handleProductStocks($source_product, $new_product->id, $sitesConnection, $commission_type, $commission_amount);

        return 1;
    }

    private function handleCategory(&$product_data, $source_category_id, $sitesConnection)
    {
        // Fetch the category from the source database
        $source_category = $sitesConnection->table('categories')
            ->where('id', $source_category_id)
            ->first();

        if (!$source_category) {
            return null; // Handle case where category doesn't exist in source database
        }

        // Check if the category already exists in your main database
        $existing_category = Category::where('slug', $source_category->slug)->first();

        if ($existing_category) {
            $product_data['category_id'] = $existing_category->id;
        } else {
            // Create new category if it doesn't exist
            $category_data = (array) $source_category;
            unset($category_data['id']); // Remove the ID to avoid conflicts
            unset($category_data['parent_id']);
            unset($category_data['level']);
            unset($category_data['order_level']);
            unset($category_data['commision_rate']);
            unset($category_data['banner']);
            unset($category_data['icon']);
            unset($category_data['cover_image']);
            unset($category_data['featured']);
            unset($category_data['top']);
            unset($category_data['created_at']);
            unset($category_data['updated_at']);

            $new_category = Category::create($category_data);
            $product_data['category_id'] = $new_category->id;; // Return newly created category ID
        }
    }


    private function handleProductBrand(&$product_data, $source_brand_id, $sitesConnection)
    {
        // Fetch the brand from the source database
        $source_brand = $sitesConnection->table('brands')
            ->where('id', $source_brand_id)
            ->first();

        if (!$source_brand) {
            return null; // Handle case where brand doesn't exist in source database
        }

        // Check if the brand already exists in your main database
        $existing_brand = Brand::where('slug', $source_brand->slug)->first();

        if ($existing_brand) {
            $product_data['brand_id'] = $existing_brand->id;
        } else {
            // Create new brand if it doesn't exist
            $brand_data = (array) $source_brand;
            unset($brand_data['id']); // Remove the ID to avoid conflicts
            unset($brand_data['logo']);
            unset($brand_data['top']);
            unset($brand_data['created_at']);
            unset($brand_data['updated_at']);

            $new_brand = Brand::create($brand_data);
            $product_data['brand_id'] = $new_brand->id;; // Return newly created brand ID
        }
    }

    private function handleProductSlug(&$product_data, $source_product)
    {
        $existing_slug_product = Product::where('slug', $source_product->slug)->first();

        if ($existing_slug_product) {
            $product_data['slug'] = $source_product->slug . '-' . rand(100, 999);
        }
    }

    private function handleProductImages(&$product_data, $source_product, $sitesConnection)
    {
        if ($source_product->photos) {
            $product_data['photos'] = $this->copyImages($source_product->photos, $sitesConnection);
        }

        if ($source_product->thumbnail_img) {
            $product_data['thumbnail_img'] = $this->copyImages($source_product->thumbnail_img, $sitesConnection);
        }
    }

    private function copyImages($image_ids, $sitesConnection)
    {
        $image_ids_array = explode(',', $image_ids);
        $new_images_array = [];

        foreach ($image_ids_array as $image_id) {
            $source_image = $sitesConnection->table('uploads')
                ->where('id', $image_id)
                ->first();

            if ($source_image) {
                $image_data = (array) $source_image;
                unset($image_data['id']); // Remove the ID to avoid conflicts
                $image_data['user_id'] = 1;
                $upload = Upload::create($image_data);
                $new_images_array[] = $upload->id;
            }
        }

        return implode(',', $new_images_array);
    }

    private function adjustProductPrice(&$product_data, $source_product, $commission_type, $commission_amount)
    {
        $unit_price = $source_product->unit_price;

        if ($commission_type == 'amount') {
            $adjusted_price = $unit_price + $commission_amount;
        } else if ($commission_type == 'percent') {
            $adjusted_price = $unit_price * (1 + $commission_amount / 100);
        } else {
            return; // Handle invalid commission type if necessary
        }

        $product_data['unit_price'] = $adjusted_price;
        $product_data['purchase_price'] = $adjusted_price;
    }

    private function handleProductStocks($source_product, $new_product_id, $sitesConnection, $commission_type, $commission_amount)
    {
        $source_stocks = $sitesConnection->table('product_stocks')
            ->where('product_id', $source_product->id)
            ->get();

        foreach ($source_stocks as $source_stock) {
            $stock_data = (array) $source_stock;
            unset($stock_data['id']); // Remove the ID to avoid conflicts
            $stock_data['product_id'] = $new_product_id; // Set the new product ID

            if ($commission_type == 'amount') {
                $stock_data['price'] +=  $commission_amount;
            } else if ($commission_type == 'percent') {
                $stock_data['price'] = $stock_data['price'] * (1 + $commission_amount / 100);
            }

            ProductStock::create($stock_data);
        }
    }

    public function updateDropshopProducts(Request $request)
    {
        $db_source = $request->input('db_source');
        $commission_type = $request->input('commission_type');
        $commission_amount = $request->input('commission_amount');

        // Establish connection to the source database
        $sitesConnection = DB::connection('dynamic_db');
        $sitesConnection->getPdo()->exec("USE " . $db_source);

        // Fetch products that have a remote shop and remote ID in the current database
        $products = Product::where('remote_shop', $db_source)
            ->whereNotNull('remote_id')
            ->get();

        foreach ($products as $product) {
            // Fetch the corresponding product from the source database
            $remote_product = $sitesConnection->table('products')
                ->find($product->remote_id);

            if ($remote_product) {
                //update price
                if ($commission_type == 'amount') {
                    $product->unit_price =  $remote_product->unit_price + $commission_amount;
                } else if ($commission_type == 'percent') {
                    $product->unit_price = $remote_product->unit_price * (1 + $commission_amount / 100);
                }

                // Update the current stock of the product
                $product->current_stock = $remote_product->current_stock;
                $product->save();

                // Delete existing product stocks for the product
                ProductStock::where('product_id', $product->id)->delete();

                // Fetch and recreate product stocks from the source database
                $remote_product_stocks = $sitesConnection->table('product_stocks')
                    ->where('product_id', $product->remote_id)
                    ->get();

                foreach ($remote_product_stocks as $stock) {
                    $stock_data = (array) $stock;
                    unset($stock_data['id']); // Remove the ID to avoid conflicts
                    $stock_data['product_id'] = $product->id; // Set the new product ID

                    if ($commission_type == 'amount') {
                        $stock_data['price'] +=  $commission_amount;
                    } else if ($commission_type == 'percent') {
                        $stock_data['price'] = $stock_data['price'] * (1 + $commission_amount / 100);
                    }

                    ProductStock::create($stock_data);
                }
            }
        }

        flash(translate(count($products) . ' Product stocks updated successfully.'))->success();
        return back();
    }
}
