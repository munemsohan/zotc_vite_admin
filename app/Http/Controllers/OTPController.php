<?php

namespace App\Http\Controllers;

use App\Models\SmsTemplate;
use Illuminate\Http\Request;
use App\Models\OtpConfiguration;
use App\Models\ZotcSetting;

class OTPController extends Controller
{
    public function __construct()
    {
        // Staff Permission Check
        $this->middleware(['permission:otp_configurations'])->only('configure_index');
        $this->middleware(['permission:sms_providers_configurations'])->only('credentials_index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function configure_index()
    {
        $otp_configurations = OtpConfiguration::all();
        return view('backend.otp_systems.configurations.activation', compact('otp_configurations'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function credentials_index()
    {
        $otp_configurations = OtpConfiguration::all();
        $sms_templates = SmsTemplate::all();

        return view('backend.otp_systems.configurations.index', compact('otp_configurations', 'sms_templates'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateActivationSettings(Request $request)
    {
        $business_settings = OtpConfiguration::where('type', $request->type)->first();
        if ($business_settings != null) {
            $business_settings->value = $request->value;
            $business_settings->save();
        } else {
            $business_settings = new OtpConfiguration;
            $business_settings->type = $request->type;
            $business_settings->value = $request->value;
            $business_settings->save();
        }
        return '1';
    }

    /**
     * Update the specified resource in .env
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_credentials(Request $request)
    {
        foreach ($request->types as $key => $type) {
            $this->overWriteZotcSetting($type, $request[$type]);
        }

        flash("Settings updated successfully")->success();
        return back();
    }

    /**
     *.env file overwrite
     */
    public function overWriteEnvFile($type, $val)
    {
        $currentRequest = Request::createFromGlobals();
        $domain = $currentRequest->getHost();

        $path = base_path("env/.env.{$domain}");

        if (file_exists($path)) {
            $val = '"' . trim($val) . '"';
            if (is_numeric(strpos(file_get_contents($path), $type)) && strpos(file_get_contents($path), $type) >= 0) {
                file_put_contents($path, str_replace(
                    $type . '="' . env($type) . '"',
                    $type . '=' . $val,
                    file_get_contents($path)
                ));
            } else {
                file_put_contents($path, file_get_contents($path) . "\r\n" . $type . '=' . $val);
            }
        }
    }

    public function overWriteZotcSetting($type, $val)
    {
        // Fetch existing setting or create a new instance
        $zotc_settings = ZotcSetting::firstOrNew(['type' => $type]);

        // Update the value of the setting
        $zotc_settings->value = $val;
        $zotc_settings->save();
    }
}
