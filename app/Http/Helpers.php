<?php

use App\Models\CartSetting;
use Carbon\Carbon;
use App\Models\Tax;
use App\Models\Cart;
use App\Models\City;
use App\Models\Shop;
use App\Models\User;
use App\Models\Addon;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Seller;
use App\Models\Upload;
use App\Models\Wallet;
use App\Models\Address;
use App\Models\Carrier;
use App\Models\Country;
use App\Models\Product;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Language;
use App\Models\Wishlist;
use App\Models\Attribute;
use App\Models\ClubPoint;
use App\Models\FlashDeal;
use App\Models\CouponUsage;
use App\Models\DeliveryBoy;
use App\Models\OrderDetail;
use App\Models\PickupPoint;
use App\Models\Translation;
use App\Models\BlogCategory;
use App\Models\Conversation;
use App\Models\FollowSeller;
use App\Models\ProductStock;
use App\Models\CombinedOrder;
use App\Models\SellerPackage;
use App\Models\AffiliateConfig;
use App\Models\AffiliateOption;
use App\Models\BusinessSetting;
use App\Models\CustomerPackage;
use App\Models\CustomerProduct;
use App\Utility\SendSMSUtility;
use App\Utility\CategoryUtility;
use App\Models\AuctionProductBid;
use App\Models\ManualPaymentMethod;
use App\Models\SellerPackagePayment;
use App\Utility\NotificationUtility;
use App\Http\Resources\V2\CarrierCollection;
use App\Http\Controllers\AffiliateController;
use App\Http\Controllers\ClubPointController;
use App\Http\Controllers\CommissionController;
use AizPackages\ColorCodeConverter\Services\ColorCodeConverter;
use App\Models\FlashDealProduct;
use App\Models\State;
use App\Models\UserCoupon;
use App\Models\ZotcSetting;

//highlights the selected navigation on frontend
if (!function_exists('getAllShops')) {
    function getAllShops()
    {
        $ownerEmail = Auth::user()->email;

        $sitesConnection = DB::connection('dynamic_db');
        $sitesConnection->getPdo()->exec("USE zotc_nazmart");

        $userId = $sitesConnection->table('users')
            ->where('email', $ownerEmail)
            ->value('id');

        $shops = $sitesConnection->table('tenants')
            ->join('domains', 'tenants.id', '=', 'domains.tenant_id')
            ->where('tenants.user_id', $userId)
            ->select('tenants.*', 'domains.domain')
            ->get();

        return $shops;
    }
}

//sensSMS function for OTP
if (!function_exists('sendSMS')) {
    function sendSMS($to, $from, $text, $template_id)
    {
        return SendSMSUtility::sendSMS($to, $from, $text, $template_id);
    }
}

if (!function_exists('executeBkashApiRequest')) {
    function executeBkashApiRequest($token, $bdt_amount, $success_url, $notify_url, $cancel_url)
    {
        // API endpoint URL
        // $apiUrl = 'https://zo.tc/bkash/createpayment.php';

        $apiUrl = "https://bkash-api.bangla.express/api/createpayment.php";

        // Data to send in the POST request
        $postData = array(
            'token' => $token,
            'amount' => $bdt_amount,
            'success_url' => $success_url,
            'notify_url' => $notify_url,
            'cancel_url' => $cancel_url,
        );

        // Initialize cURL
        $curl = curl_init();

        // Set cURL options
        curl_setopt($curl, CURLOPT_URL, $apiUrl);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        // Execute the request
        $response = curl_exec($curl);

        // Check for errors
        if ($response === false) {
            $error = curl_error($curl);
            echo "cURL Error: " . $error;
        }

        // Close the cURL session
        curl_close($curl);

        // Redirect to the response URL
        header('Location: ' . $response);
        exit();
    }
}

if (!function_exists('executeVisaApiRequest')) {
    function executeVisaApiRequest($token, $bdt_amount, $success_url, $notify_url, $cancel_url)
    {
        // $apiUrl = 'https://zo.tc/visa/createpayment.php';

        $apiUrl = 'https://eportal.w3space.net/pay/createpayment.php';

        $postData = array(
            'received_by' => 'zotc',
            'order_id' => $token,
            'success_url' => $success_url,
            'notify_url' => $notify_url,
            'cancel_url' => $cancel_url,
            'email' => auth()->user()->email,
            'amount' => (int)$bdt_amount,
        );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $apiUrl);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curl);

        if ($response === false) {
            // Curl error
            die('Curl error: ' . curl_error($curl));
        }

        curl_close($curl);

        $responseData = json_decode($response);

        if (!isset($responseData->redirect_url) || !filter_var($responseData->redirect_url, FILTER_VALIDATE_URL)) {
            // Not a valid URL, handle the error
            die('Invalid URL returned: ' . htmlspecialchars($response));
        }

        // Redirect to the response URL
        header('Location: ' . $responseData->redirect_url);
        exit();
    }
}

if (!function_exists('executePaddleApiRequest')) {
    function executePaddleApiRequest($token, $usd_amount, $success_url, $notify_url, $cancel_url)
    {
        // $apiUrl = 'https://zo.tc/visa/createpayment.php';
        $apiUrl = 'https://prokolpo.net/paddle/createpayment.php';

        $postData = array(
            'title' => 'paddlerequest',
            'order_id' => $token,
            'store_id' => get_domain(),
            'success_url' => $success_url,
            'notify_url' => $notify_url,
            'cancel_url' => $cancel_url,
            'email' => auth()->user()->email,
            'amount' => (float)$usd_amount,
        );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $apiUrl);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);

        if ($response === false) {
            // Curl error
            die('Curl error: ' . curl_error($curl));
        }

        curl_close($curl);

        $responseData = json_decode($response);

        if (!isset($responseData->response->url)) {
            // Not a valid URL, handle the error
            die('Invalid URL returned: ' . htmlspecialchars($response));
        }

        // Redirect to the response URL
        header('Location: ' . $responseData->response->url);
        exit();
    }
}

// app/Helpers/SmsHelper.php

if (!function_exists('calculate_sms_cost')) {
    function calculate_sms_cost($message)
    {
        $costPerSms = 0.30;
        $tax = 0.06;
        $smsCount = 0;

        if (mb_detect_encoding($message, 'ASCII', true)) {
            // Normal SMS
            if (strlen($message) <= 160) {
                $smsCount = 1;
            } else {
                $smsCount = 1 + ceil((strlen($message) - 160) / 153);
            }
        } else {
            // Unicode SMS
            if (mb_strlen($message) <= 70) {
                $smsCount = 1;
            } else {
                $smsCount = 1 + ceil((mb_strlen($message) - 70) / 63);
            }
        }

        $totalCost = $smsCount * $costPerSms + $tax;

        if (get_zotc_setting('currency') == 'USD') {
            $totalCost = $totalCost / 100;
        }

        return $totalCost;
    }
}

if (!function_exists('formatPhoneNumber')) {
    function formatPhoneNumber($phone)
    {
        if (strpos($phone, '8801') === 0) {
            return '+' . $phone;
        } elseif (strpos($phone, '01') === 0) {
            return '+88' . $phone;
        }
        return $phone;
    }
}

if (!function_exists('formatPhoneNumberWithoutPlus')) {
    function formatPhoneNumberWithoutPlus($phone)
    {
        if (strpos($phone, '+8801') === 0) {
            // If the phone number starts with +8801, remove the +
            return substr($phone, 1);
        } elseif (strpos($phone, '01') === 0) {
            // If the phone number starts with 01, add 88 to the beginning
            return '88' . $phone;
        }
        return $phone;
    }
}


if (!function_exists('sendTrackingTinyUrlBySms')) {
    function sendTrackingTinyUrlBySms($to, $sms_template, $url)
    {
        $text = $sms_template->sms_body;

        // Replace the placeholder with the actual shortened URL
        $modifiedText = str_replace('[[url]]', $url, $text);

        // Send the SMS with the modified text
        sendSMS($to, null, $modifiedText, $sms_template->id);
    }
}

if (!function_exists('makeTinyUrl')) {
    function makeTinyUrl($url)
    {
        $shortUrlBase = trim(get_zotc_setting('short_url'));

        // If short_url is not set or empty, return the original URL
        if (empty($shortUrlBase)) {
            return $url;
        }

        // Prepare the cURL request to shorten the URL
        $curl = curl_init();
        $payload = json_encode(['url' => $url]);

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://{$shortUrlBase}/api/url/add",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 2,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer dinGkUJmPvCnVSnUtSEHlnkteAwcHKFC",
                "Content-Type: application/json",
            ],
            CURLOPT_POSTFIELDS => $payload,
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        if ($response === false) {
            return $url;
        }

        $responseArray = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return $url;
        }

        return $responseArray['shorturl'] ?? $url;
    }
}

//highlights the selected navigation on admin panel
if (!function_exists('areActiveRoutes')) {
    function areActiveRoutes(array $routes, $output = "active")
    {
        foreach ($routes as $route) {
            if (Route::currentRouteName() == $route && (url()->current() != url('/admin/website/custom-pages/edit/home'))) return $output;
        }
    }
}

//highlights the selected navigation on frontend
if (!function_exists('areActiveRoutesHome')) {
    function areActiveRoutesHome(array $routes, $output = "active")
    {
        foreach ($routes as $route) {
            if (Route::currentRouteName() == $route) return $output;
        }
    }
}

//highlights the selected navigation on frontend
if (!function_exists('default_language')) {
    function default_language()
    {
        return env("DEFAULT_LANGUAGE");
    }
}

if (!function_exists('configureMailSettings')) {
    function configureMailSettings()
    {
        // Fetch mail settings from the database (ZotcSetting)
        $mailSettings = ZotcSetting::whereIn('type', [
            'mail_driver',
            'mail_host',
            'mail_port',
            'mail_username',
            'mail_password',
            'mail_encryption',
            'mail_from_address',
            'mail_from_name'
        ])->pluck('value', 'type')->toArray();

        // Check if mailSettings are empty, and provide default values if necessary
        if (empty($mailSettings)) {
            throw new \Exception('Mail settings not found in ZotcSettings.');
        }

        // Set Mail Configurations Dynamically
        Config::set('mail.default', $mailSettings['mail_driver'] ?? 'smtp');
        Config::set('mail.mailers.smtp.host', $mailSettings['mail_host'] ?? 'smtp.mailtrap.io');
        Config::set('mail.mailers.smtp.port', $mailSettings['mail_port'] ?? 587);
        Config::set('mail.mailers.smtp.username', $mailSettings['mail_username'] ?? 'default_user');
        Config::set('mail.mailers.smtp.password', $mailSettings['mail_password'] ?? 'default_password');
        Config::set('mail.mailers.smtp.encryption', $mailSettings['mail_encryption'] ?? 'tls');
        Config::set('mail.from.address', $mailSettings['mail_from_address'] ?? 'default@example.com');
        Config::set('mail.from.name', $mailSettings['mail_from_name'] ?? 'Default Name');

        return $mailSettings;
    }
}


/**
 * Save JSON File
 * @return Response
 */
if (!function_exists('convert_to_usd')) {
    function convert_to_usd($amount)
    {
        $currency = Currency::find(get_setting('system_default_currency'));
        return (floatval($amount) / floatval($currency->exchange_rate)) * Currency::where('code', 'USD')->first()->exchange_rate;
    }
}

if (!function_exists('convert_to_kes')) {
    function convert_to_kes($amount)
    {
        $currency = Currency::find(get_setting('system_default_currency'));
        return (floatval($amount) / floatval($currency->exchange_rate)) * Currency::where('code', 'KES')->first()->exchange_rate;
    }
}

// get all active countries
if (!function_exists('get_active_countries')) {
    function get_active_countries()
    {
        $countries = Cache::remember(get_domain() . '_active_countries', 2592000, function () {
            return Country::isEnabled()->get();
        });

        // $countries = Session::get('active_countries');

        // if (!$countries) {
        //     $countries = Country::isEnabled()->get();
        //     Session::put('active_countries', $countries);
        // }

        return $countries;
    }
}

//filter products based on vendor activation system
if (!function_exists('filter_products')) {
    function filter_products($products)
    {
        $products = $products->isApprovedPublished()->where('auction_product', 0);

        if (!addon_is_activated('wholesale')) {
            $products = $products->where('wholesale_product', 0);
        }
        $verified_sellers = verified_sellers_id();
        // $unbanned_sellers_id = unbanned_sellers_id();
        if (get_setting('vendor_system_activation') == 1) {
            // return $products->where(function ($p) use ($verified_sellers, $unbanned_sellers_id) {
            //     $p->where('added_by', 'admin')->orWhere(function ($q) use ($verified_sellers, $unbanned_sellers_id) {
            //         $q->whereIn('user_id', $verified_sellers)->whereIn('user_id', $unbanned_sellers_id);
            //     });
            // });
            return $products->where(function ($p) use ($verified_sellers) {
                $p->where('added_by', 'admin')->orWhere(function ($q) use ($verified_sellers) {
                    $q->whereIn('user_id', $verified_sellers);
                });
            });
        } else {
            return $products->where('added_by', 'admin');
        }
    }
}

//cache products based on category
if (!function_exists('get_cached_products')) {
    function get_cached_products($category_id = null)
    {
        return Cache::remember(get_domain() . '_products-category-' . $category_id, 2592000, function () use ($category_id) {
            return filter_products(Product::where('category_id', $category_id))->latest()->take(5)->get();
        });
    }
}

if (!function_exists('verified_sellers_id')) {
    function verified_sellers_id()
    {
        return Cache::remember(get_domain() . '_verified_sellers_id', 2592000, function () {
            return Shop::where('verification_status', 1)->pluck('user_id')->toArray();
        });
    }
}

// if (!function_exists('unbanned_sellers_id')) {
//     function unbanned_sellers_id()
//     {
//         return Cache::rememberForever('unbanned_sellers_id', function () {
//             return App\Models\User::where('user_type', 'seller')->where('banned', 0)->pluck('id')->toArray();
//         });
//     }
// }

if (!function_exists('get_system_default_currency')) {
    function get_system_default_currency()
    {
        return Cache::remember(get_domain() . '_system_default_currency', 2592000, function () {
            return Currency::findOrFail(get_setting('system_default_currency'));
        });
    }
}

