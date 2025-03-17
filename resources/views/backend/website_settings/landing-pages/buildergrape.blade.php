<!doctype html>
<html dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="theme-color" content="#4188c9">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    {{-- favicon --}}
    {{-- <link rel="shortcut icon" type="image/x-icon" href="{{ url('path_to_favicon') }}" /> --}}
    <title>{{ $title }}</title> {{-- Ensure you have an html_escape() equivalent or use the built-in e() function in Laravel --}}

    <link rel="stylesheet" href="{{ url('public/modules/zillapage/assets/landingpage/css/builder.css') }}">
    <link rel="stylesheet" href="{{ url('public/modules/zillapage/assets/landingpage/css/customize.css') }}">
    <script src="{{ url('public/modules/zillapage/assets/landingpage/js/builder.js') }}"></script>

    <script type="text/javascript">
        var exits_ecommerce = false;
        var url_get_products = "";
    </script>
    <script src="{{ url('public/modules/zillapage/assets/landingpage/js/grapeweb.js') }}"></script>

</head>

<body>
    <div id="mobileAlert">
        <div class="message">
            <h3>{{ __('builder_not_work_on_mobile') }}</h3>
            <a href ="{{ route('landing-pages.index') }}">{{ __('back') }}</a>
        </div>
    </div>
    <div id="myModalIcons" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal_close">&times;</span>
                <h3>Font awesome icons 5</h3>
            </div>
            <div class="modal-body">
                <div class="div-search-modal-icon">
                    <input type="text" name="search" id="input-icon-search" class="form-control-builder"
                        placeholder="{{ __('search') }}">
                </div>
                <div id="icons-modal-list">
                    @foreach ($all_icons as $item)
                        <i class="{{ $item }}"></i>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <h3>&nbsp;</h3>
            </div>
        </div>
    </div>

    <input type="text" name="code" value="{{ $page->code }}" hidden class="form-control">

    <div id="loadingMessage">
        <div class="lds-ring">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <div class="btn-page-group">
        <a href="{{ route('landing-pages.index', ['code' => $page->code]) }}" class="btn btn-light"
            id="btn-main-page">{{ $page->name }}</a>
    </div>
    <div id="gjs">
    </div>

    <script type="text/javascript">
        var csrfName = '{{ csrf_token() }}';
        var csrfHash = '';
        var urlStore = '{{ route('landing-pages.builder.update', ['code' => $page->code]) }}';
        var urlLoad = '{{ route('landing-pages.builder.load', ['code' => $page->code]) }}';
        var upload_Image = '{{ route('landing-pages.builder.uploadimage') }}';
        var url_delete_image = '{{ route('landing-pages.builder.deleteimage') }}';
        var url_search_icon = '{{ route('landing-pages.builder.searchicon') }}';
        var url_default_css_template = '{{ url('public/modules/zillapage/assets/landingpage/css/template.css') }}';
        var back_button_url = "{{ route('landing-pages.index') }}";
        var page_url = "{{ route('landing-pages.show_landing_page', ['slug' => $page->code]) }}";
        var blockscss = '{{ route('landing-pages.builder.getblockscss') }}';
        var images_url = JSON.parse(JSON.stringify(
            <?php echo $images_url; ?>));
        var blocks = JSON.parse(JSON.stringify(
            <?php echo $blocks; ?>));
    </script>

    <script src="{{ url('public/modules/zillapage/assets/landingpage/js/customize-builder.js') }}"></script>
</body>

</html>
