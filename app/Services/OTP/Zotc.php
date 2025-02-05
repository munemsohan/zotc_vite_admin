<?php

namespace App\Services\OTP;

use App\Contracts\SendSms;
use App\Models\OtpConfiguration;
use App\Models\ZotcSetting;

class Zotc implements SendSms
{
    public function send($to, $from, $text, $template_id)
    {
        // Check if Zotc OTP is enabled
        if (OtpConfiguration::where('type', 'zotc')->value('value') != 1) {
            return null;
        }

        // Calculate SMS cost
        $total_cost = calculate_sms_cost($text);

        // Fetch Zotc settings
        $sms_balance_bdt = ZotcSetting::where('type', 'sms_balance_bdt')->value('value');
        $sms_balance_usd = ZotcSetting::where('type', 'sms_balance_usd')->value('value');
        $currency = ZotcSetting::where('type', 'currency')->value('value');

        // Validate settings
        if (is_null($sms_balance_bdt) || is_null($sms_balance_usd) || is_null($currency)) {
            return null;
        }

        $apiKey = '287|kKlmNPhVFFVBqKJYROeXad1xP4FqE6k4k7HdXHn835bc486a';
        $smsType = get_zotc_setting('zotc_sms_type', 'sms');
        $baseUrl = "https://sms.one9.one/sms/api?action=send-sms";

        $params = [
            'api_key' => $apiKey,
            'to' => $to,
            'from' => $from,
            'sms' => $text,
        ];

        // Check balance based on currency
        $hasSufficientBalance = ($currency == 'BDT' && $sms_balance_bdt >= $total_cost) ||
            ($currency == 'USD' && $sms_balance_usd >= $total_cost);

        if (!$hasSufficientBalance) {
            return null; // Insufficient balance
        }

        // Send SMS or WhatsApp based on type
        switch ($smsType) {
            case 'sms':
                $response = $this->sendRequest($baseUrl, $params);
                break;

            case 'whatsapp':
                $params['whatsapp'] = 1;
                $response = $this->sendRequest($baseUrl, $params);
                break;

            case 'both':
                $responseSms = $this->sendRequest($baseUrl, $params);
                $params['whatsapp'] = 1;
                $responseWhatsapp = $this->sendRequest($baseUrl, $params);
                $response = ['sms' => $responseSms, 'whatsapp' => $responseWhatsapp];
                break;

            default:
                return null; // Unsupported type
        }

        // Deduct balance
        if ($currency == 'BDT') {
            $sms_balance_bdt -= $total_cost;
            ZotcSetting::where('type', 'sms_balance_bdt')->update(['value' => $sms_balance_bdt]);
        } else {
            $sms_balance_usd -= $total_cost;
            ZotcSetting::where('type', 'sms_balance_usd')->update(['value' => $sms_balance_usd]);
        }

        return $response;
    }

    private function sendRequest($url, $params)
    {
        $urlWithParams = $url . '&' . http_build_query($params);

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $urlWithParams);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            // Log error instead of echoing in production environments
            error_log('Curl error: ' . curl_error($curl));
        }

        curl_close($curl);

        return $response;
    }
}
