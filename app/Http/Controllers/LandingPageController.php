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

    public function store(Request $request)
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
                $landingPage->end_time = $request->end_time;
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
        return redirect()->route('landing-pages.create');
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

    public function edit($id)
    {
        $products  =  Product::get();

        $landingPage = LandingPage::with('landingPageProducts.product')
            ->where('id', $id)
            ->first();

        return view('backend.website_settings.landing-pages.edit', compact('products', 'landingPage'));
    }

    public function update(Request $request)
    {
        $landing_page_id = $request->landing_page_id;

        if (empty($request->product_id)) {
            flash(translate('No Product is added for Landing Page'))->error();
            return back();
        }

        // Find existing Landing Page or create a new one
        $landingPage = LandingPage::find($landing_page_id);
        if (!$landingPage) {
            flash(translate('No Landing Page is found'))->error();
            return back();
        }

        // Sanitize and format the slug
        $slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', trim($request->slug)));

        // Check if the slug is already in use by another page
        if (
            Page::where('slug', $slug)->exists() ||
            LandingPage::where('slug', $slug)->where('id', '!=', $landing_page_id)->exists()
        ) {
            flash(translate('Slug has been used already'))->warning();
            return back();
        }

        // Update landing page data
        $landingPage->title = $request->title;
        $landingPage->slug = $slug;
        $landingPage->end_time = $request->end_time;
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

        // Save/Update Landing Page Products
        $existingProductIds = LandingPageProduct::where('landing_page_id', $landingPage->id)->pluck('product_id')->toArray();
        $newProductIds = $request->product_id ?? [];

        // Remove products that are no longer associated
        LandingPageProduct::where('landing_page_id', $landingPage->id)
            ->whereNotIn('product_id', $newProductIds)
            ->delete();

        // Add or update selected products
        foreach ($newProductIds as $product_id) {
            $landingPageProduct = LandingPageProduct::firstOrNew([
                'landing_page_id' => $landingPage->id,
                'product_id' => $product_id
            ]);

            // Check if the product is selected
            $landingPageProduct->is_selected = in_array($product_id, $request->is_selected ?? []) ? 1 : 0;
            $landingPageProduct->save();
        }

        // Save or update ZillaLandingPage record
        $zillaLandingPage = ZillaLandingPage::firstOrNew(['landing_page_id' => $landingPage->id]);
        $zillaLandingPage->code = $slug;
        $zillaLandingPage->name = $request->title;

        if ($zillaLandingPage->save()) {
            flash(translate('Landing page updated successfully'))->success();
            return redirect()->route('landing-pages.index');
        } else {
            flash(translate('Failed to update landing page'))->error();
            return back();
        }
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
                $landingPage->end_time = $request->end_time;
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

    public function builderEdit($code)
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