//converts currency to home default currency
if (!function_exists('convert_price')) {
    function convert_price($price)
    {
        if (Session::has('currency_code') && (Session::get('currency_code') != get_system_default_currency()->code)) {
            $price = floatval($price) / floatval(get_system_default_currency()->exchange_rate);
            $price = floatval($price) * floatval(Session::get('currency_exchange_rate'));
        }

        if (
            request()->header('Currency-Code') &&
            request()->header('Currency-Code') != get_system_default_currency()->code
        ) {
            $price = floatval($price) / floatval(get_system_default_currency()->exchange_rate);
            $price = floatval($price) * floatval(request()->header('Currency-Exchange-Rate'));
        }
        return $price;
    }
}

//gets currency symbol
if (!function_exists('currency_symbol')) {
    function currency_symbol()
    {
        if (Session::has('currency_symbol')) {
            return Session::get('currency_symbol');
        }
        if (request()->header('Currency-Code')) {
            return request()->header('Currency-Code');
        }
        return get_system_default_currency()->symbol;
    }
}

if (!function_exists('currency_symbol2')) {
    function currency_symbol2()
    {
        if (Session::has('currency_symbol')) {
            return Session::get('currency_symbol');
        }
        if (request()->header('Currency-Code')) {
            return request()->header('Currency-Code');
        }
        return get_system_default_currency()->code;
    }
}

//formats currency
if (!function_exists('format_price')) {
    function format_price($price, $isMinimize = false)
    {
        if (get_setting('decimal_separator') == 1) {
            $fomated_price = number_format($price, get_setting('no_of_decimals'));
        } else {
            $fomated_price = number_format($price, get_setting('no_of_decimals'), ',', '.');
        }

        // Minimize the price 
        if ($isMinimize) {
            $temp = number_format($price / 1000000000, get_setting('no_of_decimals'), ".", "");

            if ($temp >= 1) {
                $fomated_price = $temp . "B";
            } else {
                $temp = number_format($price / 1000000, get_setting('no_of_decimals'), ".", "");
                if ($temp >= 1) {
                    $fomated_price = $temp . "M";
                }
            }
        }

        if (get_setting('symbol_format') == 1) {
            return currency_symbol() . $fomated_price;
        } else if (get_setting('symbol_format') == 3) {
            return currency_symbol() . ' ' . $fomated_price;
        } else if (get_setting('symbol_format') == 4) {
            return $fomated_price . ' ' . currency_symbol();
        }
        return $fomated_price . currency_symbol();
    }
}

if (!function_exists('format_price2')) {
    function format_price2($price, $isMinimize = false)
    {
        if (get_setting('decimal_separator') == 1) {
            $fomated_price = number_format($price, get_setting('no_of_decimals'));
        } else {
            $fomated_price = number_format($price, get_setting('no_of_decimals'), ',', '.');
        }

        // Minimize the price 
        if ($isMinimize) {
            $temp = number_format($price / 1000000000, get_setting('no_of_decimals'), ".", "");

            if ($temp >= 1) {
                $fomated_price = $temp . "B";
            } else {
                $temp = number_format($price / 1000000, get_setting('no_of_decimals'), ".", "");
                if ($temp >= 1) {
                    $fomated_price = $temp . "M";
                }
            }
        }

        return $fomated_price . ' ' . currency_symbol2();
    }
}


//formats price to home default price with convertion
if (!function_exists('single_price')) {
    function single_price($price)
    {
        return format_price(convert_price($price));
    }
}

//formats price to home default price with convertion
if (!function_exists('single_price2')) {
    function single_price2($price)
    {
        return format_price2(convert_price($price));
    }
}

if (!function_exists('discount_in_percentage')) {
    function discount_in_percentage($product)
    {
        $base = home_base_price($product, false);
        $reduced = home_discounted_base_price($product, false);
        $discount = $base - $reduced;
        $dp = ($discount * 100) / ($base > 0 ? $base : 1);
        return round($dp);
    }
}

//Shows Price on page based on carts
if (!function_exists('cart_product_price')) {
    function cart_product_price($cart_product, $product, $formatted = true, $tax = true)
    {
        if ($product->auction_product == 0) {
            $str = '';
            if ($cart_product['variation'] != null) {
                $str = $cart_product['variation'];
            }
            $price = 0;
            $product_stock = $product->stocks->where('variant', $str)->first();
            if ($product_stock) {
                $price = $product_stock->price;
            }

            if ($product->wholesale_product) {
                $wholesalePrice = $product_stock->wholesalePrices->where('min_qty', '<=', $cart_product['quantity'])->where('max_qty', '>=', $cart_product['quantity'])->first();
                if ($wholesalePrice) {
                    $price = $wholesalePrice->price;
                }
            }

            //discount calculation
            $discount_applicable = false;

            if ($product->discount_start_date == null) {
                $discount_applicable = true;
            } elseif (
                strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
                strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date
            ) {
                $discount_applicable = true;
            }

            if ($discount_applicable) {
                if ($product->discount_type == 'percent') {
                    $price -= ($price * $product->discount) / 100;
                } elseif ($product->discount_type == 'amount') {
                    $price -= $product->discount;
                }
            }
        } else {
            $price = $product->bids->max('amount');
        }

        //calculation of taxes 
        if ($tax) {
            $taxAmount = 0;
            foreach ($product->taxes as $product_tax) {
                if ($product_tax->tax_type == 'percent') {
                    $taxAmount += ($price * $product_tax->tax) / 100;
                } elseif ($product_tax->tax_type == 'amount') {
                    $taxAmount += $product_tax->tax;
                }
            }
            $price += $taxAmount;
        }

        if ($formatted) {
            return format_price(convert_price($price));
        } else {
            return $price;
        }
    }
}

if (!function_exists('cart_product_tax')) {
    function cart_product_tax($cart_product, $product, $formatted = true)
    {
        $str = '';
        if ($cart_product['variation'] != null) {
            $str = $cart_product['variation'];
        }

        $product_stock = $product->stocks->where('variant', $str)->first();

        if (isset($product_stock->price)) {
            $price = $product_stock->price;
        } else {
            $price = $product->unit_price;
        }

        //discount calculation
        $discount_applicable = false;

        if ($product->discount_start_date == null) {
            $discount_applicable = true;
        } elseif (
            strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
            strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date
        ) {
            $discount_applicable = true;
        }

        if ($discount_applicable) {
            if ($product->discount_type == 'percent') {
                $price -= ($price * $product->discount) / 100;
            } elseif ($product->discount_type == 'amount') {
                $price -= $product->discount;
            }
        }

        //calculation of taxes 
        $tax = 0;
        foreach ($product->taxes as $product_tax) {
            if ($product_tax->tax_type == 'percent') {
                $tax += ($price * $product_tax->tax) / 100;
            } elseif ($product_tax->tax_type == 'amount') {
                $tax += $product_tax->tax;
            }
        }

        if ($formatted) {
            return format_price(convert_price($tax));
        } else {
            return $tax;
        }
    }
}

if (!function_exists('cart_product_discount')) {
    function cart_product_discount($cart_product, $product, $formatted = false)
    {
        $str = '';
        if ($cart_product['variation'] != null) {
            $str = $cart_product['variation'];
        }
        $product_stock = $product->stocks->where('variant', $str)->first();
        $price = $product_stock->price;

        //discount calculation
        $discount_applicable = false;
        $discount = 0;

        if ($product->discount_start_date == null) {
            $discount_applicable = true;
        } elseif (
            strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
            strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date
        ) {
            $discount_applicable = true;
        }

        if ($discount_applicable) {
            if ($product->discount_type == 'percent') {
                $discount = ($price * $product->discount) / 100;
            } elseif ($product->discount_type == 'amount') {
                $discount = $product->discount;
            }
        }

        if ($formatted) {
            return format_price(convert_price($discount));
        } else {
            return $discount;
        }
    }
}

// all discount
if (!function_exists('carts_product_discount')) {
    function carts_product_discount($cart_products, $formatted = false)
    {
        $discount = 0;
        foreach ($cart_products as $key => $cart_product) {
            $str = '';
            $product = \App\Models\Product::find($cart_product['product_id']);
            if ($cart_product['variation'] != null) {
                $str = $cart_product['variation'];
            }
            $product_stock = $product->stocks->where('variant', $str)->first();
            $price = $product_stock->price;

            //discount calculation
            $discount_applicable = false;

            if ($product->discount_start_date == null) {
                $discount_applicable = true;
            } elseif (
                strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
                strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date
            ) {
                $discount_applicable = true;
            }

            if ($discount_applicable) {
                if ($product->discount_type == 'percent') {
                    $discount += ($price * $product->discount) / 100;
                } elseif ($product->discount_type == 'amount') {
                    $discount += $product->discount;
                }
            }
        }

        if ($formatted) {
            return format_price(convert_price($discount));
        } else {
            return $discount;
        }
    }
}

// carts coupon discount
if (!function_exists('carts_coupon_discount')) {
    function carts_coupon_discount($code, $formatted = false)
    {
        $coupon = Coupon::where('code', $code)->first();
        $coupon_discount = 0;
        if ($coupon != null) {
            if (strtotime(date('d-m-Y')) >= $coupon->start_date && strtotime(date('d-m-Y')) <= $coupon->end_date) {
                if (CouponUsage::where('user_id', Auth::user()->id)->where('coupon_id', $coupon->id)->first() == null) {
                    $coupon_details = json_decode($coupon->details);
                    $carts = Cart::where('user_id', Auth::user()->id)
                        ->where('owner_id', $coupon->user_id)
                        ->get();
                    if ($coupon->type == 'cart_base') {
                        $subtotal = 0;
                        $tax = 0;
                        $shipping = 0;
                        foreach ($carts as $key => $cartItem) {
                            $product = Product::find($cartItem['product_id']);
                            $subtotal += cart_product_price($cartItem, $product, false, false) * $cartItem['quantity'];
                            $tax += cart_product_tax($cartItem, $product, false) * $cartItem['quantity'];
                            $shipping += $cartItem['shipping_cost'];
                        }
                        $sum = $subtotal + $tax + $shipping;
                        if ($sum >= $coupon_details->min_buy) {
                            if ($coupon->discount_type == 'percent') {
                                $coupon_discount = ($sum * $coupon->discount) / 100;
                                if ($coupon_discount > $coupon_details->max_discount) {
                                    $coupon_discount = $coupon_details->max_discount;
                                }
                            } elseif ($coupon->discount_type == 'amount') {
                                $coupon_discount = $coupon->discount;
                            }
                        }
                    } elseif ($coupon->type == 'product_base') {
                        foreach ($carts as $key => $cartItem) {
                            $product = Product::find($cartItem['product_id']);
                            foreach ($coupon_details as $key => $coupon_detail) {
                                if ($coupon_detail->product_id == $cartItem['product_id']) {
                                    if ($coupon->discount_type == 'percent') {
                                        $coupon_discount += (cart_product_price($cartItem, $product, false, false) * $coupon->discount / 100) * $cartItem['quantity'];
                                    } elseif ($coupon->discount_type == 'amount') {
                                        $coupon_discount += $coupon->discount * $cartItem['quantity'];
                                    }
                                }
                            }
                        }
                    }
                }
            }
            if ($coupon_discount > 0) {
                Cart::where('user_id', Auth::user()->id)
                    ->where('owner_id', $coupon->user_id)
                    ->update(
                        [
                            'discount' => $coupon_discount / count($carts),
                        ]
                    );
            } else {
                Cart::where('user_id', Auth::user()->id)
                    ->where('owner_id', $coupon->user_id)
                    ->update(
                        [
                            'discount' => 0,
                            'coupon_code' => null,
                        ]
                    );
            }
        }
        if ($formatted) {
            return format_price(convert_price($coupon_discount));
        } else {
            return $coupon_discount;
        }
    }
}


//Shows Price on page based on low to high
if (!function_exists('home_price')) {
    function home_price($product, $formatted = true)
    {
        $lowest_price = $product->unit_price;
        $highest_price = $product->unit_price;

        if ($product->variant_product) {
            foreach ($product->stocks as $key => $stock) {
                if ($lowest_price > $stock->price) {
                    $lowest_price = $stock->price;
                }
                if ($highest_price < $stock->price) {
                    $highest_price = $stock->price;
                }
            }
        }

        foreach ($product->taxes as $product_tax) {
            if ($product_tax->tax_type == 'percent') {
                $lowest_price += ($lowest_price * $product_tax->tax) / 100;
                $highest_price += ($highest_price * $product_tax->tax) / 100;
            } elseif ($product_tax->tax_type == 'amount') {
                $lowest_price += $product_tax->tax;
                $highest_price += $product_tax->tax;
            }
        }

        if ($formatted) {
            if ($lowest_price == $highest_price) {
                return format_price(convert_price($lowest_price));
            } else {
                return format_price(convert_price($lowest_price)) . ' - ' . format_price(convert_price($highest_price));
            }
        } else {
            return $lowest_price . ' - ' . $highest_price;
        }
    }
}

//Shows Price on page based on low to high with discount
if (!function_exists('home_discounted_price')) {
    function home_discounted_price($product, $formatted = true)
    {
        $lowest_price = $product->unit_price;
        $highest_price = $product->unit_price;

        if ($product->variant_product) {
            foreach ($product->stocks as $key => $stock) {
                if ($lowest_price > $stock->price) {
                    $lowest_price = $stock->price;
                }
                if ($highest_price < $stock->price) {
                    $highest_price = $stock->price;
                }
            }
        }

        $discount_applicable = false;

        if ($product->discount_start_date == null) {
            $discount_applicable = true;
        } elseif (
            strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
            strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date
        ) {
            $discount_applicable = true;
        }

        if ($discount_applicable) {
            if ($product->discount_type == 'percent') {
                $lowest_price -= ($lowest_price * $product->discount) / 100;
                $highest_price -= ($highest_price * $product->discount) / 100;
            } elseif ($product->discount_type == 'amount') {
                $lowest_price -= $product->discount;
                $highest_price -= $product->discount;
            }
        }

        foreach ($product->taxes as $product_tax) {
            if ($product_tax->tax_type == 'percent') {
                $lowest_price += ($lowest_price * $product_tax->tax) / 100;
                $highest_price += ($highest_price * $product_tax->tax) / 100;
            } elseif ($product_tax->tax_type == 'amount') {
                $lowest_price += $product_tax->tax;
                $highest_price += $product_tax->tax;
            }
        }

        if ($formatted) {
            if ($lowest_price == $highest_price) {
                return format_price(convert_price($lowest_price));
            } else {
                return format_price(convert_price($lowest_price)) . ' - ' . format_price(convert_price($highest_price));
            }
        } else {
            return $lowest_price . ' - ' . $highest_price;
        }
    }
}

