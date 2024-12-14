<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/sslcommerz*',
        '/uddoktapay*',
        '/config_content',
        '/paytm*',
        '/payhere*',
        '/stripe*',
        '/iyzico*',
        '/payfast*',
        '/bkash*',
        'api/v2/bkash*',
        '/aamarpay*',
        '/mock_payments',
        '/lnmo*',
        '/shop/switch',
        '/landing-pages-builder/update',
        '/pathao/status-update',
        '/steadfast/status-update',
        'domainBuyBkashNotify',
        'planExtendNotify',
        'lifetimePlanBuyNotify',
        'planBuyNotify',
        'smsBuyNotify',
        'balanceBuyNotify',
        '/openverse/authenticate',
        'admin/website/landing-pages/builder/update',
        'admin/website/landing-pages/builder/uploadimage',
        'admin/website/landing-pages/builder/deleteimage',
        'admin/website/landing-pages/builder/searchicon',
        'admin/website/landing-pages/builder/setting',
        'builder/getpagejson'
    ];
}