@php
    $url = request()->getSchemeAndHttpHost();
    $current_url = url()->current();
    $parsedUrl = parse_url($url);
    $domainParts = explode('.', $parsedUrl['host']);
    $domain =
        $domainParts[count($domainParts) - 3] .
        '.' .
        $domainParts[count($domainParts) - 2] .
        '.' .
        $domainParts[count($domainParts) - 1];

    $header_logo = get_setting('header_logo');
@endphp

<!DOCTYPE html>
<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <meta charSet="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Zo.Tc Preview</title>
    <meta name="description" content="Generated by create next app" />
    <!-- Favicon -->
    <link rel="icon" href="{{ uploaded_asset(get_setting('site_icon')) }}">
    <meta name="next-head-count" content="5" />
    <link rel="stylesheet" href="{{ url('public/landing-pages/_next/static/css/25e2d5e4d00fc798.css') }}"
        data-n-g="" />
    <link rel="stylesheet" href="{{ url('public/landing-pages/_next/static/css/ca4c489551ebb70f.css') }}"
        data-n-p="" />
    <link rel="stylesheet" href="{{ url('public/landing-pages/_next/static/css/1cc0e42c1ad40ec0.css') }}"
        data-n-p="" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <div id="__next">
        <div class="Landing__2">
            <div class="ProbashiPackage StudentPackage SariPackage">
                <section class="Logo">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <section id="Menubar">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div id="MenubarContent" class="menubar_MenubarContent__zOkMY">
                                                    <div id="LogoLeft" class="menubar_LogoLeft__BBcWc">

                                                        @if ($header_logo != null)
                                                            <img loading="lazy" width="250" height="50"
                                                                decoding="async" data-nimg="1"
                                                                style="color:transparent"
                                                                src="{{ uploaded_asset($header_logo) }}" />
                                                        @else
                                                            <img loading="lazy" width="250" height="50"
                                                                decoding="async" data-nimg="1"
                                                                style="color:transparent"
                                                                src="{{ static_asset('assets/img/logo.png') }}" />
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="Banner">
                    <div class="BannerOverlay">
                        <img src="{{ url('public/landing-pages/images/landing-2/banner_bg.png') }}" alt="" />
                    </div>
                    <div class="BannerContent">
                        <div class="container">
                            <div class="d_flex row">
                                <div class="col-lg-6">
                                    <div class="BannerText">
                                        <h2>ভালোবাসার মানুষের জন্য <br /> প্রবাসে থেকেও পাঠাতে পারেন </h2>
                                        <h1>{{ $landingPage->product->name }} !</h1>
                                        <h3>প্যাকেজ মূল্যঃ {{ $landingPage->product->unit_price }} টাকা</h3>
                                        <div class="OrderNow d_flex">
                                            <div class="CallForOrder"><a href="{{ $current_url }}#order">অর্ডার
                                                    করুন</a></div>
                                            <div class="BannerNumber"><a
                                                    href="tel:{{ get_setting('contact_phone') }}">{{ get_setting('contact_phone') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="section_gaps"></div>
                <section class="ProbashiImgSlider">
                    <div class="container">
                        <div class="justify-content-md-center row">
                            <div class="col-lg-10">
                                <div class="swiper mySwiper">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div class="ProbashiImgSliderItem"><img
                                                    src="{{ url('public/landing-pages/images/landing-2/ProbashiImgSlider.png') }}"
                                                    alt="" /></div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="ProbashiImgSliderItem"><img
                                                    src="{{ url('public/landing-pages/images/landing-2/ProbashiImgSlider.png') }}"
                                                    alt="" /></div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="ProbashiImgSliderItem"><img
                                                    src="{{ url('public/landing-pages/images/landing-2/ProbashiImgSlider.png') }}"
                                                    alt="" /></div>
                                        </div>
                                    </div>
                                    <div class="swiper-pagination"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="section_gaps"></div>
                <section class="WhatHave">
                    <div class="container">
                        <div class="d_felx row">
                            <div class="col-lg-6">
                                <div class="WhatHaveImg"><img
                                        src="{{ url('public/landing-pages/images/landing-2/whathave.png') }}"
                                        alt="" />
                                    <div class="Overlay">
                                        <h2>মুল্য-{{ $landingPage->product->unit_price }} টাকা</h2>
                                        <h3>সারা দেশে ফ্রি হোম ডেলিভারি</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="WhatHavetext">
                                    <h2>কি কি থাকছে আমাদের এই <br /> প্রবাসী প্যাকেজে ?</h2>
                                    <ul>
                                        <li><img src="{{ url('public/landing-pages/images/landing-2/why_buy1.png') }}"
                                                alt="" />
                                            <div class="text">
                                                <h3>স্পেশাল শাড়ি বক্স</h3>
                                                <p>শাড়ি,চুড়ি,টিপ,গাজরা,আংটি,নাকফুল,চকলেট</p>
                                            </div>
                                        </li>
                                        <li><img src="{{ url('public/landing-pages/images/landing-2/why2.png') }}"
                                                alt="" />
                                            <div class="text">
                                                <h3>স্পেশাল চকলেট বক্স</h3>
                                                <p>১০ টি ডেইরি মিল্ক সিল্ক, ২০ টি ফাইভ স্টার, ১০ টি কিটক্যাট</p>
                                            </div>
                                        </li>
                                        <li><img src="{{ url('public/landing-pages/images/landing-2/why1.png') }}"
                                                alt="" />
                                            <div class="text">
                                                <h3>টেডি বিয়ার</h3>
                                                <p>মিডিয়াম সাইজ টেডি বিয়ার</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="section_gaps"></div>
                <section class="Video">
                    <div class="container">
                        <div class="VideoPlay">
                            <div id="VideoPlayers" class="video_VideoPlayers__KZnPY"></div>
                        </div>
                    </div>
                </section>
                <div class="section_gaps"></div>
                <section class="SariAbout">
                    <div class="container">
                        <div class="d_flex row">
                            <div class="col-lg-6">
                                <div class="SariAboutText">
                                    <h2>ভালোবাসার দিনে প্রিয়জনকে দিন <br /> আমাদের এই বিশেষ উপহার</h2>
                                    <p> কোটি টাকার বাড়ির চেয়েও একটি জামদানিতেই অনেক বেশি খুশি হন বেশিরভাগ নারী।
                                        প্রিয় পোশাকের নাম জানতে চাইলে, সব বাঙালি নারী মূহুর্তেই উত্তর দেবেন ‘শাড়ি’।
                                        প্রতিটি শাড়িই নারীর কাছে অনেক অনেক প্রিয়। তাই তো বেশ কয়েক বছরও যদি পরা না হয়,
                                        তবুও শাড়িটি ফেলে দিতে মন চায় না কারোই। হবেই বা না কেন, প্রতিটি শাড়ির সঙ্গে যে
                                        জড়িয়ে থাকে উপলক্ষ, উৎসব, প্রিয় মানুষের ভালোবাসা, অনেক অনেক স্মৃতি। তাই তো নারীর
                                        এত প্রিয় শাড়ি।</p>
                                    <p>প্রতিটি শাড়ির সঙ্গে যে জড়িয়ে থাকে উপলক্ষ, উৎসব, প্রিয় মানুষের ভালোবাসা, অনেক অনেক
                                        স্মৃতি। তাই তো নারীর এত প্রিয় শাড়ি।</p>
                                    <div class="CallForOrder"><a
                                            href="{{ $current_url }}#order"><span></span><span></span><span></span><span></span>অর্ডার
                                            করুন <i class="flaticon-shopping-cart"></i></a></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="SariAboutSlider">
                                    <div class="BannerSlider">
                                        <div class="swiper mySwiper">
                                            <div class="swiper-wrapper">
                                                <div class="swiper-slide">
                                                    <div class="BannerItem">
                                                        <div class="img"><img
                                                                src="{{ url('public/landing-pages/images/landing-2/about_slider.png') }}"
                                                                alt="" /></div>
                                                    </div>
                                                </div>
                                                <div class="swiper-slide">
                                                    <div class="BannerItem">
                                                        <div class="img"><img
                                                                src="{{ url('public/landing-pages/images/landing-2/about_slider.png') }}"
                                                                alt="" /></div>
                                                    </div>
                                                </div>
                                                <div class="swiper-slide">
                                                    <div class="BannerItem">
                                                        <div class="img"><img
                                                                src="{{ url('public/landing-pages/images/landing-2/about_slider.png') }}"
                                                                alt="" /></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="swiper-pagination"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="section_gaps"></div>
                <section class="CustomerReview">
                    <div class="container">
                        <div id="CustomerReview" class="CustomerReview">
                            <section id="CustomerReviewContent" class="customer-review_CustomerReviewContent__QAt_k">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h2>আমাদের কাস্টমার রিভিউ</h2>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <div id="CustomerReviewImg"
                                                class="customer-review_CustomerReviewImg__1Fuey"><img
                                                    src="{{ url('public/landing-pages/images/customer-review/customer-review1.png') }}"
                                                    alt="" /></div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <div id="CustomerReviewImg"
                                                class="customer-review_CustomerReviewImg__1Fuey"><img
                                                    src="{{ url('public/landing-pages/images/customer-review/customer-review2.png') }}"
                                                    alt="" /></div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <div id="CustomerReviewImg"
                                                class="customer-review_CustomerReviewImg__1Fuey"><img
                                                    src="{{ url('public/landing-pages/images/customer-review/customer-review3.png') }}"
                                                    alt="" /></div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <div id="CustomerReviewImg"
                                                class="customer-review_CustomerReviewImg__1Fuey"><img
                                                    src="{{ url('public/landing-pages/images/customer-review/customer-review1.png') }}"
                                                    alt="" /></div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                    <div class="section_gaps"></div>
                </section>
                <div class="section_gaps"></div>
                <section class="OrderConfirmFrom" id="order">
                    <section id="OrderConfirmFrom" class="order_OrderConfirmFrom__eiWmc">
                        <div class="container">
                            <form action="{{ route('landing-pages.order_landing_page', $landingPage->slug) }}"
                                method="POST">
                                @csrf
                                <div class="row">
                                    <h2>তাই আর দেরি না করে আজই অর্ডার করুন </h2>
                                    <div class="col-lg-7">
                                        <div id="OrderConfirmLeft" class="order_OrderConfirmLeft__HZHqT">
                                            <h3>Billing details</h3>
                                            <div id="CustomeInput" class="order_CustomeInput__k6j_b">
                                                <input type="text" name="name" placeholder="আপনার নাম লিখুন *"
                                                    required />
                                            </div>
                                            <div id="CustomeInput" class="order_CustomeInput__k6j_b">
                                                <input type="text" name="mobile"
                                                    placeholder="আপনার মোবাইল নাম্বার লিখুন *" required />
                                            </div>
                                            <div id="CustomeInput" class="order_CustomeInput__k6j_b">
                                                <input type="text" name="address"
                                                    placeholder="আপনার সম্পূর্ণ ঠিকানা লিখুন *" required />
                                            </div>


                                            <div class="row mt-3" id="payment_div">
                                                <div class="col-12">
                                                    <h3 class="my-2">Payment By</h3>
                                                </div>

                                                @if (get_setting('bkash') == 1)
                                                    <div class="col-6 col-md-4">
                                                        <label class="aiz-megabox d-block mb-3 border rounded">
                                                            <input value="bkash" class="online_payment"
                                                                type="radio" name="payment_option" checked="">
                                                            <span class="d-block aiz-megabox-elem p-3">
                                                                <img src="{{ url('public/assets/img/cards/bkash.png') }}"
                                                                    class="img-fluid mb-2">
                                                                <span class="d-block text-center">
                                                                    <span class="d-block fw-bold fs-15">Bkash</span>
                                                                </span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                @endif
                                                @if (get_setting('nagad') == 1)
                                                    <div class="col-6 col-md-4">
                                                        <label class="aiz-megabox d-block mb-3 border rounded">
                                                            <input value="nagad" class="online_payment"
                                                                type="radio" name="payment_option" checked="">
                                                            <span class="d-block aiz-megabox-elem p-3">
                                                                <img src="{{ url('public/assets/img/cards/nagad.png') }}"
                                                                    class="img-fluid mb-2">
                                                                <span class="d-block text-center">
                                                                    <span class="d-block fw-bold fs-15">Nagad</span>
                                                                </span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                @endif
                                                @if (get_setting('paypal_payment') == 1)
                                                    <div class="col-6 col-md-4">
                                                        <label class="aiz-megabox d-block mb-3 border rounded">
                                                            <input value="paypal" class="online_payment"
                                                                type="radio" name="payment_option" checked="">
                                                            <span class="d-block aiz-megabox-elem p-3">
                                                                <img src="{{ url('public/assets/img/cards/paypal.png') }}"
                                                                    class="img-fluid mb-2">
                                                                <span class="d-block text-center">
                                                                    <span class="d-block fw-bold fs-15">Paypal</span>
                                                                </span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                @endif
                                                @if (get_setting('cash_payment'))
                                                    <div class="col-6 col-md-4">
                                                        <label class="aiz-megabox d-block mb-3 border rounded">
                                                            <input value="cash_on_delivery" class="online_payment"
                                                                type="radio" name="payment_option" checked="">
                                                            <span class="d-block aiz-megabox-elem p-3">
                                                                <img src="{{ url('public/assets/img/cards/cod.png') }}"
                                                                    class="img-fluid mb-2">
                                                                <span class="d-block text-center">
                                                                    <span class="d-block fw-bold fs-15">Cash On
                                                                        Delivery</span>
                                                                </span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <div id="OrderConfirmRight" class="order_OrderConfirmRight__9BH89">
                                            <h3>Your order</h3>
                                            <ul>
                                                <li>
                                                    <h4>Product</h4>
                                                    <h5>Subtotal</h5>
                                                </li>
                                                <li>
                                                    <div id="left" class="order_left__HNlRT order_d_flex__P2VQu">
                                                        <div id="img" class="order_img__nMxcc">
                                                            @if ($landingPage->product->thumbnail)
                                                                <img src="{{ url('public/' . $landingPage->product->thumbnail->file_name) }}"
                                                                    alt="{{ $landingPage->product->name }}" />
                                                            @endif
                                                        </div>
                                                        <p>{{ $landingPage->product->name }}</p>
                                                    </div>
                                                    <div id="right"
                                                        class="order_right__uO4sF order_d_flex__P2VQu">
                                                        <input type="hidden" name="product_id"
                                                            value="{{ $landingPage->product->id }}" />
                                                        <input type="number" id="quantity" name="quantity"
                                                            value="1" required />
                                                        <h5> ৳ {{ $landingPage->product->unit_price }}</h5>
                                                    </div>
                                                </li>
                                                <li>
                                                    <h5>Subtotal</h5>
                                                    <h5>৳ <span
                                                            id="subtotal">{{ $landingPage->product->unit_price }}</span>
                                                    </h5>
                                                </li>
                                                <li>
                                                    <h5>Shipping</h5>
                                                    <h5>
                                                        <div id="checkbox1"
                                                            class="order_checkbox__TScFd order_d_flex__P2VQu">
                                                            <input type="radio" id="Inside" name="shipping"
                                                                value="{{ $landingPage->inside_dhaka }}" checked />
                                                            <label for="Inside">Inside Dhaka : ৳
                                                                {{ $landingPage->inside_dhaka }}</label>
                                                        </div>
                                                        <div id="checkbox2"
                                                            class="order_checkbox__TScFd order_d_flex__P2VQu">
                                                            <input type="radio" id="Outside" name="shipping"
                                                                value="{{ $landingPage->outside_dhaka }}" />
                                                            <label for="Outside">Outside Dhaka: ৳
                                                                {{ $landingPage->outside_dhaka }}</label>
                                                        </div>

                                                    </h5>
                                                </li>
                                                <li>
                                                    <h4>Total</h4>
                                                    <h4>৳ <span
                                                            id="total">{{ $landingPage->product->unit_price }}</span>
                                                    </h4>
                                                </li>
                                            </ul><button> <svg stroke="currentColor" fill="currentColor"
                                                    stroke-width="0" viewBox="0 0 24 24" height="1em"
                                                    width="1em" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M4.00436 6.41662L0.761719 3.17398L2.17593 1.75977L5.41857 5.00241H20.6603C21.2126 5.00241 21.6603 5.45012 21.6603 6.00241C21.6603 6.09973 21.6461 6.19653 21.6182 6.28975L19.2182 14.2898C19.0913 14.7127 18.7019 15.0024 18.2603 15.0024H6.00436V17.0024H17.0044V19.0024H5.00436C4.45207 19.0024 4.00436 18.5547 4.00436 18.0024V6.41662ZM6.00436 7.00241V13.0024H17.5163L19.3163 7.00241H6.00436ZM5.50436 23.0024C4.67593 23.0024 4.00436 22.3308 4.00436 21.5024C4.00436 20.674 4.67593 20.0024 5.50436 20.0024C6.33279 20.0024 7.00436 20.674 7.00436 21.5024C7.00436 22.3308 6.33279 23.0024 5.50436 23.0024ZM17.5044 23.0024C16.6759 23.0024 16.0044 22.3308 16.0044 21.5024C16.0044 20.674 16.6759 20.0024 17.5044 20.0024C18.3328 20.0024 19.0044 20.674 19.0044 21.5024C19.0044 22.3308 18.3328 23.0024 17.5044 23.0024Z">
                                                    </path>
                                                </svg> Place Order BDT
                                                <span id="orderTotal">{{ $landingPage->product->unit_price }}</button>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </section>
                </section>
                <div class="footer4_Footer4__v948q">
                    <section class="footer4_Footer4Sec__Xz0We">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <div class="footer4_FooterMainDiv__uWQWn">
                                        <div class="footer4_FooterMainDiv1__i4BvN"><a href="landing-2.html#">
                                                <h4> <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                                        viewBox="0 0 24 24" height="1em" width="1em"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path fill="none" d="M0 0h24v24H0z"></path>
                                                        <path
                                                            d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 010-5 2.5 2.5 0 010 5z">
                                                        </path>
                                                    </svg> Kuril, Vatara, Dhaka-1229, Bangladesh</h4>
                                            </a></div>
                                        <div class="footer4_FooterMainDiv2__wjIT7"><a href="landing-2.html">
                                                <h4> Privacy Policy</h4>
                                            </a><a href="landing-2.html">
                                                <h4> Terms &amp; Conditions</h4>
                                            </a></div>
                                    </div>
                                    <div id="tinyFooter2" class="footer4_tinyFooter2__F01lH">
                                        <div class="footer4_Hr__iD0vj"></div>
                                        <div>
                                            <p>© {{ date('Y') }} All Rights Reserved Designed by <a
                                                    target="_blank"
                                                    href="{{ $url }}">{{ $domain }}</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <script id="__NEXT_DATA__"
        type="application/json">{"props":{"pageProps":{}},"page":"/landing-2","query":{},"buildId":"8ZCiJa4AZL4bT4qhWltbh","nextExport":true,"autoExport":true,"isFallback":false,"scriptLoader":[]}</script>
    <script>
        $(document).ready(function() {
            function calculateTotal() {
                var quantity = parseInt($('#quantity').val());
                if (quantity < 1) {
                    $('#quantity').val(1);
                    quantity = 1;
                }

                var product_price = parseFloat('{{ $landingPage->product->unit_price }}');

                var subtotal = quantity * product_price;
                $('#subtotal').html(subtotal);

                var shippingCost = parseFloat($('input[name="shipping"]:checked').val());

                var total = subtotal + shippingCost;
                $('#total, #orderTotal').html(total);
            }

            calculateTotal();

            $('#quantity, input[name="shipping"]').change(function() {
                calculateTotal();
            });

            $('#CashOn').change(function() {
                if ($(this).prop('checked')) {
                    $('#payment_div').slideUp();
                } else {
                    $('#payment_div').slideDown();
                }
            });

        });
    </script>
</body>

</html>