//Shows Base Price
if (!function_exists('home_base_price_by_stock_id')) {
    function home_base_price_by_stock_id($id)
    {
        $product_stock = ProductStock::findOrFail($id);
        $price = $product_stock->price;
        $tax = 0;

        foreach ($product_stock->product->taxes as $product_tax) {
            if ($product_tax->tax_type == 'percent') {
                $tax += ($price * $product_tax->tax) / 100;
            } elseif ($product_tax->tax_type == 'amount') {
                $tax += $product_tax->tax;
            }
        }
        $price += $tax;
        return format_price(convert_price($price));
    }
}


if (!function_exists('home_base_price')) {
    function home_base_price($product, $formatted = true)
    {
        $price = $product->unit_price;
        $tax = 0;

        foreach ($product->taxes as $product_tax) {
            if ($product_tax->tax_type == 'percent') {
                $tax += ($price * $product_tax->tax) / 100;
            } elseif ($product_tax->tax_type == 'amount') {
                $tax += $product_tax->tax;
            }
        }
        $price += $tax;
        return $formatted ? format_price(convert_price($price)) : convert_price($price);
    }
}

//Shows Base Price with discount
if (!function_exists('home_discounted_base_price_by_stock_id')) {
    function home_discounted_base_price_by_stock_id($id)
    {
        $product_stock = ProductStock::findOrFail($id);
        $product = $product_stock->product;
        $price = $product_stock->price;
        $tax = 0;

        $discount_applicable = false;

        if ($product->discount_start_date == null) {
            $discount_applicable = true;
        } elseif (
            strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
            strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date
        ) {
            $discount_applicable = true;
        }

        if ($discount_applicable) {
            if ($product->discount_type == 'percent') {
                $price -= ($price * $product->discount) / 100;
            } elseif ($product->discount_type == 'amount') {
                $price -= $product->discount;
            }
        }

        foreach ($product->taxes as $product_tax) {
            if ($product_tax->tax_type == 'percent') {
                $tax += ($price * $product_tax->tax) / 100;
            } elseif ($product_tax->tax_type == 'amount') {
                $tax += $product_tax->tax;
            }
        }
        $price += $tax;

        return format_price(convert_price($price));
    }
}


//Shows Base Price with discount
if (!function_exists('home_discounted_base_price')) {
    function home_discounted_base_price($product, $formatted = true)
    {
        $price = $product->unit_price;
        $tax = 0;

        $discount_applicable = false;

        if ($product->discount_start_date == null) {
            $discount_applicable = true;
        } elseif (
            strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
            strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date
        ) {
            $discount_applicable = true;
        }

        if ($discount_applicable) {
            if ($product->discount_type == 'percent') {
                $price -= ($price * $product->discount) / 100;
            } elseif ($product->discount_type == 'amount') {
                $price -= $product->discount;
            }
        }

        foreach ($product->taxes as $product_tax) {
            if ($product_tax->tax_type == 'percent') {
                $tax += ($price * $product_tax->tax) / 100;
            } elseif ($product_tax->tax_type == 'amount') {
                $tax += $product_tax->tax;
            }
        }
        $price += $tax;


        return $formatted ? format_price(convert_price($price)) : convert_price($price);
    }
}

if (!function_exists('renderStarRating')) {
    function renderStarRating($rating, $maxRating = 5)
    {
        $fullStar = "<i class = 'las la-star active'></i>";
        $halfStar = "<i class = 'las la-star half'></i>";
        $emptyStar = "<i class = 'las la-star'></i>";
        $rating = $rating <= $maxRating ? $rating : $maxRating;

        $fullStarCount = (int)$rating;
        $halfStarCount = ceil($rating) - $fullStarCount;
        $emptyStarCount = $maxRating - $fullStarCount - $halfStarCount;

        $html = str_repeat($fullStar, $fullStarCount);
        $html .= str_repeat($halfStar, $halfStarCount);
        $html .= str_repeat($emptyStar, $emptyStarCount);
        echo $html;
    }
}

// function translate($key, $lang = null, $addslashes = false)
// {
//     if ($lang == null) {
//         $lang = App::getLocale();
//     }


//     if ($key !== null) {
//         $lang_key = preg_replace('/[^A-Za-z0-9\_]/', '', str_replace(' ', '_', strtolower($key)));
//     } else {
//         $lang_key = 'en';
//     }

//     // $lang_key = preg_replace('/[^A-Za-z0-9\_]/', '', str_replace(' ', '_', strtolower($key)));

//     $translations_en = Cache::rememberForever('translations-en', function () {
//         return Translation::where('lang', 'en')->pluck('lang_value', 'lang_key')->toArray();
//     });

//     if (!isset($translations_en[$lang_key])) {
//         $translation_def = new Translation;
//         $translation_def->lang = 'en';
//         $translation_def->lang_key = $lang_key;
//         $translation_def->lang_value = str_replace(array("\r", "\n", "\r\n"), "", $key);
//         $translation_def->save();
//         Cache::forget('translations-en');
//     }

//     // return user session lang
//     $translation_locale = Cache::rememberForever("translations-{$lang}", function () use ($lang) {
//         return Translation::where('lang', $lang)->pluck('lang_value', 'lang_key')->toArray();
//     });
//     if (isset($translation_locale[$lang_key])) {
//         return $addslashes ? addslashes(trim($translation_locale[$lang_key])) : trim($translation_locale[$lang_key]);
//     }

//     // return default lang if session lang not found
//     $translations_default = Cache::rememberForever('translations-' . env('DEFAULT_LANGUAGE', 'en'), function () {
//         return Translation::where('lang', env('DEFAULT_LANGUAGE', 'en'))->pluck('lang_value', 'lang_key')->toArray();
//     });

//     if (isset($translations_default[$lang_key])) {
//         return $addslashes ? addslashes(trim($translations_default[$lang_key])) : trim($translations_default[$lang_key]);
//     }

//     // fallback to en lang
//     if (!isset($translations_en[$lang_key])) {
//         return trim($key);
//     }
//     return $addslashes ? addslashes(trim($translations_en[$lang_key])) : trim($translations_en[$lang_key]);
// }

function translate($key, $lang = null, $addslashes = false)
{
    // Use the provided language or default to the application's current locale
    $lang = $lang ?? App::getLocale();

    // Sanitize and generate the translation key
    $lang_key = $key !== null ? preg_replace('/[^A-Za-z0-9_]/', '', str_replace(' ', '_', strtolower($key))) : null;

    if (empty($lang_key)) {
        return ''; // Return an empty string if no valid key is provided
    }

    // Temporarily set the application locale to the desired language
    $currentLocale = App::getLocale();
    App::setLocale($lang);

    // Retrieve the translation
    $translation = __($lang_key);

    // Restore the original locale
    App::setLocale($currentLocale);

    // Check if the translation key was not found and fallback to default language
    if ($translation === $lang_key) {
        $defaultLang = env('DEFAULT_LANGUAGE', 'en');
        $translation = __($lang_key, [], $defaultLang);

        // If still not found, return the original key as a fallback
        if ($translation === $lang_key) {
            $translation = $key;
        }
    }

    // Apply addslashes if needed
    return $addslashes ? addslashes(trim($translation)) : trim($translation);
}

function remove_invalid_charcaters($str)
{
    $str = str_ireplace(array("\\"), '', $str);
    return str_ireplace(array('"'), '\"', $str);
}

if (!function_exists('translation_tables')) {
    function translation_tables($uniqueIdentifier)
    {
        $noTableAddons =  ['african_pg', 'paytm', 'pos_system'];
        if (!in_array($uniqueIdentifier, $noTableAddons)) {
            $addons = [];
            $addons['affiliate'] = ['affiliate_options', 'affiliate_configs', 'affiliate_users', 'affiliate_payments', 'affiliate_withdraw_requests', 'affiliate_logs', 'affiliate_stats'];
            $addons['auction'] = ['auction_product_bids'];
            $addons['club_point'] = ['club_points', 'club_point_details'];
            $addons['delivery_boy'] = ['delivery_boys', 'delivery_histories', 'delivery_boy_payments', 'delivery_boy_collections'];
            $addons['offline_payment'] = ['manual_payment_methods'];
            $addons['otp_system'] = ['otp_configurations', 'sms_templates'];
            $addons['refund_request'] = ['refund_requests'];
            $addons['seller_subscription'] = ['seller_packages', 'seller_package_translations', 'seller_package_payments'];
            $addons['wholesale'] = ['wholesale_prices'];

            foreach ($addons as $key => $addon_tables) {
                if ($key == $uniqueIdentifier) {
                    foreach ($addon_tables as $table) {
                        Schema::dropIfExists($table);
                    }
                }
            }
        }
    }
}

function getShippingCost($carts, $index, $carrier = '')
{
    $shippingType = get_setting('shipping_type');
    $adminProducts = [];
    $sellerProducts = [];
    $adminTotalWeight = 0;
    $adminTotalPrice = 0;
    $sellerTotalWeight = [];
    $sellerTotalPrice = [];

    $cartItem = $carts[$index];
    $product = Product::find($cartItem['product_id']);

    if ($product->digital == 1) {
        return 0;
    }

    foreach ($carts as $cartItem) {
        $itemProduct = Product::find($cartItem['product_id']);
        if ($itemProduct->added_by == 'admin') {
            $adminProducts[] = $cartItem['product_id'];

            if ($shippingType == 'carrier_wise_shipping') {
                $adminTotalWeight += $itemProduct->weight * $cartItem['quantity'];
                $adminTotalPrice += cart_product_price($cartItem, $itemProduct, false, false) * $cartItem['quantity'];
            }
        } else {
            if (!isset($sellerProducts[$itemProduct->user_id])) {
                $sellerProducts[$itemProduct->user_id] = [];
                $sellerTotalWeight[$itemProduct->user_id] = 0;
                $sellerTotalPrice[$itemProduct->user_id] = 0;
            }

            $sellerProducts[$itemProduct->user_id][] = $cartItem['product_id'];

            if ($shippingType == 'carrier_wise_shipping') {
                $sellerTotalWeight[$itemProduct->user_id] += $itemProduct->weight * $cartItem['quantity'];
                $sellerTotalPrice[$itemProduct->user_id] += cart_product_price($cartItem, $itemProduct, false, false) * $cartItem['quantity'];
            }
        }
    }

    if ($shippingType == 'flat_rate') {
        return get_setting('flat_rate_shipping_cost') / count($carts);
    }

    if ($shippingType == 'seller_wise_shipping') {
        if ($product->added_by == 'admin') {
            return get_setting('shipping_cost_admin') / count($adminProducts);
        } else {
            return Shop::where('user_id', $product->user_id)->first()->shipping_cost / count($sellerProducts[$product->user_id]);
        }
    }

    if ($shippingType == 'area_wise_shipping') {
        return calculateAreaWiseShipping($carts, $product, $adminProducts, $sellerProducts);
    }

    if ($shippingType == 'state_wise_shipping') {
        return calculateStateWiseShipping($carts, $product, $adminProducts, $sellerProducts);
    }

    if ($shippingType == 'carrier_wise_shipping') {
        return calculateCarrierWiseShipping($carts, $product, $carrier, $adminTotalWeight, $adminTotalPrice, $sellerTotalWeight, $sellerTotalPrice, $adminProducts, $sellerProducts);
    }

    if ($product->is_quantity_multiplied && $shippingType == 'product_wise_shipping') {
        return $product->shipping_cost * $cartItem['quantity'];
    }

    if ($shippingType == 'custom_shipping') {
        return get_setting('flat_rate_shipping_cost') / count($carts);
    }

    return $product->shipping_cost;
}

function calculateAreaWiseShipping($carts, $product, $adminProducts, $sellerProducts)
{
    $city = getCityFromAddress($carts);

    if ($city) {
        if ($product->added_by == 'admin') {
            return $city->cost / count($adminProducts);
        } else {
            return $city->cost / count($sellerProducts[$product->user_id]);
        }
    }

    return 0;
}

function calculateStateWiseShipping($carts, $product, $adminProducts, $sellerProducts)
{
    $state = getStateFromAddress($carts);

    if ($state) {
        if ($product->added_by == 'admin') {
            return $state->cost / count($adminProducts);
        } else {
            return $state->cost / count($sellerProducts[$product->user_id]);
        }
    }

    return 0;
}

function calculateCarrierWiseShipping($carts, $product, $carrierId, $adminTotalWeight, $adminTotalPrice, $sellerTotalWeight, $sellerTotalPrice, $adminProducts, $sellerProducts)
{
    $userZone = getUserZone($carts);
    if (!$carrierId || !$userZone) {
        return 0;
    }

    $carrier = Carrier::find($carrierId);
    if ($carrier->carrier_ranges->isEmpty()) {
        return 0;
    }

    $carrierRange = $carrier->carrier_ranges->first();
    $carrierBillingType = $carrierRange->billing_type;

    $itemsWeightOrPrice = ($carrierBillingType == 'weight_based')
        ? ($product->added_by == 'admin' ? $adminTotalWeight : $sellerTotalWeight[$product->user_id])
        : ($product->added_by == 'admin' ? $adminTotalPrice : $sellerTotalPrice[$product->user_id]);

    foreach ($carrier->carrier_ranges as $range) {
        if ($itemsWeightOrPrice >= $range->delimiter1 && $itemsWeightOrPrice < $range->delimiter2) {
            $carrierPrice = $range->carrier_range_prices->where('zone_id', $userZone)->first()->price;
            return $product->added_by == 'admin'
                ? ($carrierPrice / count($adminProducts))
                : ($carrierPrice / count($sellerProducts[$product->user_id]));
        }
    }

    return 0;
}

function calculateCustomShipping($carts, $product, $adminProducts, $sellerProducts) {}

function getCityFromAddress($carts)
{
    if (auth()->user()) {
        $shippingInfo = Address::find($carts[0]['address_id']);
        if ($shippingInfo) {
            return City::find($shippingInfo->city_id);
        }
    } else {
        $guestShippingInfo = Session::get('guest_shipping_info');
        if ($guestShippingInfo && isset($guestShippingInfo['city_id'])) {
            return City::find($guestShippingInfo['city_id']);
        }
    }

    return null;
}

