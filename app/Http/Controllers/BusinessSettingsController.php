<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessSetting;
use App\Models\Upload;
use App\Models\ZotcSetting;
use Artisan;
use CoreComponentRepository;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Str;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;

class BusinessSettingsController extends Controller
{
    public function __construct()
    {
        // Staff Permission Check
        $this->middleware(['permission:seller_commission_configuration'])->only('vendor_commission');
        $this->middleware(['permission:seller_verification_form_configuration'])->only('seller_verification_form');
        $this->middleware(['permission:general_settings'])->only('general_setting');
        $this->middleware(['permission:features_activation'])->only('activation');
        $this->middleware(['permission:smtp_settings'])->only('smtp_settings');
        $this->middleware(['permission:payment_methods_configurations'])->only('payment_method');
        $this->middleware(['permission:order_configuration'])->only('order_configuration');
        $this->middleware(['permission:file_system_&_cache_configuration'])->only('file_system');
        $this->middleware(['permission:social_media_logins'])->only('social_login');
        $this->middleware(['permission:facebook_chat'])->only('facebook_chat');
        $this->middleware(['permission:facebook_comment'])->only('facebook_comment');
        $this->middleware(['permission:analytics_tools_configuration'])->only('google_analytics');
        $this->middleware(['permission:google_recaptcha_configuration'])->only('google_recaptcha');
        $this->middleware(['permission:google_map_setting'])->only('google_map');
        $this->middleware(['permission:google_firebase_setting'])->only('google_firebase');
        $this->middleware(['permission:shipping_configuration'])->only('shipping_configuration');
    }

    public function general_setting(Request $request)
    {
        CoreComponentRepository::instantiateShopRepository();
        CoreComponentRepository::initializeCache();
        return view('backend.setup_configurations.general_settings');
    }

    public function activation(Request $request)
    {
        CoreComponentRepository::instantiateShopRepository();
        CoreComponentRepository::initializeCache();
        return view('backend.setup_configurations.activation');
    }

    public function domain()
    {
        $domain = BusinessSetting::where('type', 'domains')->first();

        if ($domain) {
            $domains = json_decode($domain->value);
        }

        return view('backend.domain', compact('domains'));
    }

    public function social_login(Request $request)
    {
        CoreComponentRepository::instantiateShopRepository();
        CoreComponentRepository::initializeCache();
        return view('backend.setup_configurations.social_login');
    }

    public function smtp_settings(Request $request)
    {
        CoreComponentRepository::instantiateShopRepository();
        CoreComponentRepository::initializeCache();
        return view('backend.setup_configurations.smtp_settings');
    }

    public function google_analytics(Request $request)
    {
        CoreComponentRepository::instantiateShopRepository();
        CoreComponentRepository::initializeCache();
        return view('backend.setup_configurations.google_configuration.google_analytics');
    }

    public function google_recaptcha(Request $request)
    {
        CoreComponentRepository::instantiateShopRepository();
        CoreComponentRepository::initializeCache();
        return view('backend.setup_configurations.google_configuration.google_recaptcha');
    }

    public function google_map(Request $request)
    {
        CoreComponentRepository::instantiateShopRepository();
        CoreComponentRepository::initializeCache();
        return view('backend.setup_configurations.google_configuration.google_map');
    }

    public function google_firebase(Request $request)
    {
        CoreComponentRepository::instantiateShopRepository();
        CoreComponentRepository::initializeCache();
        return view('backend.setup_configurations.google_configuration.google_firebase');
    }

    public function facebook_chat(Request $request)
    {
        CoreComponentRepository::instantiateShopRepository();
        CoreComponentRepository::initializeCache();
        return view('backend.setup_configurations.facebook_chat');
    }

    public function facebook_comment(Request $request)
    {
        CoreComponentRepository::instantiateShopRepository();
        CoreComponentRepository::initializeCache();
        return view('backend.setup_configurations.facebook_configuration.facebook_comment');
    }

    public function payment_method(Request $request)
    {
        CoreComponentRepository::instantiateShopRepository();
        CoreComponentRepository::initializeCache();
        return view('backend.setup_configurations.payment_method');
    }

    public function file_system(Request $request)
    {
        CoreComponentRepository::instantiateShopRepository();
        CoreComponentRepository::initializeCache();
        return view('backend.setup_configurations.file_system');
    }

