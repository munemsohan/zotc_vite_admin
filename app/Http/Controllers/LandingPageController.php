<?php

namespace App\Http\Controllers;

use App\Models\CombinedOrder;
use App\Models\LandingPage;
use App\Models\LandingPageProduct;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ZillaLandingPage;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Product;
use App\Models\User;
use Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class LandingPageController extends Controller
{
    public function __construct()
    {
        // Staff Permission Check
        $this->middleware(['permission:add_website_page'])->only('create');
        $this->middleware(['permission:edit_website_page'])->only('edit');
        $this->middleware(['permission:delete_website_page'])->only('destroy');
    }

    public function index(Request $request)
    {
        $page = LandingPage::get();
        return view('backend.website_settings.landing-pages.index', compact('page'));
    }

    public function create()
    {
        $products  =  Product::get();
        return view('backend.website_settings.landing-pages.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));

        if (Page::where('slug', $slug)->exists() || LandingPage::where('slug', $slug)->exists()) {
            flash(translate('Slug has been used already'))->warning();
            return back();
        }

        $landingPage                = new LandingPage;
        $landingPage->title         = $request->title;
        $landingPage->slug          = $slug;
        $landingPage->shipping_type = $request->shipping_type;

        // Determine shipping info based on the shipping type
        if ($request->shipping_type == 'default') {
            $shipping_info = $this->getDefaultShippingInfo($request->product_id);
        } elseif ($request->shipping_type == 'custom') {
            $shipping_info = $this->getCustomShippingInfo($request);
        }

        if (!$shipping_info) {
            flash(translate('Invalid shipping info'))->error();
            return back();
        }

        $landingPage->shipping_info = json_encode($shipping_info);

        // Load page header and body content from files
        $header = 'public/landing-pages/landing-' . $request->page_content . '/header.html';
        $body = 'public/landing-pages/landing-' . $request->page_content . '/body.html';

        $landingPage->page_header = file_get_contents($header);
        $landingPage->page_body = file_get_contents($body);

        $landingPage->save();

        foreach ($request->product_id as $product_id) {
            $landingPageProduct                  = new LandingPageProduct;
            $landingPageProduct->landing_page_id = $landingPage->id;
            $landingPageProduct->product_id      = $product_id;
            $landingPageProduct->save();
        }

        flash(translate('New Landing Page has been created successfully'))->success();
        return redirect()->route('landing-pages.index');
    }

    protected function getDefaultShippingInfo($productIds)
    {
        $defaultShippingType = get_setting('shipping_type');
        if ($defaultShippingType == "product_wise_shipping") {
            $product = Product::findOrFail($productIds[0]);
            return ['shipping_cost' => $product->shipping_cost];
        } elseif ($defaultShippingType == "flat_rate") {
            $flatShippingCost = get_setting('flat_rate_shipping_cost');
            return ['shipping_cost' => $flatShippingCost];
        } else {
            $adminShippingCost = get_setting('shipping_cost_admin');
            return ['shipping_cost' => $adminShippingCost];
        }
    }

    protected function getCustomShippingInfo($request)
    {
        if ($request->filled('shipping_name') && $request->filled('shipping_cost')) {
            return array_combine($request->shipping_name, $request->shipping_cost);
        } else {
            return null;
        }
    }

    public function show($id)
    {
        //
    }

    public function edit(Request $request, $id)
    {
        $products = Product::get();  // Retrieve all products
        $landingPage = LandingPage::with('landingPageProducts.product')
            ->where('slug', $id)
            ->first();

        if ($landingPage->type == 'builder') {
            $folder = get_zotc_setting('img_slug');
            return view('backend.website_settings.landing-pages.builder2', compact('products', 'landingPage', 'folder'));
            // return view('backend.website_settings.landing-pages.builderjs', compact('products', 'landingPage', 'folder'));
        } else {
            return view('backend.website_settings.landing-pages.edit', compact('products', 'landingPage'));
        }
    }

    public function update(Request $request, $id)
    {
        $landingPage = LandingPage::findOrFail($id);

        $slugExists = LandingPage::where('slug', $request->slug)->where('id', '!=', $id)->exists();

        if (!$slugExists) {
            $landingPage->title = $request->title;
            $landingPage->slug             = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));
            $landingPage->shipping_type = $request->shipping_type;

            if ($request->shipping_type == 'default') {
                $defaultShippingType = get_setting('shipping_type');
                if ($defaultShippingType == "product_wise_shipping") {
                    $product  =  Product::findOrFail($request->product_id);
                    $shipping_info = ['Shipping Cost' => $product->shipping_cost];
                } elseif ($defaultShippingType == "flat_rate") {
                    $flatShippingCost = get_setting('flat_rate_shipping_cost');
                    $shipping_info = ['Shipping Cost' => $flatShippingCost];
                } else {
                    $adminShippingCost = get_setting('shipping_cost_admin');
                    $shipping_info = ['Shipping Cost' => $adminShippingCost];
                }
            } elseif ($request->shipping_type == 'custom') {
                if ($request->filled('shipping_name') && $request->filled('shipping_cost')) {
                    $shipping_info = array_combine($request->shipping_name, $request->shipping_cost);
                } else {
                    flash(translate('No Shipping Area is selected'))->error();
                    return back();
                }
            }

            $landingPage->shipping_info = json_encode($shipping_info);

            $landingPage->page_body =  $request->page_body;
            $landingPage->save();

            $existingProducts = LandingPageProduct::where('landing_page_id', $landingPage->id)->pluck('product_id')->toArray();

            $newProductIds = $request->product_id;

            // Find products to be deleted
            $productsToDelete = array_diff($existingProducts, $newProductIds);
            LandingPageProduct::where('landing_page_id', $landingPage->id)
                ->whereIn('product_id', $productsToDelete)
                ->delete();

            // Update or create new products
            foreach ($newProductIds as $product_id) {
                LandingPageProduct::updateOrCreate(
                    [
                        'landing_page_id' => $landingPage->id,
                        'product_id' => $product_id
                    ],
                    [
                        'landing_page_id' => $landingPage->id,
                        'product_id' => $product_id
                    ]
                );
            }


            flash(translate('Landing Page has been updated successfully'))->success();
            return redirect()->route('landing-pages.index');
        }

        flash(translate('Slug has been used already'))->warning();
        return back();
    }

    public function delete($id)
    {
        $landingPage = LandingPage::with('landingPageProducts')->findOrFail($id);

        // Delete the associated landing page products
        foreach ($landingPage->landingPageProducts as $product) {
            $product->delete();
        }

        // Delete the landing page
        if ($landingPage->type == 'builder') {
            ZillaLandingPage::where('landing_page_id', $landingPage->id)->delete();
        }

        // Delete the landing page
        if ($landingPage->delete()) {
            flash(translate('Landing page deleted successfully'))->success();

            return redirect()->route('landing-pages.index');
        } else {
            flash(translate('Failed to delete Landing Page'))->error();
            return redirect()->route('landing-pages.index');
        }
    }


    public function showLandingPage($slug)
    {
        $landingPage = ZillaLandingPage::where('code', $slug)->first();

        if ($landingPage) {
            $page               = $landingPage;
            $title              = 'Landing Pages';

            return view('frontend.landing_page_builder', compact('page', 'title'));
        }

        flash(translate('Failed to show Landing Page'))->error();
        return back();
    }

    public function orderLandingPage(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required',
            'shipping' => 'required',
            'name' => 'required',
            'phone' => 'required|min:11',
            'address' => 'required',
            'payment_option' => 'required',
            'payment_type' => 'required',
        ]);

        $user = User::where('phone', 'LIKE', '%' . $request->phone . '%')->first();

        if (!$user) {
            $password = substr(hash('sha512', rand()), 0, 8);
            $isEmailVerificationEnabled = get_setting('email_verification');

            $user = new User();
            $user->name = $request->name;
            $user->phone = $request->name;
            $user->password = Hash::make($password);
            $user->email_verified_at = $isEmailVerificationEnabled != 1 ? date('Y-m-d H:m:s') : null;

            $user->save();
        }

        $payment_option = $request->payment_option;

        $order = new Order();

        $order->shipping_address = json_encode([
            'name' => $request->name,
            'email' => '',
            'address' => $request->address,
            'country' => '',
            'state' => '',
            'city' => '',
            'postal_code' => '',
            'phone' => $request->phone,
            'lat_lang' => '',
        ]);

        $order->order_from = 'landing';
        $order->payment_type = $payment_option;
        $order->delivery_viewed = 0;
        $order->payment_status_viewed = 0;
        $order->date = strtotime('now');

        $subtotal = 0;

        for ($i = 0; $i < count($request->product_id); $i++) {
            $product = Product::findOrFail($request->product_id[$i]);
            $subtotal += $product->unit_price * $request->quantity[$i];

            $tax = 0;

            if ($product->tax_type == 'percent') {
                $tax = ($subtotal * $product->tax) / 100;
            } elseif ($product->tax_type == 'amount') {
                $tax = $product->tax;
            }

            $subtotal += $tax;
        }

        $shipping = $request->shipping;
        $order->grand_total = $subtotal + $shipping;
        $order->save();

        for ($i = 0; $i < count($request->product_id); $i++) {
            $product = Product::findOrFail($request->product_id[$i]);
            $order_detail = new OrderDetail();
            $order_detail->order_id = $order->id;
            $order_detail->seller_id = $product->user_id;
            $order_detail->product_id = $request->product_id[$i];
            $order_detail->price = $product->unit_price * $request->quantity[$i];
            $order_detail->shipping_type = 'home_delivery';
            $order_detail->shipping_cost = $request->shipping;
            $order_detail->quantity = $request->quantity[$i];

            if (addon_is_activated('club_point')) {
                $order_detail->earn_point = $product->earn_point;
            }

            $order_detail->save();
        }

        $combined_order = new CombinedOrder();
        $combined_order->user_id = $user->id;
        $combined_order->shipping_address = $order->shipping_address;
        $combined_order->grand_total = $order->grand_total;
        $combined_order->save();

        $id = $order->id;
        $remaining_digits = 8 - strlen($id);
        $random_number = rand(pow(10, $remaining_digits - 1), pow(10, $remaining_digits) - 1);
        $order->code = $random_number . $id;
        $order->combined_order_id = $combined_order->id;
        $order->save();

        if ($payment_option != 'cash_on_delivery') {
            $amount = 0;

            if ($request->payment_type == 'full') {
                $amount = $order_detail->price + $request->shipping;

                $request->session()->put('combined_order_id', $combined_order->id);
                $request->session()->put('payment_type', 'cart_payment');
            } elseif ($request->payment_type == 'minimum') {
                $minimumTotal = 0;

                $order_minimum_payment_amount = get_setting('order_minimum_payment_amount');

                if ($order_minimum_payment_amount > 0) {
                    $minimumTotal += $order_minimum_payment_amount;
                }

                for ($i = 0; $i < count($request->product_id); $i++) {
                    $product = Product::findOrFail($request->product_id[$i]);

                    $product_minimum_pay = $product->minimum_pay;

                    // $minimum_pay_with_shipping = $product->minimum_pay_with_shipping;
                    $minimum_pay_each_product = $product->minimum_pay_each_product;


                    if ($minimum_pay_each_product === 1) {
                        $minimumTotal += $request->quantity[$i] * $product_minimum_pay;
                    } else {
                        $minimumTotal += $product_minimum_pay;
                    }

                    // if ($minimum_pay_with_shipping === 1) {
                    //     $minimumTotal += $request->shipping;
                    // }
                }

                $minimumTotal += $request->shipping;

                $request->session()->put('combined_order_id', $combined_order->id);
                $request->session()->put('order_id', $order->id);
                $request->session()->put('user_id', $user->id);
                $request->session()->put('payment_type', 'partial_payment');
                $request->session()->put('payment_amount', $minimumTotal);
            }

            $decorator = __NAMESPACE__ . '\\Payment\\' . str_replace(' ', '', ucwords(str_replace('_', ' ', $request->payment_option))) . "Controller";
            if (class_exists($decorator)) {
                return (new $decorator)->pay($request);
            }
        }

        flash(translate('Order Confirmed Successfully'))->success();
        return view('frontend.order_confirmed', compact('combined_order'));
    }

    public function builderCreate()
    {
        $products  =  Product::get();
        return view('backend.website_settings.landing-pages.builder', compact('products'));
    }

    public function builderStore(Request $request)
    {
        if (empty($request->product_id)) {
            flash(translate('No Product is added for Landing Page'))->error();
            return back();
        }

        // Sanitize and format the slug
        $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', trim($request->slug)));

        // Check if the slug is already in use
        if (Page::where('slug', $slug)->exists() || LandingPage::where('slug', $slug)->exists()) {
            flash(translate('Slug has been used already'))->warning();
            return back();
        }

        $template_id = $request->page_content;

        if ($slug && $template_id !== null) {
            // Get the correct file path
            $jsonFilePath = public_path("modules/zillapage/assets/landingpage/json/pages/template-{$template_id}.json");

            // Check if the file exists
            if (!file_exists($jsonFilePath)) {
                flash(translate('Template file not found'))->error();
                return back();
            }

            // Find the template by ID
            $template = json_decode(file_get_contents($jsonFilePath));

            // Check if the template was found
            if ($template) {
                $landingPage = new LandingPage;
                $landingPage->title = $request->title;
                $landingPage->slug = $slug;
                $landingPage->end_date = $request->end_date;
                $landingPage->shipping_type = $request->shipping_type;

                // Determine shipping info based on the shipping type
                if ($request->shipping_type == 'default') {
                    $shipping_info = $this->getDefaultShippingInfo($request->product_id);
                } elseif ($request->shipping_type == 'custom') {
                    $shipping_info = $this->getCustomShippingInfo($request);
                }

                // Handle invalid shipping info
                if (!$shipping_info) {
                    flash(translate('Invalid shipping info'))->error();
                    return back();
                }

                $landingPage->shipping_info = json_encode($shipping_info);
                $landingPage->type = 'builder';
                $landingPage->save();

                // Landing page products save
                if (!empty($request->product_id)) {
                    foreach ($request->product_id as $product_id) {
                        $landingPageProduct = new LandingPageProduct;
                        $landingPageProduct->landing_page_id = $landingPage->id;
                        $landingPageProduct->product_id = $product_id;

                        // Check if the product_id is present in the $request->is_selected array values
                        $landingPageProduct->is_selected = in_array($product_id, $request->is_selected ?? []) ? 1 : 0;

                        $landingPageProduct->save();
                    }
                }

                // Check if the table exists, if not create by SQL file
                $template = replaceVarContentStyle($template);

                // Check if the zilla_landing_pages table exists before proceeding
                if (!Schema::hasTable('zilla_landing_pages')) {
                    DB::unprepared(file_get_contents(public_path('modules/zillapage/builder.sql')));
                }

                $imgSlug = get_zotc_setting('img_slug') ?: 'all';
                $path = public_path("uploads/{$imgSlug}/content_media");

                // Ensure the directory exists or create it
                if (!is_dir($path) && !mkdir($path, 0777, true)) {
                    error_log("Failed to create directory: {$path}");
                    return back();
                }

                // Define the source directory
                $sourceDir = public_path('modules/zillapage/assets/images/content_media');

                // Check if the source directory exists and is readable
                if (is_dir($sourceDir) && is_readable($sourceDir)) {
                    // Copy files recursively
                    $this->copyDir($sourceDir, $path);
                }

                // Create a new ZillaLandingPage record
                $zillaLandingPage = new ZillaLandingPage();
                $zillaLandingPage->landing_page_id = $landingPage->id;
                $zillaLandingPage->code = $slug;
                $zillaLandingPage->name = $request->title;
                $zillaLandingPage->html = $template->content;
                $zillaLandingPage->css = $template->style;

                // Save the ZillaLandingPage
                if ($zillaLandingPage->save()) {
                    flash(translate('Landing page added successfully'))->success();
                    return redirect()->route('landing-pages.index');
                } else {
                    flash(translate('Failed to add landing page'))->error();
                    return back();
                }
            } else {
                flash(translate('Template not found'))->error();
                return back();
            }
        }

        // Handle missing name or template ID
        flash('Name and Template is required')->error();
        return redirect()->route('landing-pages.builder.create');
    }

    private function copyDir($source, $destination)
    {
        if (!is_dir($source)) {
            error_log("Source directory does not exist: {$source}");
            return false;
        }

        if (!is_readable($source)) {
            error_log("Source directory is not readable: {$source}");
            return false;
        }

        // Ensure the destination directory is created with 755 permissions
        if (!is_dir($destination)) {
            if (!mkdir($destination, 0755, true)) {
                error_log("Failed to create destination directory: {$destination}");
                return false;
            }
        } else {
            chmod($destination, 0755);
        }

        $items = scandir($source);
        foreach ($items as $item) {
            if ($item !== '.' && $item !== '..') {
                $sourceItem = $source . '/' . $item;
                $destinationItem = $destination . '/' . $item;

                if (is_dir($sourceItem)) {
                    $this->copyDir($sourceItem, $destinationItem);
                } else {
                    if (!copy($sourceItem, $destinationItem)) {
                        error_log("Failed to copy file: {$sourceItem}");
                    } else {
                        chmod($destinationItem, 0755);
                    }
                }
            }
        }
    }

    public function builder($code)
    {
        $imgSlug = get_zotc_setting('img_slug') ?: 'all';
        // dd($imgSlug);

        //copy all images first
        $path = public_path("uploads/{$imgSlug}/content_media");
        // Define the source directory
        $sourceDir = public_path('modules/zillapage/assets/images/content_media');

        // Check if the source directory exists and is readable
        if (is_dir($sourceDir) && is_readable($sourceDir)) {
            // Copy files recursively
            $this->copyDir($sourceDir, $path);
        }

        if (!empty($code)) {
            $page = ZillaLandingPage::where('code', $code)->first();

            if ($page) {
                // Read the JSON file content
                $jsonFilePath = public_path('modules/zillapage/assets/landingpage/json/blocks.json'); // Get the correct file path

                // Use file_get_contents to read the JSON content
                $jsonContent = file_get_contents($jsonFilePath);

                // Decode JSON into an array
                $blocks = json_decode($jsonContent, true); // Decoding the JSON into an array

                $arr_blocks = [];

                foreach ($blocks as $item) {
                    $arr_temp = [];
                    $arr_temp['id'] = $item['id'];
                    $arr_temp['thumb'] = url('public/modules/zillapage/assets/images/thumb_blocks') . "/" . $item['thumb'];
                    $arr_temp['name'] = $item['name'];
                    $arr_temp['block_category'] = $item['block_category'];
                    $arr_temp['content'] = "`" . replaceVarContentStyle($item['content']) . "`";
                    array_push($arr_blocks, $arr_temp);
                }

                // Path to the settings.json file
                $jsonFilePath = public_path('modules/zillapage/assets/landingpage/json/settings.json'); // Adjust path if necessary

                // Use file_get_contents to read the JSON content
                $jsonContent = file_get_contents($jsonFilePath);

                // Decode JSON into an array
                $settings = json_decode($jsonContent, true); // Decoding the JSON into an array

                $all_icons = null;

                // Loop through the settings array to find the row where the 'key' is 'app-icons'
                foreach ($settings as $setting) {
                    if (isset($setting['key']) && $setting['key'] === 'app-icons') {
                        $all_icons = $setting['value']; // Get the 'value' field for 'app-icons'
                        break; // Exit loop once found
                    }
                }

                $all_icons = json_decode($all_icons);

                $images_url = getAllImagesContentMedia();
                $title      = "Builder " . $page->name;
                // $page       = $page;
                $blocks     = json_encode($arr_blocks, JSON_HEX_QUOT | JSON_HEX_TAG);
                // $all_icons  = $all_icons;
                $images_url = json_encode($images_url, JSON_HEX_QUOT | JSON_HEX_TAG);

                return view('backend.website_settings.landing-pages.buildergrape', compact('title', 'page', 'blocks', 'all_icons', 'images_url'));
            } else {
            }
        } else {
        }
    }

    public function builderUpdate(Request $request)
    {
        $code = $request->query('code');

        if ($code) {
            $item = ZillaLandingPage::where('code', $code)->first();

            if ($item) {
                $item->components = $request->input('gjs-components');
                $item->styles = $request->input('gjs-styles');
                $item->html = $request->input('gjs-html');
                $item->css = $request->input('gjs-css');
                $item->main_page_script = $request->input('main_page_script');

                // update the landing page
                $item->save();

                return response()->json(['success' => 'Updated Successfully']);
            } else {
                return response()->json(['error' => 'Code Not Found']);
            }
        }
        return response()->json(['error' => 'fail']);
    }

    public function builderLoad($code)
    {
        if ($code) {
            // Retrieve the page by its code using Eloquent
            $page = ZillaLandingPage::where('code', $code)->first();

            if ($page) {
                // Return a JSON response with the page data
                return response()->json([
                    'gjs-components' => $page->components,
                    'gjs-styles' => $page->styles,
                    'gjs-html' => $page->html,
                    'gjs-css' => $page->css
                ]);
            }
        }
        // Return an error if no code is provided or if no page is found
        return response()->json(['error' => __('not_found_code')]);
    }

    public function builderUploadImage(Request $request)
    {
        $file = $request->file('files');
        $extension = strtolower($file->getClientOriginalExtension());

        $imgSlug = get_zotc_setting('img_slug') ?: 'all';

        // Define the storage path
        $path = public_path("uploads/{$imgSlug}/content_media");

        $newName = 'upload_' . time() . '.' . $extension;
        $uploadedPath = url("public/uploads/{$imgSlug}/content_media/{$newName}");

        // Attempt to move the file
        try {
            $file->move($path, $newName);
            echo json_encode($uploadedPath);
            die;
            // return response()->json(['url' => $uploadedPath]);
        } catch (\Exception $e) {
            // Log the error or handle it as required
            return response()->json(['error' => 'Failed to store the file: ' . $e->getMessage()], 500);
        }
    }

    public function builderDeleteImage(Request $request)
    {
        $imgSlug = get_zotc_setting('img_slug') ?: 'all';

        // Define the storage path
        $fileDirectory = public_path("uploads/{$imgSlug}/content_media");

        // Extract the image name from the URL provided in the request.
        $linkArray = explode('/', $request->input('image_src'));
        $imageName = end($linkArray);

        // Construct the full path of the image.
        $path = storage_path('app/' . $fileDirectory . '/' . $imageName);

        // Check if the file exists and delete it.
        if (File::exists($path)) {
            File::delete($path);
        }

        // Return the name of the deleted image or an error message in JSON format.
        return response()->json($imageName);
    }

    public function builderSearchIcon(Request $request)
    {
        $keyword = $request->input('keyword');

        // Path to the settings.json file
        $jsonFilePath = public_path('modules/zillapage/assets/landingpage/json/settings.json'); // Adjust path if necessary

        // Use file_get_contents to read the JSON content
        $jsonContent = file_get_contents($jsonFilePath);

        // Decode JSON into an array
        $settings = json_decode($jsonContent, true); // Decoding the JSON into an array

        $all_icons = null;

        // Loop through the settings array to find the row where the 'key' is 'app-icons'
        foreach ($settings as $setting) {
            if (isset($setting['key']) && $setting['key'] === 'app-icons') {
                $all_icons = $setting['value']; // Get the 'value' field for 'app-icons'
                break; // Exit loop once found
            }
        }

        $data = json_decode($all_icons);
        $response = "";

        if ($keyword) {
            $input = preg_quote($keyword, '~');
            $result = preg_grep('~' . $input . '~', $data);

            foreach ($result as $value) {
                $response .= '<i class="' . $value . '"></i>';
            }
        } else {
            foreach ($data as $value) {
                $response .= '<i class="' . $value . '"></i>';
            }
        }

        return response()->json(['result' => $response]);
    }

    public function builderSetting(Request $request, $code = '')
    {
        if ($request->isMethod('post') && $code != '') {
            $page = ZillaLandingPage::where('code', $code)->first();

            if ($page) {
                $data = $request->all();

                if ($page->update($data)) {
                    return redirect()->route('admin.zillapage.landingpages.setting', $code)
                        ->with('success', __('updated_successfully'));
                } else {
                    return redirect()->route('admin.zillapage.landingpages.setting', $code)
                        ->with('warning', __('problem_updating'));
                }
            } else {
                abort(404);
            }
        }

        $page = ZillaLandingPage::where('code', $code)->first();

        if ($page) {
            // $title = strtoupper($page->name);
            // $roles = Role::all();
            // $members = User::where('active', 1)->where('is_not_staff', 0)->get();

            // return View::make('landingpages.setting', [
            //     'item' => $page,
            //     'title' => $title,
            //     'roles' => $roles,
            //     'members' => $members
            // ]);
        } else {
            abort(404);
        }
    }

    public function getBlockCss()
    {
        // Path to the settings.json file
        $jsonFilePath = public_path('modules/zillapage/assets/landingpage/json/settings.json');

        // Use file_get_contents to read the JSON content
        $jsonContent = file_get_contents($jsonFilePath);

        // Decode JSON into an array
        $settings = json_decode($jsonContent, true);

        $all_icons = null;

        // Loop through the settings array to find the row where the 'key' is 'app-icons'
        foreach ($settings as $setting) {
            if (isset($setting['key']) && $setting['key'] === 'blockscss') {
                $all_icons = $setting['value'];
                break;
            }
        }

        $blocksCssSetting = json_decode($all_icons);

        $blockscss = replaceVarContentStyle($blocksCssSetting);

        return response($blockscss)->header('Content-Type', 'text/css');
    }

    public function getPageJson(Request $request)
    {
        // Get the '_code' from the POST request
        $code = $request->input('_code'); // Assuming '_code' is coming from the request

        // Fetch the landing page by code from the model
        $page = ZillaLandingPage::where('code', $code)->first();

        // Check if the page exists and is published
        if ($page) {
            // Path to the settings.json file
            $jsonFilePath = public_path('modules/zillapage/assets/landingpage/json/settings.json'); // Adjust path if necessary

            // Use file_get_contents to read the JSON content
            $jsonContent = file_get_contents($jsonFilePath);

            // Decode JSON into an array
            $settings = json_decode($jsonContent, true); // Decoding the JSON into an array

            $all_icons = null;

            // Loop through the settings array to find the row where the 'key' is 'app-icons'
            foreach ($settings as $setting) {
                if (isset($setting['key']) && $setting['key'] === 'blockscss') {
                    $all_icons = $setting['value']; // Get the 'value' field for 'app-icons'
                    break; // Exit loop once found
                }
            }

            $blocksCssSetting = json_decode($all_icons);

            $blockscss = replaceVarContentStyle($blocksCssSetting);

            // Return the response as JSON
            return response()->json([
                'blockscss' => $blockscss,
                'css' => $page->css,
                'html' => html_entity_decode($page->html),
                'custom_header' => $page->custom_header,
                'custom_footer' => $page->custom_footer,
                'thank_you_page_css' => $page->thank_you_page_css,
                'thank_you_page_html' => html_entity_decode($page->thank_you_page_html),
                'main_page_script' => $page->main_page_script,
            ]);
        }

        // Return a 404 response if the page is not found
        return response()->json([
            'error' => 'Page not found or it is not published.'
        ], 404);
    }

    public function getBuilderLandingPageProducts($slug)
    {
        $landingPage = LandingPage::with('landingPageProducts', 'landingPageProducts.product')->where('slug', $slug)->first();

        return view('frontend.landing_page_products', compact('landingPage'));
    }

    // public function builder_store(Request $request)
    // {
    //     // Sanitize and format the slug
    //     $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));

    //     // Check if the slug is already in use
    //     if (Page::where('slug', $slug)->exists() || LandingPage::where('slug', $slug)->exists()) {
    //         flash(translate('Slug has been used already'))->warning();
    //         return back();
    //     }

    //     // Generate unique file names for HTML
    //     $timestamp = time();
    //     $uploadFolder = get_zotc_setting('img_slug');
    //     $htmlPath = "uploads/{$uploadFolder}/html";

    //     $sourceHtml = public_path('assets/landing_asset/pages/landing-' . $request->page_content . '.html');
    //     $htmlFileName = "{$slug}-{$timestamp}.html";
    //     $fullHtmlPath = public_path("{$htmlPath}/{$htmlFileName}");

    //     // Ensure the directory exists or create it
    //     if (!File::isDirectory(public_path($htmlPath))) {
    //         File::makeDirectory(public_path($htmlPath), 0775, true);
    //     }

    //     // Copy the contents from source file to the destination
    //     if (File::exists($sourceHtml)) {
    //         $htmlContent = File::get($sourceHtml);
    //         File::put($fullHtmlPath, $htmlContent);
    //     } else {
    //         flash(translate('Source file not found'))->error();
    //         return back();
    //     }

    //     // Create a new landing page entry
    //     $landingPage = new LandingPage;
    //     $landingPage->title = $request->title;
    //     $landingPage->slug = $slug;
    //     $landingPage->shipping_type = $request->shipping_type;

    //     // Determine shipping info based on the shipping type
    //     $shipping_info = null;
    //     if ($request->shipping_type == 'default') {
    //         $shipping_info = $this->getDefaultShippingInfo($request->product_id);
    //     } elseif ($request->shipping_type == 'custom') {
    //         $shipping_info = $this->getCustomShippingInfo($request);
    //     }

    //     if (!$shipping_info) {
    //         flash(translate('Invalid shipping info'))->error();
    //         return back();
    //     }

    //     $landingPage->shipping_info = json_encode($shipping_info);
    //     $landingPage->page_body = $htmlFileName;  // Store only the filename
    //     $landingPage->type = 'builder';

    //     // Save the landing page
    //     $landingPage->save();

    //     // Associate products with the landing page
    //     foreach ($request->product_id as $product_id) {
    //         $landingPageProduct = new LandingPageProduct;
    //         $landingPageProduct->landing_page_id = $landingPage->id;
    //         $landingPageProduct->product_id = $product_id;
    //         $landingPageProduct->save();
    //     }

    //     flash(translate('New Landing Page has been created successfully'))->success();
    //     return redirect()->route('landing-pages.index');
    // }

    // public function builder_update(Request $request)
    // {
    //     $folder = get_zotc_setting('img_slug');
    //     $fullHtmlPath = public_path('uploads/' . $folder . '/html/' . $request->file_name);

    //     if ($request->filled('html')) {
    //         File::put($fullHtmlPath, $request->html);
    //     }

    //     flash(translate('Landing Page has been updated successfully'))->success();
    //     return redirect()->route('landing-pages.index');
    // }

    // public function builder_update(Request $request)
    // {
    //     // dd($request->css_content);
    //     $id = $request->id;
    //     $landingPage = LandingPage::findOrFail($id);

    //     // Check if another page with the same slug exists
    //     $slugExists = LandingPage::where('slug', $request->slug)->where('id', '!=', $id)->exists();
    //     if ($slugExists) {
    //         flash(translate('Slug has been used already'))->error();
    //         return back();
    //     }

    //     // Update basic information
    //     $landingPage->title = $request->title;
    //     $landingPage->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));
    //     $landingPage->shipping_type = $request->shipping_type;

    //     // Determine shipping info based on the shipping type
    //     $shipping_info = null;
    //     if ($request->shipping_type == 'default') {
    //         $shipping_info = $this->getDefaultShippingInfo($request->product_id);
    //     } elseif ($request->shipping_type == 'custom') {
    //         $shipping_info = $this->getCustomShippingInfo($request);
    //     }

    //     // Validate shipping info
    //     if (!$shipping_info) {
    //         flash(translate('Invalid shipping info'))->error();
    //         return back();
    //     }

    //     // Encode shipping info to JSON and save
    //     $landingPage->shipping_info = json_encode($shipping_info);

    //     // Get the domain to determine paths
    //     $domain = get_domain();
    //     $cssPath = "landing-pages/{$domain}/css";
    //     $htmlPath = "landing-pages/{$domain}/html";

    //     // Retrieve the full paths to the files
    //     $fullCssPath = public_path("{$cssPath}/" . $landingPage->page_header);
    //     $fullHtmlPath = public_path("{$htmlPath}/" . $landingPage->page_body);


    //     // Validate CSS and HTML content before saving
    //     if ($request->filled('css_content')) {
    //         File::put($fullCssPath, $request->css_content);
    //     }

    //     if ($request->filled('html_content')) {
    //         File::put($fullHtmlPath, $request->html_content);
    //     }

    //     // Save all updates to the database
    //     $landingPage->save();

    //     flash(translate('Landing Page has been updated successfully'))->success();
    //     return redirect()->route('landing-pages.index');
    // }

    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $files = $request->file('file');

            $timestamp = time();
            $uploadFolder = get_zotc_setting('img_slug');
            $mediaPath = "uploads/{$uploadFolder}/media";
            $fullMediaPath = public_path($mediaPath);

            // Ensure the directory exists or create it
            if (!File::isDirectory($fullMediaPath)) {
                File::makeDirectory($fullMediaPath, 0775, true);
            }

            foreach ($files as $file) {
                // Generate a unique filename to avoid overwriting existing files
                $filename = $timestamp . '_' . $file->getClientOriginalName();

                // Store the file in the specified directory
                $file->move($fullMediaPath, $filename);
            }
            flash(translate('Files uploaded successfully.'))->success();
        }

        return response()->json(['success' => false, 'message' => 'No files uploaded.'], 400);
    }

    public function scanMedia()
    {
        // Define the directory to scan for media files
        $uploadFolder = get_zotc_setting('img_slug');
        $directory = public_path("uploads/{$uploadFolder}/media");

        // Check if the directory exists
        if (!File::isDirectory($directory)) {
            return response()->json(['error' => 'Directory not found'], 404);
        }

        // Get a list of files in the directory
        $files = File::allFiles($directory);

        // Prepare media data
        $mediaData = [];

        foreach ($files as $file) {
            // Extract file name and path
            $fileName = $file->getFilename();
            $filePath = url('public/uploads/' . $uploadFolder . '/media/' . $fileName);

            // Add file information to the media data array
            $mediaData[] = [
                'name' => $fileName,
                'path' => $filePath
            ];
        }

        // Return media data as JSON
        return response()->json($mediaData);
    }
}