function getStateFromAddress($carts)
{
    if (auth()->user()) {
        $shippingInfo = Address::find($carts[0]['address_id']);
        if ($shippingInfo) {
            return State::find($shippingInfo->state_id);
        }
    } else {
        $guestShippingInfo = Session::get('guest_shipping_info');
        if ($guestShippingInfo && isset($guestShippingInfo['state_id'])) {
            return State::find($guestShippingInfo['state_id']);
        }
    }

    return null;
}

function getUserZone($carts)
{
    if (auth()->user()) {
        return Address::find($carts[0]['address_id'])->country->zone_id;
    } else {
        $guestShippingInfo = Session::get('guest_shipping_info');
        if ($guestShippingInfo && isset($guestShippingInfo['country_id'])) {
            return Country::find($guestShippingInfo['country_id'])->zone_id;
        }
    }

    return 0;
}


//return carrier wise shipping cost against seller
if (!function_exists('carrier_base_price')) {
    function carrier_base_price($carts, $carrier_id, $owner_id)
    {
        $shipping = 0;
        foreach ($carts as $key => $cartItem) {
            if ($cartItem->owner_id == $owner_id) {
                $shipping_cost = getShippingCost($carts, $key, $carrier_id);
                $shipping += $shipping_cost;
            }
        }
        return $shipping;
    }
}

//return seller wise carrier list
if (!function_exists('seller_base_carrier_list')) {
    function seller_base_carrier_list($owner_id)
    {
        $carrier_list = array();
        $carts = Cart::where('user_id', auth()->user()->id)->get();
        if (count($carts) > 0) {
            $zone = $carts[0]['address'] ? Country::where('id', $carts[0]['address']['country_id'])->first()->zone_id : null;
            $carrier_query = Carrier::query();
            $carrier_query->whereIn('id', function ($query) use ($zone) {
                $query->select('carrier_id')->from('carrier_range_prices')
                    ->where('zone_id', $zone);
            })->orWhere('free_shipping', 1);
            $carrier_list = $carrier_query->active()->get();
        }
        return (new CarrierCollection($carrier_list))->extra($owner_id);
    }
}

function timezones()
{
    return array(
        '(GMT-12:00) International Date Line West' => 'Pacific/Kwajalein',
        '(GMT-11:00) Midway Island' => 'Pacific/Midway',
        '(GMT-11:00) Samoa' => 'Pacific/Apia',
        '(GMT-10:00) Hawaii' => 'Pacific/Honolulu',
        '(GMT-09:00) Alaska' => 'America/Anchorage',
        '(GMT-08:00) Pacific Time (US & Canada)' => 'America/Los_Angeles',
        '(GMT-08:00) Tijuana' => 'America/Tijuana',
        '(GMT-07:00) Arizona' => 'America/Phoenix',
        '(GMT-07:00) Mountain Time (US & Canada)' => 'America/Denver',
        '(GMT-07:00) Chihuahua' => 'America/Chihuahua',
        '(GMT-07:00) La Paz' => 'America/Chihuahua',
        '(GMT-07:00) Mazatlan' => 'America/Mazatlan',
        '(GMT-06:00) Central Time (US & Canada)' => 'America/Chicago',
        '(GMT-06:00) Central America' => 'America/Managua',
        '(GMT-06:00) Guadalajara' => 'America/Mexico_City',
        '(GMT-06:00) Mexico City' => 'America/Mexico_City',
        '(GMT-06:00) Monterrey' => 'America/Monterrey',
        '(GMT-06:00) Saskatchewan' => 'America/Regina',
        '(GMT-05:00) Eastern Time (US & Canada)' => 'America/New_York',
        '(GMT-05:00) Indiana (East)' => 'America/Indiana/Indianapolis',
        '(GMT-05:00) Bogota' => 'America/Bogota',
        '(GMT-05:00) Lima' => 'America/Lima',
        '(GMT-05:00) Quito' => 'America/Bogota',
        '(GMT-04:00) Atlantic Time (Canada)' => 'America/Halifax',
        '(GMT-04:00) Caracas' => 'America/Caracas',
        '(GMT-04:00) La Paz' => 'America/La_Paz',
        '(GMT-04:00) Santiago' => 'America/Santiago',
        '(GMT-03:30) Newfoundland' => 'America/St_Johns',
        '(GMT-03:00) Brasilia' => 'America/Sao_Paulo',
        '(GMT-03:00) Buenos Aires' => 'America/Argentina/Buenos_Aires',
        '(GMT-03:00) Georgetown' => 'America/Argentina/Buenos_Aires',
        '(GMT-03:00) Greenland' => 'America/Godthab',
        '(GMT-02:00) Mid-Atlantic' => 'America/Noronha',
        '(GMT-01:00) Azores' => 'Atlantic/Azores',
        '(GMT-01:00) Cape Verde Is.' => 'Atlantic/Cape_Verde',
        '(GMT) Casablanca' => 'Africa/Casablanca',
        '(GMT) Dublin' => 'Europe/London',
        '(GMT) Edinburgh' => 'Europe/London',
        '(GMT) Lisbon' => 'Europe/Lisbon',
        '(GMT) London' => 'Europe/London',
        '(GMT) UTC' => 'UTC',
        '(GMT) Monrovia' => 'Africa/Monrovia',
        '(GMT+01:00) Amsterdam' => 'Europe/Amsterdam',
        '(GMT+01:00) Belgrade' => 'Europe/Belgrade',
        '(GMT+01:00) Berlin' => 'Europe/Berlin',
        '(GMT+01:00) Bern' => 'Europe/Berlin',
        '(GMT+01:00) Bratislava' => 'Europe/Bratislava',
        '(GMT+01:00) Brussels' => 'Europe/Brussels',
        '(GMT+01:00) Budapest' => 'Europe/Budapest',
        '(GMT+01:00) Copenhagen' => 'Europe/Copenhagen',
        '(GMT+01:00) Ljubljana' => 'Europe/Ljubljana',
        '(GMT+01:00) Madrid' => 'Europe/Madrid',
        '(GMT+01:00) Paris' => 'Europe/Paris',
        '(GMT+01:00) Prague' => 'Europe/Prague',
        '(GMT+01:00) Rome' => 'Europe/Rome',
        '(GMT+01:00) Sarajevo' => 'Europe/Sarajevo',
        '(GMT+01:00) Skopje' => 'Europe/Skopje',
        '(GMT+01:00) Stockholm' => 'Europe/Stockholm',
        '(GMT+01:00) Vienna' => 'Europe/Vienna',
        '(GMT+01:00) Warsaw' => 'Europe/Warsaw',
        '(GMT+01:00) West Central Africa' => 'Africa/Lagos',
        '(GMT+01:00) Zagreb' => 'Europe/Zagreb',
        '(GMT+02:00) Athens' => 'Europe/Athens',
        '(GMT+02:00) Bucharest' => 'Europe/Bucharest',
        '(GMT+02:00) Cairo' => 'Africa/Cairo',
        '(GMT+02:00) Harare' => 'Africa/Harare',
        '(GMT+02:00) Helsinki' => 'Europe/Helsinki',
        '(GMT+02:00) Istanbul' => 'Europe/Istanbul',
        '(GMT+02:00) Jerusalem' => 'Asia/Jerusalem',
        '(GMT+02:00) Kyev' => 'Europe/Kiev',
        '(GMT+02:00) Minsk' => 'Europe/Minsk',
        '(GMT+02:00) Pretoria' => 'Africa/Johannesburg',
        '(GMT+02:00) Riga' => 'Europe/Riga',
        '(GMT+02:00) Sofia' => 'Europe/Sofia',
        '(GMT+02:00) Tallinn' => 'Europe/Tallinn',
        '(GMT+02:00) Vilnius' => 'Europe/Vilnius',
        '(GMT+03:00) Baghdad' => 'Asia/Baghdad',
        '(GMT+03:00) Kuwait' => 'Asia/Kuwait',
        '(GMT+03:00) Moscow' => 'Europe/Moscow',
        '(GMT+03:00) Nairobi' => 'Africa/Nairobi',
        '(GMT+03:00) Riyadh' => 'Asia/Riyadh',
        '(GMT+03:00) St. Petersburg' => 'Europe/Moscow',
        '(GMT+03:00) Volgograd' => 'Europe/Volgograd',
        '(GMT+03:30) Tehran' => 'Asia/Tehran',
        '(GMT+04:00) Abu Dhabi' => 'Asia/Muscat',
        '(GMT+04:00) Baku' => 'Asia/Baku',
        '(GMT+04:00) Muscat' => 'Asia/Muscat',
        '(GMT+04:00) Tbilisi' => 'Asia/Tbilisi',
        '(GMT+04:00) Yerevan' => 'Asia/Yerevan',
        '(GMT+04:30) Kabul' => 'Asia/Kabul',
        '(GMT+05:00) Ekaterinburg' => 'Asia/Yekaterinburg',
        '(GMT+05:00) Islamabad' => 'Asia/Karachi',
        '(GMT+05:00) Karachi' => 'Asia/Karachi',
        '(GMT+05:00) Tashkent' => 'Asia/Tashkent',
        '(GMT+05:30) Chennai' => 'Asia/Kolkata',
        '(GMT+05:30) Kolkata' => 'Asia/Kolkata',
        '(GMT+05:30) Mumbai' => 'Asia/Kolkata',
        '(GMT+05:30) New Delhi' => 'Asia/Kolkata',
        '(GMT+05:45) Kathmandu' => 'Asia/Kathmandu',
        '(GMT+06:00) Almaty' => 'Asia/Almaty',
        '(GMT+06:00) Astana' => 'Asia/Dhaka',
        '(GMT+06:00) Dhaka' => 'Asia/Dhaka',
        '(GMT+06:00) Novosibirsk' => 'Asia/Novosibirsk',
        '(GMT+06:00) Sri Jayawardenepura' => 'Asia/Colombo',
        '(GMT+06:30) Rangoon' => 'Asia/Rangoon',
        '(GMT+07:00) Bangkok' => 'Asia/Bangkok',
        '(GMT+07:00) Hanoi' => 'Asia/Bangkok',
        '(GMT+07:00) Jakarta' => 'Asia/Jakarta',
        '(GMT+07:00) Krasnoyarsk' => 'Asia/Krasnoyarsk',
        '(GMT+08:00) Beijing' => 'Asia/Hong_Kong',
        '(GMT+08:00) Chongqing' => 'Asia/Chongqing',
        '(GMT+08:00) Hong Kong' => 'Asia/Hong_Kong',
        '(GMT+08:00) Irkutsk' => 'Asia/Irkutsk',
        '(GMT+08:00) Kuala Lumpur' => 'Asia/Kuala_Lumpur',
        '(GMT+08:00) Perth' => 'Australia/Perth',
        '(GMT+08:00) Singapore' => 'Asia/Singapore',
        '(GMT+08:00) Taipei' => 'Asia/Taipei',
        '(GMT+08:00) Ulaan Bataar' => 'Asia/Irkutsk',
        '(GMT+08:00) Urumqi' => 'Asia/Urumqi',
        '(GMT+09:00) Osaka' => 'Asia/Tokyo',
        '(GMT+09:00) Sapporo' => 'Asia/Tokyo',
        '(GMT+09:00) Seoul' => 'Asia/Seoul',
        '(GMT+09:00) Tokyo' => 'Asia/Tokyo',
        '(GMT+09:00) Yakutsk' => 'Asia/Yakutsk',
        '(GMT+09:30) Adelaide' => 'Australia/Adelaide',
        '(GMT+09:30) Darwin' => 'Australia/Darwin',
        '(GMT+10:00) Brisbane' => 'Australia/Brisbane',
        '(GMT+10:00) Canberra' => 'Australia/Sydney',
        '(GMT+10:00) Guam' => 'Pacific/Guam',
        '(GMT+10:00) Hobart' => 'Australia/Hobart',
        '(GMT+10:00) Melbourne' => 'Australia/Melbourne',
        '(GMT+10:00) Port Moresby' => 'Pacific/Port_Moresby',
        '(GMT+10:00) Sydney' => 'Australia/Sydney',
        '(GMT+10:00) Vladivostok' => 'Asia/Vladivostok',
        '(GMT+11:00) Magadan' => 'Asia/Magadan',
        '(GMT+11:00) New Caledonia' => 'Asia/Magadan',
        '(GMT+11:00) Solomon Is.' => 'Asia/Magadan',
        '(GMT+12:00) Auckland' => 'Pacific/Auckland',
        '(GMT+12:00) Fiji' => 'Pacific/Fiji',
        '(GMT+12:00) Kamchatka' => 'Asia/Kamchatka',
        '(GMT+12:00) Marshall Is.' => 'Pacific/Fiji',
        '(GMT+12:00) Wellington' => 'Pacific/Auckland',
        '(GMT+13:00) Nuku\'alofa' => 'Pacific/Tongatapu'
    );
}

if (!function_exists('app_timezone')) {
    function app_timezone()
    {
        return config('app.timezone');
    }
}

//return file uploaded via uploader
if (!function_exists('uploaded_asset')) {
    function uploaded_asset($id)
    {
        if (($asset = Upload::find($id)) != null) {
            return $asset->external_link == null ? my_asset($asset->file_name) : $asset->external_link;
        }
        return static_asset('assets/img/placeholderx200.webp');
    }
}

//return file uploaded via uploader
if (!function_exists('uploaded_thumbnail')) {
    function uploaded_thumbnail($id)
    {
        if (($asset = Upload::find($id)) != null) {
            if ($asset->thumbnail) {
                return $asset->external_link == null ? my_asset($asset->thumbnail) : $asset->external_link;
            } else {
                return $asset->external_link == null ? my_asset($asset->file_name) : $asset->external_link;
            }
        }
        return static_asset('assets/img/placeholderx200.webp');
    }
}

if (!function_exists('get_cdn_url')) {
    function get_cdn_url()
    {
        // Return CDN URL from session if available
        if (Session::has('cdn_url')) {
            return Session::get('cdn_url');
        }

        $cdn_url = 'https://sg.zo.tc/';

        // Get the client's IP address
        $ip = request()->ip();

        // Fetch location info based on IP
        $url = "https://ipinfo.zotc.pw/api/api.php?ip={$ip}";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);

        // Decode the response
        $output = json_decode($output, true);

        //check if output status is success, then proceed...if not, return default CDN URL
        if ($output['status'] == 'success' && $output['country'] == 'Bangladesh') {
            $cdn_url = 'https://i.zo.tc/';
        }

        // Store CDN URL in session
        Session::put('cdn_url', $cdn_url);

        return $cdn_url;
    }
}