    /**
     * Update the API key's for payment methods.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function payment_method_update(Request $request)
    {
        foreach ($request->types as $key => $type) {
            $this->overWriteEnvFile($type, $request[$type]);
        }

        $business_settings = BusinessSetting::where('type', $request->payment_method . '_sandbox')->first();
        if ($business_settings != null) {
            if ($request->has($request->payment_method . '_sandbox')) {
                $business_settings->value = 1;
                $business_settings->save();
            } else {
                $business_settings->value = 0;
                $business_settings->save();
            }
        }

        Artisan::call('cache:clear');

        flash(translate("Settings updated successfully"))->success();
        return back();
    }

    /**
     * Update the API key's for GOOGLE analytics.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function google_analytics_update(Request $request)
    {
        foreach ($request->types as $key => $type) {
            $this->overWriteEnvFile($type, $request[$type]);
        }

        $business_settings = BusinessSetting::where('type', 'google_analytics')->first();

        if ($request->has('google_analytics')) {
            $business_settings->value = 1;
            $business_settings->save();
        } else {
            $business_settings->value = 0;
            $business_settings->save();
        }

        Artisan::call('cache:clear');

        flash(translate("Settings updated successfully"))->success();
        return back();
    }

    public function google_recaptcha_update(Request $request)
    {
        foreach ($request->types as $key => $type) {
            $this->overWriteEnvFile($type, $request[$type]);
        }

        $business_settings = BusinessSetting::where('type', 'google_recaptcha')->first();

        if ($request->has('google_recaptcha')) {
            $business_settings->value = 1;
            $business_settings->save();
        } else {
            $business_settings->value = 0;
            $business_settings->save();
        }

        Artisan::call('cache:clear');

        flash(translate("Settings updated successfully"))->success();
        return back();
    }

    public function google_map_update(Request $request)
    {
        foreach ($request->types as $key => $type) {
            $this->overWriteEnvFile($type, $request[$type]);
        }

        $business_settings = BusinessSetting::where('type', 'google_map')->first();

        if ($request->has('google_map')) {
            $business_settings->value = 1;
            $business_settings->save();
        } else {
            $business_settings->value = 0;
            $business_settings->save();
        }

        Artisan::call('cache:clear');

        flash(translate("Settings updated successfully"))->success();
        return back();
    }

    public function google_firebase_update(Request $request)
    {
        foreach ($request->types as $key => $type) {
            $this->overWriteEnvFile($type, $request[$type]);
        }

        $business_settings = BusinessSetting::where('type', 'google_firebase')->first();

        if ($request->has('google_firebase')) {
            $business_settings->value = 1;
            $business_settings->save();
        } else {
            $business_settings->value = 0;
            $business_settings->save();
        }

        Artisan::call('cache:clear');

        flash(translate("Settings updated successfully"))->success();
        return back();
    }


    /**
     * Update the API key's for GOOGLE analytics.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function facebook_chat_update(Request $request)
    {
        foreach ($request->types as $key => $type) {
            $this->overWriteEnvFile($type, $request[$type]);
        }

        $business_settings = BusinessSetting::where('type', 'facebook_chat')->first();

        if ($request->has('facebook_chat')) {
            $business_settings->value = 1;
            $business_settings->save();
        } else {
            $business_settings->value = 0;
            $business_settings->save();
        }

        Artisan::call('cache:clear');

        flash(translate("Settings updated successfully"))->success();
        return back();
    }

    public function tawk_chat_update(Request $request)
    {
        foreach ($request->types as $key => $type) {
            $this->overWriteEnvFile($type, $request[$type]);
        }

        $business_settings = BusinessSetting::where('type', 'tawk_chat')->first();

        if ($request->has('tawk_chat')) {
            $business_settings->value = 1;
            $business_settings->save();
        } else {
            $business_settings->value = 0;
            $business_settings->save();
        }

        Artisan::call('cache:clear');

        flash(translate("Settings updated successfully"))->success();
        return back();
    }

    public function whatsapp_update(Request $request)
    {
        foreach ($request->types as $key => $type) {
            $request[$type] = formatPhoneNumberWithoutPlus($request[$type]);
            $this->overWriteEnvFile($type, $request[$type]);
        }

        $business_settings = BusinessSetting::where('type', 'whatsapp')->first();

        if (!$business_settings) {
            $business_settings = new BusinessSetting();
            $business_settings->type = 'whatsapp';
        }

        if ($request->has('whatsapp')) {
            $business_settings->value = 1;
            $business_settings->save();
        } else {
            $business_settings->value = 0;
            $business_settings->save();
        }

        Artisan::call('cache:clear');

        flash(translate("Settings updated successfully"))->success();
        return back();
    }

    public function facebook_comment_update(Request $request)
    {
        foreach ($request->types as $key => $type) {
            $this->overWriteEnvFile($type, $request[$type]);
        }

        $business_settings = BusinessSetting::where('type', 'facebook_comment')->first();
        if (!$business_settings) {
            $business_settings = new BusinessSetting;
            $business_settings->type = 'facebook_comment';
        }

        $business_settings->value = 0;
        if ($request->facebook_comment) {
            $business_settings->value = 1;
        }

        $business_settings->save();

        Artisan::call('cache:clear');

        flash(translate("Settings updated successfully"))->success();
        return back();
    }

    public function gtag_update(Request $request)
    {
        foreach ($request->types as $key => $type) {
            $this->overWriteEnvFile($type, $request[$type]);
        }

        $business_settings = BusinessSetting::where('type', 'gtag')->first();

        if ($business_settings) {
            if ($request->has('gtag')) {
                $business_settings->value = 1;
            } else {
                $business_settings->value = 0;
            }
            $business_settings->save();
        } else {
            $business_settings = new BusinessSetting();
            $business_settings->type = 'gtag';
            if ($request->has('gtag')) {
                $business_settings->value = 1;
            } else {
                $business_settings->value = 0;
            }

            $business_settings->save();
        }

        Artisan::call('cache:clear');

        flash(translate("Settings updated successfully"))->success();
        return back();
    }

    public function facebook_pixel_update(Request $request)
    {
        foreach ($request->types as $key => $type) {
            $this->overWriteEnvFile($type, $request[$type]);
        }

        $business_settings = BusinessSetting::where('type', 'facebook_pixel')->first();

        if ($request->has('facebook_pixel')) {
            $business_settings->value = 1;
            $business_settings->save();
        } else {
            $business_settings->value = 0;
            $business_settings->save();
        }

        Artisan::call('cache:clear');

        flash(translate("Settings updated successfully"))->success();
        return back();
    }

    public function facebook_domain_verification_update(Request $request)
    {
        foreach ($request->types as $key => $type) {
            $this->overWriteEnvFile($type, $request[$type]);
        }

        Artisan::call('cache:clear');

        flash(translate("Settings updated successfully"))->success();
        return back();
    }

    /**
     * Update the API key's for other methods.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function env_key_update(Request $request)
    {
        foreach ($request->types as $key => $type) {
            $this->overWriteEnvFile($type, $request[$type]);
        }

        flash(translate("Settings updated successfully"))->success();
        return back();
    }

    /**
     * overWrite the Env File values.
     * @param  String type
     * @param  String value
     * @return \Illuminate\Http\Response
     */
    public function overWriteEnvFile($type, $val)
    {
        // Ensure the function doesn't execute in demo mode
        if (env('DEMO_MODE') === 'On') {
            return;
        }

        $envFile = base_path('.env');

        if (file_exists($envFile)) {
            $val = '"' . trim($val) . '"';
            if (is_numeric(strpos(file_get_contents($envFile), $type)) && strpos(file_get_contents($envFile), $type) >= 0) {
                file_put_contents($envFile, str_replace(
                    $type . '="' . env($type) . '"',
                    $type . '=' . $val,
                    file_get_contents($envFile)
                ));
            } else {
                file_put_contents($envFile, file_get_contents($envFile) . "\r\n" . $type . '=' . $val);
            }
        }
    }

