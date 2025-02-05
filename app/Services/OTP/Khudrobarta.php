<?php

namespace App\Services\OTP;

use App\Contracts\SendSms;
use App\Models\OtpConfiguration;
use App\Models\ZotcSetting;

class Khudrobarta implements SendSms
{
    public function send($to, $from, $text, $template_id)
    {
        // Check if Khudrobarta OTP is enabled
        if (OtpConfiguration::where('type', 'khudrobarta')->value('value') != 1) {
            return null;
        }

        // Retrieve API key and sender ID from environment variables
        $apiKey = get_zotc_setting('khudrobarta_api_key');
        $senderId = get_zotc_setting('khudrobarta_sender_id');
        $smsType = get_zotc_setting('khudrobarta_sms_type', 'sms');
        $baseUrl = "https://sms.one9.one/sms/api?action=send-sms";

        // Ensure required parameters are present
        if (!$apiKey || !$senderId) {
            error_log('Missing API key or sender ID for Khudrobarta');
            return null;
        }

        $params = [
            'api_key' => $apiKey,
            'to' => $to,
            'from' => $senderId,
            'sms' => $text,
        ];

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
                // Send SMS
                $responseSms = $this->sendRequest($baseUrl, $params);

                // Send WhatsApp message
                $params['whatsapp'] = 1;
                $responseWhatsapp = $this->sendRequest($baseUrl, $params);

                $response = [
                    'sms' => $responseSms,
                    'whatsapp' => $responseWhatsapp,
                ];
                break;

            default:
                error_log('Unsupported SMS type for Khudrobarta');
                return null;
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