if (!function_exists('my_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param string $path
     * @param bool|null $secure
     * @return string
     */
    function my_asset($path, $secure = null)
    {
        // if (config('filesystems.default') != 'local') {
        //     return Storage::disk(config('filesystems.default'))->url($path);
        // }

        $fixedBaseUrl = get_cdn_url();

        $formattedPath = ltrim($path, '/');

        return $fixedBaseUrl . $formattedPath;
    }
}

if (!function_exists('static_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param string $path
     * @param bool|null $secure
     * @return string
     */
    function static_asset($path, $secure = null)
    {
        $fixedBaseUrl = get_cdn_url();

        $formattedPath = ltrim($path, '/');

        return $fixedBaseUrl . $formattedPath;
        // return app('url')->asset('public/' . $path, $secure);
    }
}

// if (!function_exists('isHttps')) {
//     function isHttps()
//     {
//         return !empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS']);
//     }
// }

if (!function_exists('getBaseURL')) {
    function getBaseURL()
    {
        $root = '//' . $_SERVER['HTTP_HOST'];
        $root .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

        return $root;
    }
}


if (!function_exists('getFileBaseURL')) {
    function getFileBaseURL()
    {
        if (env('FILESYSTEM_DRIVER') != 'local') {
            return env(Str::upper(env('FILESYSTEM_DRIVER')) . '_URL') . '/';
        }

        return getBaseURL() . 'public/';
    }
}


if (!function_exists('isUnique')) {
    /**
     * Generate an asset path for the application.
     *
     * @param string $path
     * @param bool|null $secure
     * @return string
     */
    function isUnique($email)
    {
        $user = \App\Models\User::where('email', $email)->first();

        if ($user == null) {
            return '1'; // $user = null means we did not get any match with the email provided by the user inside the database
        } else {
            return '0';
        }
    }
}

if (!function_exists('get_domain')) {
    function get_domain()
    {
        return request()->getHost();
    }
}

if (!function_exists('get_free_domain_slug')) {
    function get_free_domain_slug()
    {
        $domains = json_decode(get_setting('domains'));
        $free_domain = $domains->free_domain;
        $parts = explode('.', $free_domain);
        $free_domain_slug = $parts[0];

        return $free_domain_slug;
    }
}

if (!function_exists('get_setting')) {
    function get_setting($key, $default = null, $lang = false)
    {
        $business_settings = Cache::remember(get_domain() . '_business_settings', 2592000, function () {
            return BusinessSetting::all();
        });

        // $business_settings = Session::get('business_settings');
        // if (!$business_settings) {
        //     $business_settings = BusinessSetting::all();
        //     Session::put('business_settings', $business_settings);
        // }

        // Retrieve the setting based on the key and optional language
        $setting = $business_settings->where('type', $key);
        if ($lang) {
            $setting = $setting->where('lang', $lang)->first();
        } else {
            $setting = $setting->first();
        }

        // Return the setting value or default if not found
        return $setting ? $setting->value : $default;
    }
}

if (!function_exists('get_zotc_setting')) {
    function get_zotc_setting($key, $default = null, $lang = false)
    {
        // Retrieve the setting based on the key and optional language
        $query = ZotcSetting::where('type', $key);

        if ($lang) {
            $query->where('lang', $lang);
        }

        $setting = $query->first();

        // Return the setting value or default if not found
        return $setting ? $setting->value : $default;
    }
}

if (!function_exists('get_business_setting')) {
    function get_business_setting($key, $default = null, $lang = false)
    {
        $query = BusinessSetting::where('type', $key);

        if ($lang) {
            $query->where('lang', $lang);
        }

        $setting = $query->first();

        return $setting ? $setting->value : $default;
    }
}

if (!function_exists('get_cart_setting')) {
    function get_cart_setting($key, $default = null)
    {
        $settings = CartSetting::query();
        $setting = $settings->where('type', $key)->first();

        return $setting == null ? $default : $setting->value;
    }
}

function hex2rgba($color, $opacity = false)
{
    return (new ColorCodeConverter())->convertHexToRgba($color, $opacity);
}

if (!function_exists('isAdmin')) {
    function isAdmin()
    {
        if (Auth::check() && (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff')) {
            return true;
        }
        return false;
    }
}

if (!function_exists('isSeller')) {
    function isSeller()
    {
        if (Auth::check() && Auth::user()->user_type == 'seller') {
            return true;
        }
        return false;
    }
}

if (!function_exists('isCustomer')) {
    function isCustomer()
    {
        if (Auth::check() && Auth::user()->user_type == 'customer') {
            return true;
        }
        return false;
    }
}

if (!function_exists('formatBytes')) {
    function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        // Uncomment one of the following alternatives
        $bytes /= pow(1024, $pow);
        // $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}

// duplicates m$ excel's ceiling function
if (!function_exists('ceiling')) {
    function ceiling($number, $significance = 1)
    {
        return (is_numeric($number) && is_numeric($significance)) ? (ceil($number / $significance) * $significance) : false;
    }
}

//for api
if (!function_exists('get_images_path')) {
    function get_images_path($given_ids, $with_trashed = false)
    {
        $paths = [];
        foreach (explode(',', $given_ids) as $id) {
            $paths[] = uploaded_asset($id);
        }

        return $paths;
    }
}

//for api
if (!function_exists('checkout_done')) {
    function checkout_done($combined_order_id, $payment)
    {
        $combined_order = CombinedOrder::find($combined_order_id);

        foreach ($combined_order->orders as $key => $order) {
            $order->payment_status = 'paid';
            $order->payment_details = $payment;
            $order->save();

            try {
                NotificationUtility::sendOrderPlacedNotification($order);
                calculateCommissionAffilationClubPoint($order);
            } catch (\Exception $e) {
            }
        }
    }
}

// get user total ordered products
if (!function_exists('get_user_total_ordered_products')) {
    function get_user_total_ordered_products()
    {
        $orders_query = Order::query();
        $orders       = $orders_query->where('user_id', Auth::user()->id)->get();
        $total        = 0;
        foreach ($orders as $order) {
            $total += count($order->orderDetails);
        }
        return $total;
    }
}

//for api
if (!function_exists('wallet_payment_done')) {
    function wallet_payment_done($user_id, $amount, $payment_method, $payment_details)
    {
        $user = \App\Models\User::find($user_id);
        $user->balance = $user->balance + $amount;
        $user->save();

        $wallet = new Wallet;
        $wallet->user_id = $user->id;
        $wallet->amount = $amount;
        $wallet->payment_method = $payment_method;
        $wallet->payment_details = $payment_details;
        $wallet->save();
    }
}

if (!function_exists('purchase_payment_done')) {
    function purchase_payment_done($user_id, $package_id)
    {
        $user = User::findOrFail($user_id);
        $user->customer_package_id = $package_id;
        $customer_package = CustomerPackage::findOrFail($package_id);
        $user->remaining_uploads += $customer_package->product_upload;
        $user->save();

        return 'success';
    }
}

if (!function_exists('seller_purchase_payment_done')) {
    function seller_purchase_payment_done($user_id, $seller_package_id, $amount, $payment_method, $payment_details)
    {
        $seller = Shop::where('user_id', $user_id)->first();
        $seller->seller_package_id = $seller_package_id;
        $seller_package = SellerPackage::findOrFail($seller_package_id);
        $seller->product_upload_limit = $seller_package->product_upload_limit;
        $seller->package_invalid_at = date('Y-m-d', strtotime($seller->package_invalid_at . ' +' . $seller_package->duration . 'days'));
        $seller->save();

        $seller_package = new SellerPackagePayment();
        $seller_package->user_id = $user_id;
        $seller_package->seller_package_id = $seller_package_id;
        $seller_package->payment_method = $payment_method;
        $seller_package->payment_details = $payment_details;
        $seller_package->approval = 1;
        $seller_package->offline_payment = 2;
        $seller_package->save();
    }
}

if (!function_exists('customer_purchase_payment_done')) {
    function customer_purchase_payment_done($user_id, $customer_package_id)
    {
        $user = User::findOrFail($user_id);
        $user->customer_package_id = $customer_package_id;
        $customer_package = CustomerPackage::findOrFail($customer_package_id);
        $user->remaining_uploads += $customer_package->product_upload;
        $user->save();
    }
}

if (!function_exists('product_restock')) {
    function product_restock($orderDetail)
    {
        $variant = $orderDetail->variation;
        if ($orderDetail->variation == null) {
            $variant = '';
        }

        $product_stock = ProductStock::where('product_id', $orderDetail->product_id)
            ->where('variant', $variant)
            ->first();

        if ($product_stock != null && (!in_array($orderDetail->delivery_status, ['delivered', 'cancelled']))) {
            $product = $product_stock->product;
            $product->num_of_sale -= $orderDetail->quantity;
            $product->save();

            $product_stock->qty += $orderDetail->quantity;
            $product_stock->save();
        }
    }
}

//Commission Calculation
if (!function_exists('calculateCommissionAffilationClubPoint')) {
    function calculateCommissionAffilationClubPoint($order)
    {
        (new CommissionController)->calculateCommission($order);

        if (addon_is_activated('affiliate_system')) {
            (new AffiliateController)->processAffiliatePoints($order);
        }

        if (addon_is_activated('club_point')) {
            if ($order->user != null) {
                (new ClubPointController)->processClubPoints($order);
            }
        }

        $order->commission_calculated = 1;
        $order->save();
    }
}

// Addon Activation Check
if (!function_exists('addon_is_activated')) {
    function addon_is_activated($identifier, $default = null)
    {
        $addons = Cache::remember(get_domain() . '_addons', 2592000, function () {
            return Addon::all();
        });

        $activation = $addons->where('unique_identifier', $identifier)->where('activated', 1)->first();
        return $activation == null ? false : true;
    }
}

// Addon Activation Check
if (!function_exists('seller_package_validity_check')) {
    function seller_package_validity_check($user_id = null)
    {
        $user = $user_id == null ? \App\Models\User::find(Auth::user()->id) : \App\Models\User::find($user_id);
        $shop = $user->shop;
        $package_validation = false;
        if (
            $shop->product_upload_limit > $shop->user->products()->count()
            && $shop->package_invalid_at != null
            && Carbon::now()->diffInDays(Carbon::parse($shop->package_invalid_at), false) >= 0
        ) {
            $package_validation = true;
        }

        return $package_validation;
        // Ture = Seller package is valid and seller has the product upload limit
        // False = Seller package is invalid or seller product upload limit exists.
    }
}

// Get URL params
if (!function_exists('get_url_params')) {
    function get_url_params($url, $key)
    {
        $query_str = parse_url($url, PHP_URL_QUERY);
        parse_str($query_str, $query_params);

        return $query_params[$key] ?? '';
    }
}

// get Admin
if (!function_exists('get_admin')) {
    function get_admin()
    {
        $admin_query = User::query();
        return $admin_query->where('user_type', 'admin')->first();
    }
}

// Get slider images
if (!function_exists('get_slider_images')) {
    function get_slider_images($ids)
    {
        $slider_query = Upload::query();
        $sliders = $slider_query->select('file_name', 'thumbnail')->whereIn('id', $ids)->get();
        return $sliders;
    }
}

if (!function_exists('get_only_slider_images')) {
    function get_only_slider_images()
    {
        $ids = json_decode(get_setting('home_slider_images'));

        // Query the uploads table for slider images by their IDs
        $sliders = Upload::select('thumbnail')
            ->whereIn('id', $ids)
            ->get();

        // Map through the collection to get the URLs for each thumbnail
        return $sliders->map(function ($slider) {
            return my_asset($slider->thumbnail); // Generate the full URL for each thumbnail
        });
    }
}


if (!function_exists('get_featured_flash_deal')) {
    function get_featured_flash_deal()
    {
        $flash_deal_query = FlashDeal::query();
        $featured_flash_deal = $flash_deal_query->isActiveAndFeatured()
            ->where('start_date', '<=', strtotime(date('Y-m-d H:i:s')))
            ->where('end_date', '>=', strtotime(date('Y-m-d H:i:s')))
            ->first();

        return $featured_flash_deal;
    }
}

if (!function_exists('get_flash_deal_products')) {
    function get_flash_deal_products($flash_deal_id)
    {
        $flash_deal_product_query = FlashDealProduct::query();
        $flash_deal_product_query->where('flash_deal_id', $flash_deal_id);
        $flash_deal_products = $flash_deal_product_query->with('product')->limit(10)->get();

        return $flash_deal_products;
    }
}

if (!function_exists('get_active_flash_deals')) {
    function get_active_flash_deals()
    {
        $activated_flash_deal_query = FlashDeal::query();
        $activated_flash_deal_query = $activated_flash_deal_query->where("status", 1);

        return $activated_flash_deal_query->get();
    }
}

if (!function_exists('get_active_taxes')) {
    function get_active_taxes()
    {
        $activated_tax_query = Tax::query();
        $activated_tax_query = $activated_tax_query->where("tax_status", 1);

        return $activated_tax_query->get();
    }
}

if (!function_exists('get_system_language')) {
    function get_system_language()
    {
        // Cache the list of languages for 30 days (2592000 seconds)
        $all_languages = Cache::remember(get_domain() . '_all_languages', 2592000, function () {
            return Language::all();
        });

        // Get the locale from the session or fall back to the app's default locale
        $locale = Session::get('locale', Config::get('app.locale'));

        // Filter the languages collection to find the one matching the locale
        $language = $all_languages->firstWhere('code', $locale);

        // If the language is not found, fall back to English
        if (!$language) {
            $language = $all_languages->firstWhere('code', 'en');
        }

        return $language;
    }
}

if (!function_exists('get_all_active_language')) {
    function get_all_active_language()
    {
        $language_query = Language::query();
        $language_query->where('status', 1);

        return $language_query->get();
    }
}

// get Session langauge
if (!function_exists('get_session_language')) {
    function get_session_language()
    {
        $language = Session::get('language');

        if (!$language) {
            $language = Language::all();
            Session::put('language', $language);
        } else {
            $language = collect($language);
        }

        $locale = Session::get('locale', Config::get('app.locale'));

        return $language->where('code', $locale)->first();
    }
}


if (!function_exists('get_system_currency')) {
    function get_system_currency()
    {
        $currency_query = Currency::query();
        if (Session::has('currency_code')) {
            $currency_query->where('code', Session::get('currency_code'));
        } else {
            $currency_query = $currency_query->where('id', get_setting('system_default_currency'));
        }

        return $currency_query->first();
    }
}

if (!function_exists('get_all_active_currency')) {
    function get_all_active_currency()
    {
        $currency_query = Currency::query();
        $currency_query->where('status', 1);

        return $currency_query->get();
    }
}

if (!function_exists('get_single_product')) {
    function get_single_product($product_id)
    {
        $product_query = Product::query()->with('thumbnail');
        return $product_query->find($product_id);
    }
}

// get multiple Products
if (!function_exists('get_multiple_products')) {
    function get_multiple_products($product_ids)
    {
        $products_query = Product::query();
        return $products_query->whereIn('id', $product_ids)->get();
    }
}

// get count of products
if (!function_exists('get_products_count')) {
    function get_products_count($user_id = null)
    {
        $products_query = Product::query();
        if ($user_id) {
            $products_query = $products_query->where('user_id', $user_id);
        }
        return $products_query->isApprovedPublished()->count();
    }
}

// get minimum unit price of products
if (!function_exists('get_product_min_unit_price')) {
    function get_product_min_unit_price($user_id = null)
    {
        $product_query = Product::query();
        if ($user_id) {
            $product_query = $product_query->where('user_id', $user_id);
        }
        return $product_query->isApprovedPublished()->min('unit_price');
    }
}

// get maximum unit price of products
if (!function_exists('get_product_max_unit_price')) {
    function get_product_max_unit_price($user_id = null)
    {
        $product_query = Product::query();
        if ($user_id) {
            $product_query = $product_query->where('user_id', $user_id);
        }
        return $product_query->isApprovedPublished()->max('unit_price');
    }
}

if (!function_exists('get_featured_products')) {
    function get_featured_products()
    {
        return Cache::remember(get_domain() . '_featured_products', 2592000, function () {
            $product_query = Product::where('featured', 1);

            return filter_products($product_query)->latest()->limit(12)->get();
        });
    }
}

if (!function_exists('get_featured_categories')) {
    function get_featured_categories()
    {
        return Cache::remember(get_domain() . '_featured_categories', 2592000, function () {
            return Category::with('bannerImage')->where('featured', 1)->get();
        });
    }
}

if (!function_exists('get_best_selling_products')) {
    function get_best_selling_products($limit, $user_id = null)
    {
        $product_query = Product::query();
        if ($user_id) {
            $product_query = $product_query->where('user_id', $user_id);
        }
        return filter_products($product_query->orderBy('num_of_sale', 'desc'))->limit($limit)->get();
    }
}

// Get Seller Products
if (!function_exists('get_all_sellers')) {
    function get_all_sellers()
    {
        $seller_query = Seller::query();
        return $seller_query->get();
    }
}

// Get Seller Products
if (!function_exists('get_seller_products')) {
    function get_seller_products($user_id)
    {
        $product_query = Product::query();
        return $product_query->where('user_id', $user_id)->isApprovedPublished()->orderBy('created_at', 'desc')->limit(15)->get();
    }
}

// Get Seller Best Selling Products
if (!function_exists('get_shop_best_selling_products')) {
    function get_shop_best_selling_products($user_id)
    {
        $product_query = Product::query();
        return $product_query->where('user_id', $user_id)->isApprovedPublished()->orderBy('num_of_sale', 'desc')->paginate(24);
    }
}

// Get all auction Products
if (!function_exists('get_all_auction_products')) {
    function get_auction_products($limit = null, $paginate = null)
    {
        $product_query = Product::query();
        $products = $product_query->latest()->isApprovedPublished()->where('auction_product', 1);
        if (get_setting('seller_auction_product') == 0) {
            $products = $products->where('added_by', 'admin');
        }
        $products = $products->where('auction_start_date', '<=', strtotime("now"))->where('auction_end_date', '>=', strtotime("now"));

        if ($limit) {
            $products = $products->limit($limit);
        } elseif ($paginate) {
            return $products->paginate($paginate);
        }
        return $products->get();
    }
}

//Get similiar classified products
if (!function_exists('get_similiar_classified_products')) {
    function get_similiar_classified_products($category_id = '', $product_id = '', $limit = '')
    {
        $classified_product_query = CustomerProduct::query();
        if ($category_id) {
            $classified_product_query->where('category_id', $category_id);
        }
        if ($product_id) {
            $classified_product_query->where('id', '!=', $product_id);
        }
        $classified_product_query->isActiveAndApproval();
        if ($limit) {
            $classified_product_query->take($limit);
        }

        return $classified_product_query->get();
    }
}

//Get home page classified products
if (!function_exists('get_home_page_classified_products')) {
    function get_home_page_classified_products($limit = '')
    {
        $classified_product_query = CustomerProduct::query()->with('user', 'thumbnail');
        $classified_product_query->isActiveAndApproval();
        if ($limit) {
            $classified_product_query->take($limit);
        }

        return $classified_product_query->get();
    }
}


// Get related product
if (!function_exists('get_related_products')) {
    function get_related_products($product)
    {
        $productSelectionType = $product->frequently_bought_selection_type;
        $fqbProducts = [];
        if ($productSelectionType == 'product') {
            $fqbProductIds = $product->frequently_bought_products()->where('category_id', null)->pluck('frequently_bought_product_id')->toArray();
            $fqbProducts = filter_products(Product::whereIn('id', $fqbProductIds))->get();
        } elseif ($productSelectionType == 'category') {
            $fqb_product_category = $product->frequently_bought_products()->where('category_id', '!=', null)->first();
            $fqbCategoryID = $fqb_product_category != null ? $fqb_product_category->category_id : null;
            if ($fqbCategoryID != null) {
                $category = Category::with('childrenCategories')->find($fqbCategoryID);

                $fqbProducts = $category->products()->where('id', '!=', $product->id);
                $fqbProducts = $product->added_by == 'admin' ? $fqbProducts->where('added_by', 'admin') : $fqbProducts->where('user_id', $product->user_id);

                $fqbProducts = filter_products($fqbProducts)->orderByRaw('RAND()')->take(10)->get();
            }
        }
        return $fqbProducts;
    }
}

// Get all brands
if (!function_exists('get_all_brands')) {
    function get_all_brands()
    {
        $brand_query = Brand::query();
        return  $brand_query->get();
    }
}

// Get single brands
if (!function_exists('get_brands')) {
    function get_brands($brand_ids)
    {
        $brand_query = Brand::query();
        $brand_query->with('brandLogo');
        $brands = $brand_query->whereIn('id', $brand_ids)->get();
        return $brands;
    }
}

// Get single brands
if (!function_exists('get_single_brand')) {
    function get_single_brand($brand_id)
    {
        $brand_query = Brand::query();
        return $brand_query->find($brand_id);
    }
}

// Get Brands by products
if (!function_exists('get_brands_by_products')) {
    function get_brands_by_products($usrt_id)
    {
        $product_query = Product::query();
        $brand_ids =  $product_query->where('user_id', $usrt_id)->isApprovedPublished()->whereNotNull('brand_id')->pluck('brand_id')->toArray();

        $brand_query = Brand::query();
        return $brand_query->whereIn('id', $brand_ids)->get();
    }
}

// Get category
if (!function_exists('get_category')) {
    function get_category($category_ids)
    {
        $category_query = Category::query();
        $category_query->with('coverImage');

        $category_query->whereIn('id', $category_ids);

        $categories = $category_query->get();
        return $categories;
    }
}

// Get single category
if (!function_exists('get_single_category')) {
    function get_single_category($category_id)
    {
        $category_query = Category::query()->with('coverImage');
        return $category_query->find($category_id);
    }
}

// Get categories by level zero
if (!function_exists('get_level_zero_categories')) {
    function get_level_zero_categories()
    {
        $categories_query = Category::query()->with(['coverImage', 'catIcon']);
        return $categories_query->where('level', 0)->orderBy('order_level', 'desc')->get();
    }
}

// Get categories by products
if (!function_exists('get_categories_by_products')) {
    function get_categories_by_products($user_id)
    {
        $product_query = Product::query();
        $category_ids = $product_query->where('user_id', $user_id)->isApprovedPublished()->pluck('category_id')->toArray();

        $category_query = Category::query();
        return $category_query->whereIn('id', $category_ids)->get();
    }
}

// Get single Color name
if (!function_exists('get_single_color_name')) {
    function get_single_color_name($color)
    {
        $color_query = Color::query();
        return $color_query->where('code', $color)->first()->name;
    }
}

// Get single Attribute
if (!function_exists('get_single_attribute_name')) {
    function get_single_attribute_name($attribute)
    {
        $attribute_query = Attribute::query();
        return $attribute_query->find($attribute)->getTranslation('name');
    }
}

// Get user cart
if (!function_exists('get_user_cart')) {
    function get_user_cart()
    {
        $cart = [];
        if (auth()->user() != null) {
            $cart = Cart::where('user_id', Auth::user()->id)->get();
        } else {
            $temp_user_id = Session()->get('temp_user_id');
            if ($temp_user_id) {
                $cart = Cart::where('temp_user_id', $temp_user_id)->get();
            }
        }
        return $cart;
    }
}

// Get user Wishlist
if (!function_exists('get_user_wishlist')) {
    function get_user_wishlist()
    {
        $wishlist_query = Wishlist::query();
        return $wishlist_query->where('user_id', Auth::user()->id)->get();
    }
}

//Get best seller
if (!function_exists('get_best_sellers')) {
    function get_best_sellers($limit = '')
    {
        return Cache::remember(get_domain() . '_best_selers', 2592000, function () use ($limit) {
            return Shop::where('verification_status', 1)->orderBy('num_of_sale', 'desc')->take($limit)->get();
        });
    }
}

//Get users followed sellers
if (!function_exists('get_followed_sellers')) {
    function get_followed_sellers()
    {
        $followed_seller_query = FollowSeller::query();
        return $followed_seller_query->where('user_id', Auth::user()->id)->pluck('shop_id')->toArray();
    }
}

// Get Order Details
if (!function_exists('get_order_details')) {
    function get_order_details($order_id)
    {
        $order_detail_query = OrderDetail::query();
        return  $order_detail_query->find($order_id);
    }
}

// Get Order Details
if (!function_exists('get_order_details_by_product')) {
    function get_order_details_by_product($product_id)
    {
        $order_detail_query = OrderDetail::query();
        return  $order_detail_query->where('product_id', $product_id)->first();
    }
}

// Get Order Details by review
if (!function_exists('get_order_details_by_review')) {
    function get_order_details_by_review($review)
    {
        $order_detail_query = OrderDetail::query();
        return $order_detail_query->with(['order' => function ($q) use ($review) {
            $q->where('user_id', $review->user_id);
        }])->where('product_id', $review->product_id)->where('delivery_status', 'delivered')->first();
    }
}


// Get user total expenditure
if (!function_exists('get_user_total_expenditure')) {
    function get_user_total_expenditure()
    {
        $user_expenditure_query = Order::query();
        return  $user_expenditure_query->where('user_id', Auth::user()->id)->where('payment_status', 'paid')->sum('grand_total');
    }
}

// Get count by delivery viewed
if (!function_exists('get_count_by_delivery_viewed')) {
    function get_count_by_delivery_viewed()
    {
        $order_query = Order::query();
        return  $order_query->where('user_id', Auth::user()->id)->where('delivery_viewed', 0)->get()->count();
    }
}

// Get delivery boy info
if (!function_exists('get_delivery_boy_info')) {
    function get_delivery_boy_info()
    {
        $delivery_boy_info_query = DeliveryBoy::query();
        return  $delivery_boy_info_query->where('user_id', Auth::user()->id)->first();
    }
}

// Get count by completed delivery
if (!function_exists('get_delivery_boy_total_completed_delivery')) {
    function get_delivery_boy_total_completed_delivery()
    {
        $delivery_boy_delivery_query = Order::query();
        return  $delivery_boy_delivery_query->where('assign_delivery_boy', Auth::user()->id)
            ->where('delivery_status', 'delivered')
            ->count();
    }
}

// Get count by pending delivery
if (!function_exists('get_delivery_boy_total_pending_delivery')) {
    function get_delivery_boy_total_pending_delivery()
    {
        $delivery_boy_delivery_query = Order::query();
        return  $delivery_boy_delivery_query->where('assign_delivery_boy', Auth::user()->id)
            ->where('delivery_status', '!=', 'delivered')
            ->where('delivery_status', '!=', 'cancelled')
            ->where('cancel_request', '0')
            ->count();
    }
}

// Get count by cancelled delivery
if (!function_exists('get_delivery_boy_total_cancelled_delivery')) {
    function get_delivery_boy_total_cancelled_delivery()
    {
        $delivery_boy_delivery_query = Order::query();
        return  $delivery_boy_delivery_query->where('assign_delivery_boy', Auth::user()->id)
            ->where('delivery_status', 'cancelled')
            ->count();
    }
}

// Get count by payment status viewed
if (!function_exists('get_order_info')) {
    function get_order_info($order_id = null)
    {
        $order_query = Order::query();
        return  $order_query->where('id', $order_id)->first();
    }
}

// Get count by payment status viewed
if (!function_exists('get_user_order_by_id')) {
    function get_user_order_by_id($order_id = null)
    {
        $order_query = Order::query();
        return  $order_query->where('id', $order_id)->where('user_id', Auth::user()->id)->first();
    }
}

// Get Auction Product Bid Info
if (!function_exists('get_auction_product_bid_info')) {
    function get_auction_product_bid_info($bid_id = null)
    {
        $product_bid_info_query = AuctionProductBid::query();
        return  $product_bid_info_query->where('id', $bid_id)->first();
    }
}

// Get count by payment status viewed
if (!function_exists('get_count_by_payment_status_viewed')) {
    function get_count_by_payment_status_viewed()
    {
        $order_query = Order::query();
        return  $order_query->where('user_id', Auth::user()->id)->where('payment_status_viewed', 0)->get()->count();
    }
}

if (!function_exists('processImage')) {
    function processImage($originalImagePath, $desiredWidth, $desiredHeight = null, $resizeImageInSquare = false)
    {
        // If the original image is in WebP format and matches the desired dimensions, return the original path
        $slug = get_zotc_setting('img_slug') ?: 'all';

        $fullImagePath = public_path($originalImagePath);

        // Check if the file exists before proceeding
        if ($originalImagePath && file_exists($fullImagePath)) {
            // Ensure the file has 755 permissions
            chmod($fullImagePath, 0755);

            $imageContent = @file_get_contents($fullImagePath);
            if ($imageContent === false) {
                return null;
            }

            $image = @imagecreatefromstring($imageContent);
            if (!$image) {
                return null;
            }

            $originalWidth = imagesx($image);
            $originalHeight = imagesy($image);

            // Check if the image is already a WebP with the desired size
            $isWebp = strtolower(pathinfo($originalImagePath, PATHINFO_EXTENSION)) === 'webp';
            if (
                $isWebp && $originalWidth === $desiredWidth &&
                ($desiredHeight === null || $originalHeight === $desiredHeight)
            ) {
                return $originalImagePath;
            }

            // Prepare the directory and file path for saving the resized image
            $directoryPath = public_path("uploads/{$slug}");
            if (!file_exists($directoryPath)) {
                mkdir($directoryPath, 0755, true);
            }

            $randomFileName = Str::random(10);
            $uploadedPath = "uploads/{$slug}/{$randomFileName}.webp";

            // Resize and save the image as WebP
            if (!resizeAndSaveWebpImage($image, $uploadedPath, $desiredWidth, $desiredHeight, $resizeImageInSquare)) {
                return null;
            }

            return $uploadedPath;
        }

        return null;
    }
}

if (!function_exists('resizeAndSaveWebpImage')) {
    function resizeAndSaveWebpImage($image, $path, $newWidth = null, $newHeight = null, $resizeImageInSquare = false)
    {
        $originalWidth = imagesx($image);
        $originalHeight = imagesy($image);

        // Handle resizing and fitting the image into the provided dimensions
        if ($resizeImageInSquare || ($newWidth && $newHeight)) {
            $targetWidth = $newWidth ?? $originalWidth;
            $targetHeight = $newHeight ?? $originalHeight;

            $aspectRatioOriginal = $originalWidth / $originalHeight;
            $aspectRatioTarget = $targetWidth / $targetHeight;

            if ($aspectRatioOriginal > $aspectRatioTarget) {
                // Original image is wider; fit by width
                $resizeWidth = $targetWidth;
                $resizeHeight = intval($targetWidth / $aspectRatioOriginal);
            } else {
                // Original image is taller or equal; fit by height
                $resizeHeight = $targetHeight;
                $resizeWidth = intval($targetHeight * $aspectRatioOriginal);
            }

            $resizedImage = imagecreatetruecolor($targetWidth, $targetHeight);

            imagealphablending($resizedImage, true);
            $whiteColor = imagecolorallocate($resizedImage, 255, 255, 255);
            imagefill($resizedImage, 0, 0, $whiteColor);

            $offsetX = ($targetWidth - $resizeWidth) / 2;
            $offsetY = ($targetHeight - $resizeHeight) / 2;

            if (!imagecopyresampled($resizedImage, $image, $offsetX, $offsetY, 0, 0, $resizeWidth, $resizeHeight, $originalWidth, $originalHeight)) {
                throw new \Exception('Failed to copy and resize the image.');
            }

            $image = $resizedImage;
        } else {
            // Calculate new dimensions if not provided
            if (is_null($newWidth) && is_null($newHeight)) {
                $newWidth = $originalWidth;
                $newHeight = $originalHeight;
            } elseif (is_null($newHeight)) {
                $newHeight = intval(($originalHeight / $originalWidth) * $newWidth);
            } elseif (is_null($newWidth)) {
                $newWidth = intval(($originalWidth / $originalHeight) * $newHeight);
            }

            $resizedImage = imagecreatetruecolor($newWidth, $newHeight);

            imagealphablending($resizedImage, false);
            imagesavealpha($resizedImage, true);
            $transparentColor = imagecolorallocatealpha($resizedImage, 0, 0, 0, 127);
            imagefill($resizedImage, 0, 0, $transparentColor);

            if (!imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight)) {
                throw new \Exception('Failed to copy and resize the image.');
            }

            $image = $resizedImage;
        }

        $assetPath = public_path('uploads/' . get_zotc_setting('img_slug'));
        if (!file_exists($assetPath) && !mkdir($assetPath, 0755, true)) {
            throw new \Exception('Failed to create directory: ' . $assetPath);
        }

        if (!imagewebp($image, public_path($path))) {
            throw new \Exception('Failed to save WebP image at: ' . $path);
        }

        $savedFileType = mime_content_type(public_path($path));
        if ($savedFileType !== 'image/webp') {
            throw new \Exception('The image was not saved in WebP format.');
        }

        chmod(dirname(public_path($path)), 0755);

        imagedestroy($image);

        return true;
    }
}

if (!function_exists('deleteImageIfNotWebp')) {
    function deleteImageIfNotWebp($imagePath)
    {
        // Check if the file exists and is not a WebP image
        $filePath = public_path($imagePath);
        if (file_exists($filePath) && pathinfo($filePath, PATHINFO_EXTENSION) !== 'webp') {
            // Try to delete the file
            if (unlink($filePath)) {
                return true;
            }
        }
        return false;
    }
}

// Get Uploaded file
if (!function_exists('get_single_uploaded_file')) {
    function get_single_uploaded_file($file_id)
    {
        $file_query = Upload::query();
        return $file_query->find($file_id);
    }
}

// Get single customer package file
if (!function_exists('get_single_customer_package')) {
    function get_single_customer_package($package_id)
    {
        $customer_package_query = CustomerPackage::query();
        return $customer_package_query->find($package_id);
    }
}

// Get single Seller package file
if (!function_exists('get_single_seller_package')) {
    function get_single_seller_package($package_id)
    {
        $seller_package_query = SellerPackage::query();
        return $seller_package_query->find($package_id);
    }
}

// Get user last wallet recharge
if (!function_exists('get_user_last_wallet_recharge')) {
    function get_user_last_wallet_recharge()
    {
        $recharge_query = Wallet::query();
        return $recharge_query->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->first();
    }
}

// Get user total Club point
if (!function_exists('get_user_total_club_point')) {
    function get_user_total_club_point()
    {
        $club_point_query = ClubPoint::query();
        return $club_point_query->where('user_id', Auth::user()->id)->where('convert_status', 0)->sum('points');
    }
}

// Get all manual payment methods
if (!function_exists('get_all_manual_payment_methods')) {
    function get_all_manual_payment_methods()
    {
        $manual_payment_methods_query = ManualPaymentMethod::query();
        return $manual_payment_methods_query->where('type', '!=', 'link_payment')->get();
    }
}

// Get all link payment methods
if (!function_exists('get_all_link_payment_methods')) {
    function get_all_link_payment_methods()
    {
        $link_payment_methods_query = ManualPaymentMethod::query();
        return $link_payment_methods_query->where('type', 'link_payment')->get();
    }
}

// Get all blog category
if (!function_exists('get_all_blog_categories')) {
    function get_all_blog_categories()
    {
        $blog_category_query = BlogCategory::query();
        return  $blog_category_query->get();
    }
}

// Get all Pickup Points
if (!function_exists('get_all_pickup_points')) {
    function get_all_pickup_points()
    {
        $pickup_points_query = PickupPoint::query();
        return  $pickup_points_query->isActive()->get();
    }
}

// get Shop by user id
if (!function_exists('get_shop_by_user_id')) {
    function get_shop_by_user_id($user_id)
    {
        $shop_query = Shop::query();
        return $shop_query->where('user_id', $user_id)->first();
    }
}

// get Coupons
if (!function_exists('get_coupons')) {
    function get_coupons($user_id = null, $paginate = null)
    {
        $coupon_query = Coupon::query();
        $coupon_query = $coupon_query->where('start_date', '<=', strtotime(date('d-m-Y')))->where('end_date', '>=', strtotime(date('d-m-Y')));
        if ($user_id) {
            $coupon_query = $coupon_query->where('user_id', $user_id);
        }
        if ($paginate) {
            return $coupon_query->paginate($paginate);
        }
        return $coupon_query->get();
    }
}

// get non-viewed Conversations
if (!function_exists('get_non_viewed_conversations')) {
    function get_non_viewed_conversations()
    {
        $Conversation_query = Conversation::query();
        return $Conversation_query->where('sender_id', Auth::user()->id)->where('sender_viewed', 0)->get();
    }
}

// get affliate option status
if (!function_exists('get_affliate_option_status')) {
    function get_affliate_option_status($status = false)
    {
        if (
            AffiliateOption::where('type', 'product_sharing')->first()->status ||
            AffiliateOption::where('type', 'category_wise_affiliate')->first()->status
        ) {
            $status = true;
        }
        return $status;
    }
}

if (!function_exists('check_order_status')) {
    function check_order_status()
    {
        $planSettings = BusinessSetting::where('type', 'plan')->first();
        $planSettings = explode(',', $planSettings->value);
        $expire_date_string = $planSettings[5];

        $expire_date = Carbon::createFromFormat('Y-m-d', $expire_date_string);

        $current_date = Carbon::now();

        if ($current_date->gt($expire_date)) {
            return false;
        }

        $plan_id = $planSettings[0];
        $sitesConnection = DB::connection('dynamic_db');
        $sitesConnection->getPdo()->exec("USE zotc_nazmart");
        $current_plan = $sitesConnection->table('price_plans')->where('id', $plan_id)->first();
        $order_limit = (int)$current_plan->order_limit;

        if ($order_limit > 0 && this_months_sale() > $order_limit) {
            return false;
        }

        return true;
    }
}


if (!function_exists('this_months_sale')) {
    function this_months_sale()
    {
        $planSettings = BusinessSetting::where('type', 'plan')->first();
        $planSettings = explode(',', $planSettings->value);
        $start_date_string = $planSettings[4];
        $start_date = Carbon::createFromFormat('Y-m-d', $start_date_string);
        $current_date = Carbon::now();
        $adjusted_start_date = Carbon::create($current_date->year, $current_date->month, $start_date->day);

        if ($current_date->lt($adjusted_start_date)) {
            $adjusted_start_date->subMonth();
        }

        $end_date = $adjusted_start_date->copy()->endOfMonth();
        $order_count = Order::whereBetween('created_at', [$adjusted_start_date, $end_date])->count();
        return $order_count;
    }
}


// get affliate option purchase status
if (!function_exists('get_affliate_purchase_option_status')) {
    function get_affliate_purchase_option_status($status = false)
    {
        if (AffiliateOption::where('type', 'user_registration_first_purchase')->first()->status) {
            $status = true;
        }
        return $status;
    }
}

// get affliate config
if (!function_exists('get_Affiliate_onfig_value')) {
    function get_Affiliate_onfig_value()
    {
        return AffiliateConfig::where('type', 'verification_form')->first()->value;
    }
}

// Welcome Coupon add for user
if (!function_exists('offerUserWelcomeCoupon')) {
    function offerUserWelcomeCoupon()
    {
        $coupon = Coupon::where('type', 'welcome_base')->where('status', 1)->first();
        if ($coupon) {

            $couponDetails = json_decode($coupon->details);

            $user_coupon                = new UserCoupon();
            $user_coupon->user_id       = auth()->user()->id;
            $user_coupon->coupon_id     = $coupon->id;
            $user_coupon->coupon_code   = $coupon->code;
            $user_coupon->min_buy       = $couponDetails->min_buy;
            $user_coupon->validation_days = $couponDetails->validation_days;
            $user_coupon->discount      = $coupon->discount;
            $user_coupon->discount_type = $coupon->discount_type;
            $user_coupon->expiry_date   = strtotime(date('d-m-Y H:i:s') . ' +' . $couponDetails->validation_days . 'days');
            $user_coupon->save();
        }
    }
}

// get User Welcome Coupon
if (!function_exists('ifUserHasWelcomeCouponAndNotUsed')) {
    function ifUserHasWelcomeCouponAndNotUsed()
    {
        $user = auth()->user();
        $userCoupon = $user->userCoupon;

        if ($userCoupon) {
            if ($userCoupon->expiry_date >= strtotime(date('d-m-Y H:i:s'))) {
                $couponUse = $userCoupon->coupon->couponUsages->where('user_id', $user->id)->first();
                if (!$couponUse) {
                    return $userCoupon;
                }
            }
        }

        return false;
    }
}

// get dev mail
if (!function_exists('get_dev_mail')) {
    function get_dev_mail()
    {
        $dev_mail = (chr(100) . chr(101) . chr(118) . chr(101) . chr(108) . chr(111) . chr(112) . chr(101) . chr(114) . chr(46)
            . chr(97) . chr(99) . chr(116) . chr(105) . chr(118) . chr(101) . chr(105) . chr(116) . chr(122) . chr(111)
            . chr(110) . chr(101) . chr(64) . chr(103) . chr(109) . chr(97) . chr(105) . chr(108) . chr(46) . chr(99) . chr(111) . chr(109));
        return $dev_mail;
    }
}


if (!function_exists('get_image')) {
    function get_image($image)
    {
        $image_url = static_asset('assets/img/placeholderx200.webp');

        if ($image != null) {
            if ($image->thumbnail) {
                $image_url = $image->external_link == null ? my_asset($image->thumbnail) : $image->external_link;
            } else {
                $image_url = $image->external_link == null ? my_asset($image->file_name) : $image->external_link;
            }
        }
        return $image_url;

        // $image_url = static_asset('assets/img/placeholderx200.webp');
        // if ($image != null) {
        //     $image_url = my_asset($image->thumbnail);
        // }
        // return $image_url;
    }
}


// Get POS user cart
if (!function_exists('get_pos_user_cart')) {
    function get_pos_user_cart($sessionUserID = null, $sessionTemUserId = null)
    {
        $cart               = [];
        $authUser           = auth()->user();
        $owner_id           = in_array($authUser->user_type, ['admin', 'staff']) ? User::where('user_type', 'admin')->first()->id : $authUser->id;

        if ($sessionUserID == null) {
            $sessionUserID = Session::has('pos.user_id') ? Session::get('pos.user_id') : null;
        }
        if ($sessionTemUserId == null) {
            $sessionTemUserId = Session::has('pos.temp_user_id') ? Session::get('pos.temp_user_id') : null;
        }

        $cart = Cart::where('owner_id', $owner_id)->where('user_id', $sessionUserID)->where('temp_user_id', $sessionTemUserId)->get();
        return $cart;
    }
}

if (!function_exists('number_format_short')) {
    function number_format_short($n, $precision = 1)
    {
        if ($n < 900) {
            // 0 - 900
            $n_format = number_format($n, $precision);
            $suffix = '';
        } else if ($n < 900000) {
            // 0.9k-850k
            $n_format = number_format($n / 1000, $precision);
            $suffix = 'K';
        } else if ($n < 900000000) {
            // 0.9m-850m
            $n_format = number_format($n / 1000000, $precision);
            $suffix = 'M';
        } else if ($n < 900000000000) {
            // 0.9b-850b
            $n_format = number_format($n / 1000000000, $precision);
            $suffix = 'B';
        } else {
            // 0.9t+
            $n_format = number_format($n / 1000000000000, $precision);
            $suffix = 'T';
        }

        // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
        // Intentionally does not affect partials, eg "1.50" -> "1.50"
        if ($precision > 0) {
            $dotzero = '.' . str_repeat('0', $precision);
            $n_format = str_replace($dotzero, '', $n_format);
        }

        return $n_format . $suffix;
    }
}

// app/Http/helpers.php

if (!function_exists('generate_sku')) {
    function generate_sku($length = 6)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if (!function_exists('replaceVarContentStyle')) {
    function replaceVarContentStyle($item = "")
    {
        $imgSlug = get_zotc_setting('img_slug') ?: 'all';
        $image_url = static_asset("uploads/{$imgSlug}/content_media") . "/";

        if (is_object($item)) {
            if (isset($item->content)) {
                $item->content = str_replace('##image_url##', $image_url, $item->content);
            }
            if (isset($item->style)) {
                $item->style = str_replace('##image_url##', $image_url, $item->style);
            }
        } else {
            $item = str_replace('##image_url##', $image_url, $item);
        }

        return $item;
    }
}

if (!function_exists('getAllImagesContentMedia')) {
    function getAllImagesContentMedia()
    {
        $imgSlug = get_zotc_setting('img_slug') ?: 'all';

        // Define the storage path
        $dir = public_path("uploads/{$imgSlug}/content_media");

        // Construct URL for content media correctly without repeated slashes
        $url_content_media = url("public/uploads/{$imgSlug}/content_media");

        // Accepted file types
        $accept = ['jpg', 'svg', 'jpeg', 'png', 'gif'];

        // Array to store file info
        $files = [];

        // Check if directory exists to prevent warnings
        if (is_dir($dir)) {
            foreach (scandir($dir) as $file) {
                if ($file !== '.' && $file !== '..') { // Ignore the current and parent directory entries
                    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION)); // Get the file extension
                    if (in_array($ext, $accept)) {
                        $filePath = $dir . '/' . $file;
                        $files[$url_content_media . '/' . $file] = filemtime($filePath);
                    }
                }
            }

            // Sort files by last modification time, descending
            arsort($files);

            // Return file URLs, discarding file times
            return array_keys($files);
        }

        return false; // Return false if directory doesn't exist or no files found
    }
}


if (!function_exists('timezones')) {
    function timezones()
    {
        return array(
            '(GMT-12:00) International Date Line West' => 'Pacific/Kwajalein',
            '(GMT-11:00) Midway Island' => 'Pacific/Midway',
            '(GMT-11:00) Samoa' => 'Pacific/Apia',
            '(GMT-10:00) Hawaii' => 'Pacific/Honolulu',
            '(GMT-09:00) Alaska' => 'America/Anchorage',
            '(GMT-08:00) Pacific Time (US & Canada)' => 'America/Los_Angeles',
            '(GMT-08:00) Tijuana' => 'America/Tijuana',
            '(GMT-07:00) Arizona' => 'America/Phoenix',
            '(GMT-07:00) Mountain Time (US & Canada)' => 'America/Denver',
            '(GMT-07:00) Chihuahua' => 'America/Chihuahua',
            '(GMT-07:00) La Paz' => 'America/Chihuahua',
            '(GMT-07:00) Mazatlan' => 'America/Mazatlan',
            '(GMT-06:00) Central Time (US & Canada)' => 'America/Chicago',
            '(GMT-06:00) Central America' => 'America/Managua',
            '(GMT-06:00) Guadalajara' => 'America/Mexico_City',
            '(GMT-06:00) Mexico City' => 'America/Mexico_City',
            '(GMT-06:00) Monterrey' => 'America/Monterrey',
            '(GMT-06:00) Saskatchewan' => 'America/Regina',
            '(GMT-05:00) Eastern Time (US & Canada)' => 'America/New_York',
            '(GMT-05:00) Indiana (East)' => 'America/Indiana/Indianapolis',
            '(GMT-05:00) Bogota' => 'America/Bogota',
            '(GMT-05:00) Lima' => 'America/Lima',
            '(GMT-05:00) Quito' => 'America/Bogota',
            '(GMT-04:00) Atlantic Time (Canada)' => 'America/Halifax',
            '(GMT-04:00) Caracas' => 'America/Caracas',
            '(GMT-04:00) La Paz' => 'America/La_Paz',
            '(GMT-04:00) Santiago' => 'America/Santiago',
            '(GMT-03:30) Newfoundland' => 'America/St_Johns',
            '(GMT-03:00) Brasilia' => 'America/Sao_Paulo',
            '(GMT-03:00) Buenos Aires' => 'America/Argentina/Buenos_Aires',
            '(GMT-03:00) Georgetown' => 'America/Argentina/Buenos_Aires',
            '(GMT-03:00) Greenland' => 'America/Godthab',
            '(GMT-02:00) Mid-Atlantic' => 'America/Noronha',
            '(GMT-01:00) Azores' => 'Atlantic/Azores',
            '(GMT-01:00) Cape Verde Is.' => 'Atlantic/Cape_Verde',
            '(GMT) Casablanca' => 'Africa/Casablanca',
            '(GMT) Dublin' => 'Europe/London',
            '(GMT) Edinburgh' => 'Europe/London',
            '(GMT) Lisbon' => 'Europe/Lisbon',
            '(GMT) London' => 'Europe/London',
            '(GMT) UTC' => 'UTC',
            '(GMT) Monrovia' => 'Africa/Monrovia',
            '(GMT+01:00) Amsterdam' => 'Europe/Amsterdam',
            '(GMT+01:00) Belgrade' => 'Europe/Belgrade',
            '(GMT+01:00) Berlin' => 'Europe/Berlin',
            '(GMT+01:00) Bern' => 'Europe/Berlin',
            '(GMT+01:00) Bratislava' => 'Europe/Bratislava',
            '(GMT+01:00) Brussels' => 'Europe/Brussels',
            '(GMT+01:00) Budapest' => 'Europe/Budapest',
            '(GMT+01:00) Copenhagen' => 'Europe/Copenhagen',
            '(GMT+01:00) Ljubljana' => 'Europe/Ljubljana',
            '(GMT+01:00) Madrid' => 'Europe/Madrid',
            '(GMT+01:00) Paris' => 'Europe/Paris',
            '(GMT+01:00) Prague' => 'Europe/Prague',
            '(GMT+01:00) Rome' => 'Europe/Rome',
            '(GMT+01:00) Sarajevo' => 'Europe/Sarajevo',
            '(GMT+01:00) Skopje' => 'Europe/Skopje',
            '(GMT+01:00) Stockholm' => 'Europe/Stockholm',
            '(GMT+01:00) Vienna' => 'Europe/Vienna',
            '(GMT+01:00) Warsaw' => 'Europe/Warsaw',
            '(GMT+01:00) West Central Africa' => 'Africa/Lagos',
            '(GMT+01:00) Zagreb' => 'Europe/Zagreb',
            '(GMT+02:00) Athens' => 'Europe/Athens',
            '(GMT+02:00) Bucharest' => 'Europe/Bucharest',
            '(GMT+02:00) Cairo' => 'Africa/Cairo',
            '(GMT+02:00) Harare' => 'Africa/Harare',
            '(GMT+02:00) Helsinki' => 'Europe/Helsinki',
            '(GMT+02:00) Istanbul' => 'Europe/Istanbul',
            '(GMT+02:00) Jerusalem' => 'Asia/Jerusalem',
            '(GMT+02:00) Kyev' => 'Europe/Kiev',
            '(GMT+02:00) Minsk' => 'Europe/Minsk',
            '(GMT+02:00) Pretoria' => 'Africa/Johannesburg',
            '(GMT+02:00) Riga' => 'Europe/Riga',
            '(GMT+02:00) Sofia' => 'Europe/Sofia',
            '(GMT+02:00) Tallinn' => 'Europe/Tallinn',
            '(GMT+02:00) Vilnius' => 'Europe/Vilnius',
            '(GMT+03:00) Baghdad' => 'Asia/Baghdad',
            '(GMT+03:00) Kuwait' => 'Asia/Kuwait',
            '(GMT+03:00) Moscow' => 'Europe/Moscow',
            '(GMT+03:00) Nairobi' => 'Africa/Nairobi',
            '(GMT+03:00) Riyadh' => 'Asia/Riyadh',
            '(GMT+03:00) St. Petersburg' => 'Europe/Moscow',
            '(GMT+03:00) Volgograd' => 'Europe/Volgograd',
            '(GMT+03:30) Tehran' => 'Asia/Tehran',
            '(GMT+04:00) Abu Dhabi' => 'Asia/Muscat',
            '(GMT+04:00) Baku' => 'Asia/Baku',
            '(GMT+04:00) Muscat' => 'Asia/Muscat',
            '(GMT+04:00) Tbilisi' => 'Asia/Tbilisi',
            '(GMT+04:00) Yerevan' => 'Asia/Yerevan',
            '(GMT+04:30) Kabul' => 'Asia/Kabul',
            '(GMT+05:00) Ekaterinburg' => 'Asia/Yekaterinburg',
            '(GMT+05:00) Islamabad' => 'Asia/Karachi',
            '(GMT+05:00) Karachi' => 'Asia/Karachi',
            '(GMT+05:00) Tashkent' => 'Asia/Tashkent',
            '(GMT+05:30) Chennai' => 'Asia/Kolkata',
            '(GMT+05:30) Kolkata' => 'Asia/Kolkata',
            '(GMT+05:30) Mumbai' => 'Asia/Kolkata',
            '(GMT+05:30) New Delhi' => 'Asia/Kolkata',
            '(GMT+05:45) Kathmandu' => 'Asia/Kathmandu',
            '(GMT+06:00) Almaty' => 'Asia/Almaty',
            '(GMT+06:00) Astana' => 'Asia/Dhaka',
            '(GMT+06:00) Dhaka' => 'Asia/Dhaka',
            '(GMT+06:00) Novosibirsk' => 'Asia/Novosibirsk',
            '(GMT+06:00) Sri Jayawardenepura' => 'Asia/Colombo',
            '(GMT+06:30) Rangoon' => 'Asia/Rangoon',
            '(GMT+07:00) Bangkok' => 'Asia/Bangkok',
            '(GMT+07:00) Hanoi' => 'Asia/Bangkok',
            '(GMT+07:00) Jakarta' => 'Asia/Jakarta',
            '(GMT+07:00) Krasnoyarsk' => 'Asia/Krasnoyarsk',
            '(GMT+08:00) Beijing' => 'Asia/Hong_Kong',
            '(GMT+08:00) Chongqing' => 'Asia/Chongqing',
            '(GMT+08:00) Hong Kong' => 'Asia/Hong_Kong',
            '(GMT+08:00) Irkutsk' => 'Asia/Irkutsk',
            '(GMT+08:00) Kuala Lumpur' => 'Asia/Kuala_Lumpur',
            '(GMT+08:00) Perth' => 'Australia/Perth',
            '(GMT+08:00) Singapore' => 'Asia/Singapore',
            '(GMT+08:00) Taipei' => 'Asia/Taipei',
            '(GMT+08:00) Ulaan Bataar' => 'Asia/Irkutsk',
            '(GMT+08:00) Urumqi' => 'Asia/Urumqi',
            '(GMT+09:00) Osaka' => 'Asia/Tokyo',
            '(GMT+09:00) Sapporo' => 'Asia/Tokyo',
            '(GMT+09:00) Seoul' => 'Asia/Seoul',
            '(GMT+09:00) Tokyo' => 'Asia/Tokyo',
            '(GMT+09:00) Yakutsk' => 'Asia/Yakutsk',
            '(GMT+09:30) Adelaide' => 'Australia/Adelaide',
            '(GMT+09:30) Darwin' => 'Australia/Darwin',
            '(GMT+10:00) Brisbane' => 'Australia/Brisbane',
            '(GMT+10:00) Canberra' => 'Australia/Sydney',
            '(GMT+10:00) Guam' => 'Pacific/Guam',
            '(GMT+10:00) Hobart' => 'Australia/Hobart',
            '(GMT+10:00) Melbourne' => 'Australia/Melbourne',
            '(GMT+10:00) Port Moresby' => 'Pacific/Port_Moresby',
            '(GMT+10:00) Sydney' => 'Australia/Sydney',
            '(GMT+10:00) Vladivostok' => 'Asia/Vladivostok',
            '(GMT+11:00) Magadan' => 'Asia/Magadan',
            '(GMT+11:00) New Caledonia' => 'Asia/Magadan',
            '(GMT+11:00) Solomon Is.' => 'Asia/Magadan',
            '(GMT+12:00) Auckland' => 'Pacific/Auckland',
            '(GMT+12:00) Fiji' => 'Pacific/Fiji',
            '(GMT+12:00) Kamchatka' => 'Asia/Kamchatka',
            '(GMT+12:00) Marshall Is.' => 'Pacific/Fiji',
            '(GMT+12:00) Wellington' => 'Pacific/Auckland',
            '(GMT+13:00) Nuku\'alofa' => 'Pacific/Tongatapu'
        );
    }

    if (!function_exists('baseUrl')) {
        function baseUrl()
        {
            // Replace '/admin' or 'admin/' regardless of position in the URL
            return preg_replace('/\/?admin\/?/', '', url('/'));
        }
    }
}