    public function mail_update(Request $request)
    {

        foreach ($request->types as $key => $type) {

            if ($request[$type] != NULL) {
                $this->overWriteEnvFile($type, $request[$type]);
            }
        }

        flash(translate("Mail Settings updated successfully"))->success();
        return back();
    }

    public function seller_verification_form(Request $request)
    {
        return view('backend.sellers.seller_verification_form.index');
    }

    /**
     * Update sell verification form.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function seller_verification_form_update(Request $request)
    {
        $form = array();
        $select_types = ['select', 'multi_select', 'radio'];
        $j = 0;
        for ($i = 0; $i < count($request->type); $i++) {
            $item['type'] = $request->type[$i];
            $item['label'] = $request->label[$i];
            if (in_array($request->type[$i], $select_types)) {
                $item['options'] = json_encode($request['options_' . $request->option[$j]]);
                $j++;
            }
            array_push($form, $item);
        }
        $business_settings = BusinessSetting::where('type', 'verification_form')->first();
        $business_settings->value = json_encode($form);
        if ($business_settings->save()) {
            Artisan::call('cache:clear');

            flash(translate("Verification form updated successfully"))->success();
            return back();
        }
    }

    public function update(Request $request)
    {
        // dd($request->all());
        foreach ($request->types as $key => $type) {
            if ($type == 'site_name') {
                $this->overWriteEnvFile('APP_NAME', $request[$type]);
            }
            if ($type == 'timezone') {
                $this->overWriteEnvFile('APP_TIMEZONE', $request[$type]);
            } else {
                $lang = null;
                if (gettype($type) == 'array') {
                    $lang = array_key_first($type);
                    $type = $type[$lang];
                    $business_settings = BusinessSetting::where('type', $type)->where('lang', $lang)->first();
                } else {
                    $business_settings = BusinessSetting::where('type', $type)->first();
                }

                if ($request->home_slider_images && count($request->home_slider_images) > 0) {
                    foreach ($request->home_slider_images as $image_id) {
                        $imageUpload = Upload::find($image_id);

                        // Ensure the image exists in the database
                        if ($imageUpload) {
                            $imagePath = $imageUpload->file_name;
                            $thumbnailPath = $imageUpload->thumbnail;

                            $randomFilename = Str::random(10);

                            // Process main image if it exists and needs resizing
                            $processedImagePath = $this->processImage($randomFilename, $imagePath, 1370, 320);
                            if ($processedImagePath) {
                                $imageUpload->file_name = $processedImagePath;
                                $imageUpload->save();
                            }

                            // Process thumbnail
                            $processedThumbnailPath = $this->processThumbnail($randomFilename, $imagePath, $thumbnailPath, 1100, 320);
                            if ($processedThumbnailPath) {
                                $imageUpload->thumbnail = $processedThumbnailPath;
                                $imageUpload->save();
                            }

                            // Delete original image file if it's not a WebP
                            if (pathinfo(public_path($imagePath), PATHINFO_EXTENSION) !== 'webp') {
                                unlink(public_path($imagePath));
                            }
                        }
                    }
                }

                if ($request->header_logo) {
                    $imageUpload = Upload::find($request->header_logo);

                    // Ensure the image exists in the database
                    if ($imageUpload) {
                        $imagePath = $imageUpload->file_name;
                        $thumbnailPath = $imageUpload->thumbnail;

                        $randomFilename = Str::random(10);

                        // Process main image if it exists and needs resizing
                        $processedImagePath = $this->processImage($randomFilename, $imagePath, 250, 40);
                        if ($processedImagePath) {
                            $imageUpload->file_name = $processedImagePath;
                            $imageUpload->save();
                        }

                        // Delete original image file if it's not a WebP
                        if (pathinfo(public_path($imagePath), PATHINFO_EXTENSION) !== 'webp') {
                            unlink(public_path($imagePath));
                        }
                    }
                }

                if ($business_settings != null) {
                    // Update existing setting
                    if (gettype($request[$type]) == 'array') {
                        $business_settings->value = json_encode($request[$type]);
                    } else {
                        if ($type == 'scrolling_text') {
                            $business_settings->value = base64_encode($request[$type]);
                        } else {
                            $business_settings->value = $request[$type];
                        }
                    }
                    $business_settings->lang = $lang;
                    $business_settings->save();
                } else {
                    // Create new setting
                    $business_settings = new BusinessSetting;
                    $business_settings->type = $type;
                    if (gettype($request[$type]) == 'array') {
                        $business_settings->value = json_encode($request[$type]);
                    } else {
                        if ($type == 'scrolling_text') {
                            $business_settings->value = base64_encode($request[$type]);
                        } else {
                            $business_settings->value = $request[$type];
                        }
                    }
                    $business_settings->lang = $lang;
                    $business_settings->save();
                }
            }
        }

        Artisan::call('cache:clear');

        flash(translate("Settings updated successfully"))->success();
        // If the request from a tabs with tab input
        if ($request->has('tab')) {
            return Redirect::to(URL::previous() . "#" . $request->tab);
        }
        return redirect()->back();
    }

    public function zotc_update(Request $request)
    {
        foreach ($request->types as $type) {
            // Fetch existing setting or create a new instance
            $zotc_settings = ZotcSetting::firstOrNew(['type' => $type]);

            // Update the value of the setting
            $zotc_settings->value = $request[$type];
            $zotc_settings->save();
        }

        // Clear the cache
        Artisan::call('cache:clear');

        // Flash success message
        flash("Settings updated successfully")->success();

        return redirect()->back();
    }


    public function updateCartCustom(Request $request)
    {
        // Remove the '' from keys
        $request->types = array_map(function ($key) {
            return str_replace("'", "", $key);
        }, $request->types);

        foreach ($request->types as $key => $value) {
            $business_settings = BusinessSetting::where('type', $key)->first();

            if ($business_settings != null) {
                $business_settings->value = $value;
                $business_settings->save();
            } else {
                $business_settings = new BusinessSetting();

                $business_settings->type = $key;
                $business_settings->value = $value;
                $business_settings->save();
            }
        }

        Artisan::call('cache:clear');
        flash(translate('Cart Custom updated successfully'))->success();
        return back();
    }

    private function processImage($randomFilename, $imagePath, $desiredWidth, $desiredHeight)
    {
        $slug = get_zotc_setting('img_slug') ?: 'all';

        if ($imagePath) {
            $imageContent = file_get_contents(public_path($imagePath));
            $imageContent = preg_replace('/\x{00}*\x{00}IHDR\x{00}*\x{00}(?=\x{00}*\xff)/', '', $imageContent);  // Attempt to strip out the ICC profile data from binary content

            $image = @imagecreatefromstring($imageContent);

            if ($image) {
                $originalWidth = imagesx($image);
                $originalHeight = imagesy($image);

                // Check if the image is already a WebP with the desired size
                $isWebp = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION)) === 'webp';

                if (!($isWebp && $originalWidth == $desiredWidth && $originalHeight == $desiredHeight)) {
                    $uploadedPath = "uploads/{$slug}/{$randomFilename}.webp";
                    resizeAndSaveWebpImage($image, $uploadedPath, $desiredWidth, $desiredHeight);

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

        if ($thumbnailPath && file_exists(public_path($thumbnailPath)) && is_file(public_path($thumbnailPath))) {
            $thumbnailContent = file_get_contents(public_path($thumbnailPath));
            $thumbnail = @imagecreatefromstring($thumbnailContent);

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
            $image = @imagecreatefromstring($imageContent);

            $uploadedPath = "uploads/{$slug}/{$randomFilename}x{$desiredWidth}.webp";
            resizeAndSaveWebpImage($image, $uploadedPath, $desiredWidth, $desiredHeight);

            return $uploadedPath;
        }

        return null;
    }

    public function updateActivationSettings(Request $request)
    {
        $env_changes = ['FORCE_HTTPS', 'FILESYSTEM_DRIVER'];
        if (in_array($request->type, $env_changes)) {
            return $this->updateActivationSettingsInEnv($request);
        }

        $business_settings = BusinessSetting::where('type', $request->type)->first();
        if ($business_settings != null) {
            if ($request->type == 'maintenance_mode' && $request->value == '1') {
                if (env('DEMO_MODE') != 'On') {
                    Artisan::call('down');
                }
            } elseif ($request->type == 'maintenance_mode' && $request->value == '0') {
                if (env('DEMO_MODE') != 'On') {
                    Artisan::call('up');
                }
            }
            $business_settings->value = $request->value;
            $business_settings->save();
        } else {
            $business_settings = new BusinessSetting;
            $business_settings->type = $request->type;
            $business_settings->value = $request->value;
            $business_settings->save();
        }

        Artisan::call('cache:clear');
        return '1';
    }

    public function updateCheckboxSettings(Request $request)
    {
        $business_settings = BusinessSetting::where('type', $request->type)->first();
        if ($business_settings != null) {
            if ($request->type == 'maintenance_mode' && $request->value == '1') {
                if (env('DEMO_MODE') != 'On') {
                    Artisan::call('down');
                }
            } elseif ($request->type == 'maintenance_mode' && $request->value == '0') {
                if (env('DEMO_MODE') != 'On') {
                    Artisan::call('up');
                }
            }
            $business_settings->value = $request->value;
            $business_settings->save();
        } else {
            $business_settings = new BusinessSetting;
            $business_settings->type = $request->type;
            $business_settings->value = $request->value;
            $business_settings->save();
        }

        Artisan::call('cache:clear');
        return '1';
    }

    public function updateActivationSettingsInEnv($request)
    {
        if ($request->type == 'FORCE_HTTPS' && $request->value == '1') {
            $this->overWriteEnvFile($request->type, 'On');

            if (strpos(env('APP_URL'), 'http:') !== FALSE) {
                $this->overWriteEnvFile('APP_URL', str_replace("http:", "https:", env('APP_URL')));
            }
        } elseif ($request->type == 'FORCE_HTTPS' && $request->value == '0') {
            $this->overWriteEnvFile($request->type, 'Off');
            if (strpos(env('APP_URL'), 'https:') !== FALSE) {
                $this->overWriteEnvFile('APP_URL', str_replace("https:", "http:", env('APP_URL')));
            }
        } elseif ($request->type == 'FILESYSTEM_DRIVER') {
            $this->overWriteEnvFile($request->type, $request->value);
        }

        return '1';
    }

    public function vendor_commission(Request $request)
    {
        return view('backend.sellers.seller_commission.index');
    }

    public function vendor_commission_update(Request $request)
    {
        foreach ($request->types as $key => $type) {
            $business_settings = BusinessSetting::where('type', $type)->first();
            if ($business_settings != null) {
                $business_settings->value = $request[$type];
                $business_settings->save();
            } else {
                $business_settings = new BusinessSetting;
                $business_settings->type = $type;
                $business_settings->value = $request[$type];
                $business_settings->save();
            }
        }

        Artisan::call('cache:clear');

        flash(translate('Seller Commission updated successfully'))->success();
        return back();
    }

    public function shipping_configuration(Request $request)
    {
        return view('backend.setup_configurations.shipping_configuration.index');
    }

    public function shipping_configuration_update(Request $request)
    {
        $business_settings = BusinessSetting::where('type', $request->type)->first();
        $business_settings->value = $request[$request->type];
        $business_settings->save();

        Artisan::call('cache:clear');
        flash(translate('Shipping Method updated successfully'))->success();
        return back();
    }

    public function custom_shipping_store(Request $request)
    {
        $custom_shipping_array = [];

        if ($request->filled('shipping_name') && $request->filled('shipping_cost')) {
            $shipping_names = $request->shipping_name;
            $shipping_costs = $request->shipping_cost;

            foreach ($shipping_names as $index => $name) {
                if (!empty($name) && !empty($shipping_costs[$index])) {
                    $custom_shipping_array[$name] = $shipping_costs[$index];
                }
            }
        }

        $custom_shipping_info = json_encode($custom_shipping_array);

        $business_settings = BusinessSetting::where('type', 'custom_shipping_info')->first();

        if ($business_settings) {
            $business_settings->value = $custom_shipping_info;
        } else {
            $business_settings = new BusinessSetting();
            $business_settings->type = 'custom_shipping_info';
            $business_settings->value = $custom_shipping_info;
        }

        $business_settings->save();
        Artisan::call('cache:clear');
        flash(translate('Custom Shipping Cost Added'))->success();

        return back();
    }


    public function order_configuration()
    {
        return view('backend.setup_configurations.order_configuration.index');
    }

    public function import_data(Request $request)
    {
        if (env("DEMO_MODE") == "On") {
            flash(translate('Demo data import will not work in demo site'))->error();
            return back();
        }
        $url = 'https://activeitzone.com/ecommerce-demo-data-import/import';
        $header = array(
            'Content-Type:application/json'
        );
        $data['main_url'] = $request->main_url;
        $data['domain'] = $request->domain;
        $data['purchase_key'] = $request->purchase_key;
        $data['layout'] = $request->layout;
        $request_data_json = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request_data_json);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $raw_file_data = curl_exec($ch);

        if (json_decode($raw_file_data, true)['status']) {
            flash(translate('Demo data uploaded successfully'))->success();
        } else {
            flash(translate(json_decode($raw_file_data, true)['message']))->error();
        }

        return back();
    }

    public function homepage_order_update(Request $request)
    {
        try {
            // Retrieve or create the business setting
            $homepage_order = BusinessSetting::where('type', 'homepage_section_order')->first();

            if ($homepage_order) {
                // Update the value with the new order
                $homepage_order->value = json_encode($request->input('order'));
                $homepage_order->save();
            } else {
                $homepage_order = new BusinessSetting();
                $homepage_order->type = 'homepage_section_order';
                $homepage_order->value = json_encode($request->input('order'));
                $homepage_order->save();
            }

            // Clear the cache
            Artisan::call('cache:clear');

            // Return success response
            return response()->json([
                'success' => true,
                'order' => $request->input('order'),
            ], 200);
        } catch (\Exception $e) {
            // Handle errors and return error response
            return response()->json([
                'success' => false,
                'message' => 'Failed to update section order.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
