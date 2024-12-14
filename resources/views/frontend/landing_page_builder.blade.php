<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>{{ $page->seo_title }}</title>
    <meta name="description" content="{{ $page->seo_description }}">
    <meta name="keywords" content="{{ $page->seo_keywords }}">
    <!-- Apple Stuff -->
    {{-- <link rel="apple-touch-icon" href="{{ url('public/modules/zillapage/assets/images/uploads/' . $page->favicon) }}"> --}}
    {{-- <meta name="apple-mobile-web-app-capable" content="yes"> --}}
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Title">
    <!-- Google / Search Engine Tags -->
    <meta itemprop="name" content="{{ $page->seo_title }}">
    <meta itemprop="description" content="{{ $page->seo_description }}">
    {{-- <meta itemprop="image" content="{{ url('public/modules/zillapage/assets/images/uploads/' . $page->social_image) }}"> --}}

    <!-- Facebook Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $page->social_title }}">
    <meta property="og:description" content="{{ $page->social_description }}">
    {{-- <meta property="og:image"
        content="{{ url('public/modules/zillapage/assets/images/uploads/' . $page->social_image) }}"> --}}
    <meta property="og:url" content="{{ url($page->code) }}">

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $page->social_title }}">
    <meta name="twitter:description" content="{{ $page->social_description }}">
    {{-- <meta name="twitter:image"
        content="{{ url('public/modules/zillapage/assets/images/uploads/' . $page->social_image) }}"> --}}
    {{-- <link rel="icon" href="{{ url('public/modules/zillapage/assets/images/uploads/' . $page->favicon) }}"
        type="image/png"> --}}
    <!-- MS Tile - for Microsoft apps-->
    {{-- <meta name="msapplication-TileImage"
        content="{{ url('public/modules/zillapage/assets/images/uploads/' . $page->favicon) }}"> --}}

    <link rel="stylesheet" href="{{ url('public/modules/zillapage/assets/landingpage/css/template.css') }}">
    <link rel="stylesheet" href="{{ url('public/modules/zillapage/assets/landingpage/css/custom-publish.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    {{-- <style>
        {!! $page->css !!}
    </style> --}}
</head>

<body class="">
    {{-- {!! $page->html !!} --}}
    <div id="loadingMessage">
        <div class="lds-ring">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    
    <script>
        window._formLink = "{{ url('formsubmission') }}";
        window._loadPageLink = "{{ route('landing-pages.builder.getpagejson') }}";

        var csrfName = '{{ csrf_token() }}',
            csrfHash = '{{ csrf_token() }}', // Laravel uses the same CSRF token, no need for separate name/hash
            codePage = '{{ $page->code }}';

        var blockscss = "{{ route('landing-pages.builder.getblockscss') }}";
    </script>

    <script src="{{ url('public/modules/zillapage/assets/landingpage/js/publish.js') }}"></script>
    <script src="{{ url('public/modules/zillapage/assets/landingpage/js/main-page.js') }}"></script>
</body>

<script>
    $(document).ready(function() {
        var order_elements = '';
        var getLandingPageProductsUrl =
            "{{ route('landing-pages.builder.get_landing_page_products', ['slug' => $page->code]) }}";

        $.ajax({
            url: getLandingPageProductsUrl,
            type: 'GET', // GET request
            success: function(response) {
                // Append the generated content to the order section
                $('#order-section').html(response);
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error('Error: ' + error);
                console.error('Status: ' + status);
                console.error('Response: ' + xhr.responseText);
            }
        });
    });
</script>

</html>

{{-- @php
    $htmlContentPath = public_path('uploads/' . $folder . '/html/' . $landingPage->page_body);
    if (file_exists($htmlContentPath)) {
        echo file_get_contents($htmlContentPath);
    }
@endphp --}}

{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF8">
    <title>{{ $landingPage->title }}</title>
    <!-- Link to the external CSS file -->
    <link rel="stylesheet"
        href="{{ asset('public/landing-pages/' . get_domain() . '/css/' . $landingPage->page_header) }}">
</head>

<!-- Load the external HTML file content -->
@php
    $htmlContentPath = public_path('landing-pages/' . get_domain() . '/html/' . $landingPage->page_body);
    if (file_exists($htmlContentPath)) {
        echo file_get_contents($htmlContentPath);
    }
@endphp

</html> --}}
