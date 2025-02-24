<?php

namespace App\Http\Controllers;

use App\Models\ZotcSetting;
use Illuminate\Http\Request;
use App\Models\BusinessSetting;
use App\Models\Upload;
use Artisan;
use CoreComponentRepository;
use DB;
use Illuminate\Support\Facades\Auth;
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
        $domain = ZotcSetting::where('type', 'domains')->first();

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
            $this->overWriteZotcSetting($type, $request[$type]);
        }

        // Update or create the sandbox setting in ZotcSetting
        $zotcSettingKey = $request->payment_method . '_sandbox';
        ZotcSetting::updateOrInsert(
            ['type' => $zotcSettingKey],
            ['value' => $request->has($zotcSettingKey) ? 1 : 0]
        );

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
            $this->overWriteBusinessSetting($type, $request[$type]);
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
            $this->overWriteBusinessSetting($type, $request[$type]);
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
            $this->overWriteBusinessSetting($type, $request[$type]);
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
            $this->overWriteBusinessSetting($type, $request[$type]);
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
            $this->overWriteBusinessSetting($type, $request[$type]);
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
        if ($request->has('facebook_pixel_id')) {
            // Check if the value is a script, URL, or just an ID
            $pixel_id = $request->facebook_pixel_id;

            if (filter_var($pixel_id, FILTER_VALIDATE_URL)) {
                // Extract the Pixel ID from the URL
                $url_components = parse_url($pixel_id);
                if (isset($url_components['query'])) {
                    parse_str($url_components['query'], $query_params);
                    if (isset($query_params['id'])) {
                        $pixel_id = $query_params['id'];
                    }
                }
            } elseif (strpos($pixel_id, 'fbq(\'init\', ') !== false) {
                // Extract the Pixel ID from the script
                preg_match("/fbq\('init', '(\d+)'/", $pixel_id, $matches);
                if (isset($matches[1])) {
                    $pixel_id = $matches[1];
                }
            }

            // Update the facebook_pixel_id in the request to the correct value
            $request->merge(['facebook_pixel_id' => $pixel_id]);
        }


        // Overwrite environment file with provided types
        foreach ($request->types as $key => $type) {
            $this->overWriteBusinessSetting($type, $request[$type]);
        }

        // Retrieve or create business settings for Facebook Pixel
        $business_settings = BusinessSetting::where('type', 'facebook_pixel')->first();

        // Update the business settings with the new Facebook Pixel ID
        if ($request->has('facebook_pixel')) {
            $business_settings->value = $request->facebook_pixel;
            $business_settings->save();
        }

        // Clear cache and show success message
        Artisan::call('cache:clear');
        flash(translate("Settings updated successfully"))->success();

        return back();
    }

    public function facebook_domain_verification_update(Request $request)
    {
        foreach ($request->types as $key => $type) {
            // Extract the actual verification code from the value
            $value = $request[$type];

            // If the value contains a <meta> tag, extract the content attribute
            if (preg_match('/content="([^"]+)"/', $value, $matches)) {
                $value = $matches[1];
            }

            $this->overWriteBusinessSetting($type, $value);
        }

        Artisan::call('cache:clear');

        flash(translate("Settings updated successfully"))->success();
        return back();
    }

    public function google_site_verification_update(Request $request)
    {
        foreach ($request->types as $key => $type) {
            // Extract the actual verification code from the value
            $value = $request[$type];

            // If the value contains a <meta> tag, extract the content attribute
            if (preg_match('/content="([^"]+)"/', $value, $matches)) {
                $value = $matches[1];
            }

            // Overwrite the .env file with the clean value
            $this->overWriteBusinessSetting($type, $value);
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
        $domain = request()->getHost();

        $envFile = base_path("env/.env.{$domain}");

        if (env('DEMO_MODE') != 'On') {

            if (file_exists($envFile)) {

                $val = '"' . trim($val) . '"';
                $envContents = file_get_contents($envFile);

                // Check if the key already exists in the .env file
                if (preg_match("/^{$type}=.*$/m", $envContents)) {
                    // Update the existing key with the new value
                    $updatedEnvContents = preg_replace(
                        "/^{$type}=.*$/m",
                        "{$type}={$val}",
                        $envContents
                    );
                } else {
                    // Append the new key-value pair if it doesn't exist
                    $updatedEnvContents = $envContents . "\r\n{$type}={$val}";
                }

                // Save the updated contents back to the file
                file_put_contents($envFile, $updatedEnvContents);
            }
        }
    }

    public function overWriteBusinessSetting($type, $val)
    {
        // Fetch existing setting or create a new instance
        $business_settings = BusinessSetting::firstOrNew(['type' => $type]);

        // Update the value of the setting
        $business_settings->value = $val;
        $business_settings->save();
    }

    public function overWriteZotcSetting($type, $val)
    {
        // Fetch existing setting or create a new instance
        $zotc_settings = ZotcSetting::firstOrNew(['type' => $type]);

        // Update the value of the setting
        $zotc_settings->value = $val;
        $zotc_settings->save();
    }

    public function mail_update(Request $request)
    {
        foreach ($request->types as $key => $type) {
            if ($request[$type] != NULL) {
                $this->overWriteZotcSetting($type, $request[$type]);
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
                            $originalImagePath = $imageUpload->file_name;

                            // Process main image if it exists and needs resizing
                            $processedImagePath = processImage($originalImagePath, 1530, 380);
                            if ($processedImagePath) {
                                $imageUpload->file_name = $processedImagePath;
                            }

                            // Process thumbnail image if it exists and needs resizing
                            $processedThumbnailPath = processImage($originalImagePath, 1230, 380);
                            if ($processedThumbnailPath) {
                                $imageUpload->thumbnail = $processedThumbnailPath;
                            }

                            $imageUpload->save();

                            // Delete the image if it's not WebP
                            deleteImageIfNotWebp($originalImagePath);
                        }
                    }
                }

                if ($request->site_icon) {
                    $imageUpload = Upload::find($request->site_icon);

                    // Ensure the image exists in the database
                    if ($imageUpload) {
                        $originalImagePath = $imageUpload->file_name;

                        // Process site icon
                        $processedImagePath = processImage($originalImagePath, 32, 32);

                        if ($processedImagePath) {
                            $imageUpload->file_original_name = 'icon';
                            $imageUpload->file_name = $processedImagePath;
                            $imageUpload->thumbnail = $processedImagePath;
                            $imageUpload->save();
                        }

                        // Delete original image file if it is not a WebP
                        deleteImageIfNotWebp($originalImagePath);
                    }
                }

                if ($request->header_logo) {
                    $imageUpload = Upload::find($request->header_logo);

                    // Ensure the image exists in the database
                    if ($imageUpload) {
                        $originalImagePath = $imageUpload->file_name;

                        // Process main logo
                        $processedImagePath = processImage($originalImagePath, 250, 50);

                        // Process tall logo
                        $processedThumbnailPath = processImage($originalImagePath, 150, 50);

                        // Update the current logo details if main image processing was successful
                        if ($processedImagePath) {
                            $imageUpload->file_name = $processedImagePath;
                            $imageUpload->thumbnail = $processedThumbnailPath;
                            $imageUpload->save();
                        }

                        // Process white logo
                        $processedWhiteImagePath = $this->processWhiteLogo($imageUpload->file_name);

                        $lastUpload = Upload::latest()->first();

                        if ($lastUpload && $lastUpload->file_original_name !== 'logo-white') {
                            // Save processed white logo if available
                            if (!empty($processedWhiteImagePath)) {
                                // Create a new Upload instance for the white logo
                                $whiteLogoUpload = Upload::create([
                                    'file_original_name' => 'logo-white',
                                    'file_name' => $processedWhiteImagePath,
                                    'thumbnail' => $processedWhiteImagePath,
                                    'user_id' => Auth::id(),
                                    'extension' => 'webp',
                                    'type' => 'image',
                                ]);

                                // Update or create the BusinessSettings entry for the white logo
                                if ($whiteLogoUpload) {
                                    BusinessSetting::updateOrCreate(
                                        ['type' => 'header_logo_white'],
                                        ['value' => $whiteLogoUpload->id]
                                    );
                                }
                            }
                        }

                        // Delete original image file if it is not a WebP
                        deleteImageIfNotWebp($originalImagePath);
                    }
                }

                if ($request->footer_logo) {
                    $imageUpload = Upload::find($request->footer_logo);

                    // Ensure the image exists in the database
                    if ($imageUpload) {
                        $originalImagePath = $imageUpload->file_name;

                        // Process footer logo
                        $processedImagePath = processImage($originalImagePath, 250, 50);

                        // Update the current logo details if main image processing was successful
                        if ($processedImagePath) {
                            $imageUpload->file_name = $processedImagePath;
                            $imageUpload->thumbnail = $processedImagePath;
                            $imageUpload->save();
                        }

                        // Delete original image file if it is not a WebP
                        deleteImageIfNotWebp($originalImagePath);
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

    public function processWhiteLogo($imagePath)
    {
        $randomFilename = Str::random(10) . '.webp';
        $absoluteInputPath = public_path($imagePath);

        if (!file_exists($absoluteInputPath)) {
            throw new \Exception('File does not exist: ' . $absoluteInputPath);
        }

        $image = imagecreatefromwebp($absoluteInputPath);
        if (!$image) {
            throw new \Exception('Failed to load WebP image.');
        }

        $originalWidth = imagesx($image);
        $originalHeight = imagesy($image);
        $processedImage = imagecreatetruecolor($originalWidth, $originalHeight);

        $bgColor = imagecolorallocate($processedImage, 236, 239, 244); // #E1E6E4
        imagefill($processedImage, 0, 0, $bgColor);

        for ($x = 0; $x < $originalWidth; $x++) {
            for ($y = 0; $y < $originalHeight; $y++) {
                $pixelColor = imagecolorat($image, $x, $y);
                $colors = imagecolorsforindex($image, $pixelColor);

                if ($colors['red'] > 240 && $colors['green'] > 240 && $colors['blue'] > 240) {
                    imagesetpixel($processedImage, $x, $y, $bgColor);
                } else {
                    imagesetpixel($processedImage, $x, $y, $pixelColor);
                }
            }
        }

        $slug = get_zotc_setting('img_slug');
        $assetPath = 'uploads/' . $slug;
        $absoluteAssetPath = public_path($assetPath);

        if (!file_exists($absoluteAssetPath) && !mkdir($absoluteAssetPath, 0755, true)) {
            throw new \Exception('Failed to create directory.');
        }

        $outputPath = $absoluteAssetPath . '/' . $randomFilename;
        if (!imagewebp($processedImage, $outputPath)) {
            throw new \Exception('Failed to save WebP image.');
        }

        chmod($outputPath, 0644);
        imagedestroy($processedImage);
        imagedestroy($image);

        return $assetPath . '/' . $randomFilename;
    }


    function resizeLogo($randomFileName, $imagePath, $newWidth, $newHeight)
    {
        // Resolve the absolute path of the input image
        $absoluteImagePath = public_path($imagePath);

        // Check if the file exists
        if (!file_exists($absoluteImagePath)) {
            throw new \Exception('File does not exist: ' . $absoluteImagePath);
        }

        // dd($absoluteImagePath);

        // Load the WebP image
        $image = imagecreatefromwebp($absoluteImagePath);
        if (!$image) {
            throw new \Exception('Failed to load WebP image: ' . $absoluteImagePath);
        }

        $originalWidth = imagesx($image);
        $originalHeight = imagesy($image);

        // Create a new true color image with the given dimensions
        $resizedImage = imagecreatetruecolor($newWidth, $newHeight);

        // Preserve transparency for WebP
        imagealphablending($resizedImage, false);
        imagesavealpha($resizedImage, true);

        // Resize the image to the absolute dimensions
        if (!imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight)) {
            throw new \Exception('Failed to resize the image.');
        }

        // Define the output path dynamically using $randomFileName
        if (!str_ends_with($randomFileName, '.webp')) {
            $randomFileName .= '.webp';
        }

        $slug = get_zotc_setting('img_slug');
        $assetPath = 'uploads/' . $slug;
        $absoluteAssetPath = public_path($assetPath);

        // Ensure the output directory exists
        if (!file_exists($absoluteAssetPath) && !mkdir($absoluteAssetPath, 0755, true)) {
            throw new \Exception('Failed to create directory: ' . $absoluteAssetPath);
        }

        $outputPath = $absoluteAssetPath . '/' . $randomFileName;

        // Save the resized image as a WebP file
        if (!imagewebp($resizedImage, $outputPath)) {
            throw new \Exception('Failed to save resized WebP image at: ' . $outputPath);
        }

        // Set permissions and clean up
        chmod($outputPath, 0644);
        imagedestroy($resizedImage);
        imagedestroy($image);

        // Return the relative path to the resized image
        return $assetPath . '/' . $randomFileName;
    }
}
