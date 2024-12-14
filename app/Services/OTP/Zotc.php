<?php

namespace App\Services\OTP;

use App\Contracts\SendSms;
use App\Models\OtpConfiguration;
use App\Models\ZotcSetting;

class Zotc implements SendSms
{
    public function send($to, $from, $text, $template_id)
    {
        if (OtpConfiguration::where('type', 'zotc')->value('value') == 1) {
            $total_cost = calculate_sms_cost($text);
            $zotc_settings = ZotcSetting::where('type', 'sms_balance_bdt')->first();

            $apiKey = '287|kKlmNPhVFFVBqKJYROeXad1xP4FqE6k4k7HdXHn835bc486a';
            $smsType = env('ZOTC_SMS_TYPE');
            $baseUrl = "https://sms.one9.one/sms/api?action=send-sms";

            $params = [
                'api_key' => $apiKey,
                'to' => $to,
                'from' => $from,
                'sms' => $text,
            ];

            if (($zotc_settings->currency == 'BDT' && $zotc_settings->sms_balance_bdt >= $total_cost) ||
                ($zotc_settings->currency == 'USD' && $zotc_settings->sms_balance_usd >= $total_cost)
            ) {
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
                        $response = null; // or handle error
                        break;
                }

                if ($zotc_settings->currency == 'BDT') {
                    $zotc_settings->sms_balance_bdt -= $total_cost;
                } else {
                    $zotc_settings->sms_balance_usd -= $total_cost;
                }
                $zotc_settings->save();

                return $response;
            } else {
                return null;
            }
        }

        return null;
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
