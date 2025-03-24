<div class="row">
    <!-- Sytem Settings -->
    <div class="col-lg-6">
        <div class="card shadow-none bg-light">
            <div class="card-header">
                <h1 class="mb-0 h6">{{ translate('Sytem Settings') }}</h1>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="{{ route('business_settings.update') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <!-- Frontend Website Name -->
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{ translate('Website Name') }}</label>
                        <div class="col-md-8">
                            <input type="hidden" name="types[]" value="website_name">
                            <input type="text" name="website_name" class="form-control"
                                placeholder="{{ translate('Website Name') }}"
                                value="{{ get_business_setting('website_name') }}">
                        </div>
                    </div>
                    <!-- Site Motto -->
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{ translate('Site Motto') }}</label>
                        <div class="col-md-8">
                            <input type="hidden" name="types[]" value="site_motto">
                            <input type="text" name="site_motto" class="form-control"
                                placeholder="{{ translate('Best eCommerce Website') }}"
                                value="{{ get_business_setting('site_motto') }}">
                        </div>
                    </div>
                    <!-- Site Icon -->
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{ translate('Site Icon') }}</label>
                        <div class="col-md-8">
                            <div class="input-group " data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary">{{ translate('Browse') }}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="types[]" value="site_icon">
                                <input type="hidden" name="site_icon" value="{{ get_business_setting('site_icon') }}"
                                    class="selected-files">
                            </div>
                            <div class="file-preview box"></div>
                            <small class="text-muted">{{ translate('Website favicon. 32x32 .png') }}</small>
                        </div>
                    </div>
                    <!-- Header Logo -->
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">
                            {{ translate('Header Logo') }} <br>
                            <small>( 250 * 50 )</small>
                        </label>
                        <div class="col-md-8">
                            <div class=" input-group" data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                        {{ translate('Browse') }}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="types[]" value="header_logo">
                                <input type="hidden" name="header_logo" class="selected-files"
                                    value="{{ get_business_setting('header_logo') }}">
                            </div>
                            <div class="file-preview"></div>
                        </div>
                    </div>
                    {{-- <!-- System Timezone -->
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label">{{ translate('System Timezone') }}</label>
                        <div class="col-sm-9">
                            <input type="hidden" name="types[]" value="timezone">
                            <select name="timezone" class="form-control aiz-selectpicker" data-live-search="true">
                                @foreach (timezones() as $key => $value)
                                    <option value="{{ $value }}"
                                        @if (app_timezone() == $value) selected @endif>{{ $key }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}
                    <!-- Update Button -->
                    <div class="mt-4 text-right">
                        <button type="submit"
                            class="btn btn-success w-230px btn-md rounded-2 fs-14 fw-700 shadow-success">{{ translate('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- General Settings -->
    <div class="col-lg-6">
        <div class="card shadow-none bg-light">
            <div class="card-header">
                <h6 class="fw-600 mb-0">{{ translate('General Settings') }}</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('business_settings.update') }}" method="POST">
                    @csrf
                    <!-- Website Base Color -->
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{ translate('Website Base Color') }}</label>
                        <div class="col-md-8">
                            <input type="hidden" name="types[]" value="base_color">
                            <div class="input-group">
                                <input type="text" class="form-control aiz-color-input" placeholder="#000000"
                                    name="base_color" value="{{ get_business_setting('base_color') }}">
                                <div class="input-group-append">
                                    <span class="input-group-text p-0">
                                        <input class="aiz-color-picker border-0 size-30px" type="color"
                                            value="{{ get_business_setting('base_color') }}">
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Website Base Hover Color -->
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{ translate('Website Base Hover Color') }}</label>
                        <div class="col-md-8">
                            <input type="hidden" name="types[]" value="base_hov_color">
                            <div class="input-group">
                                <input type="text" class="form-control aiz-color-input" placeholder="#000000"
                                    name="base_hov_color" value="{{ get_business_setting('base_hov_color') }}">
                                <div class="input-group-append">
                                    <span class="input-group-text p-0">
                                        <input class="aiz-color-picker border-0 size-30px" type="color"
                                            value="{{ get_business_setting('base_hov_color') }}">
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Website Secondary Base Color -->
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{ translate('Website Secondary Base Color') }}</label>
                        <div class="col-md-8">
                            <input type="hidden" name="types[]" value="secondary_base_color">
                            <div class="input-group">
                                <input type="text" class="form-control aiz-color-input" placeholder="#000000"
                                    name="secondary_base_color"
                                    value="{{ get_business_setting('secondary_base_color') }}">
                                <div class="input-group-append">
                                    <span class="input-group-text p-0">
                                        <input class="aiz-color-picker border-0 size-30px" type="color"
                                            value="{{ get_business_setting('secondary_base_color') }}">
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Website Secondary Base Hover Color -->
                    <div class="form-group row">
                        <label
                            class="col-md-3 col-from-label">{{ translate('Website Secondary Base Hover Color') }}</label>
                        <div class="col-md-8">
                            <input type="hidden" name="types[]" value="secondary_base_hov_color">
                            <div class="input-group">
                                <input type="text" class="form-control aiz-color-input" placeholder="#000000"
                                    name="secondary_base_hov_color"
                                    value="{{ get_business_setting('secondary_base_hov_color') }}">
                                <div class="input-group-append">
                                    <span class="input-group-text p-0">
                                        <input class="aiz-color-picker border-0 size-30px" type="color"
                                            value="{{ get_business_setting('secondary_base_hov_color') }}">
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Flash Deal Page Banner - Large -->
                    {{-- <div class="form-group row">
                        <label
                            class="col-md-3 col-from-label">{{ translate('Flash Deal Page Banner - Large') }}</label>
                        <div class="col-md-8">
                            <div class="input-group " data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary">{{ translate('Browse') }}
                                    </div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="types[]" value="flash_deal_banner">
                                <input type="hidden" name="flash_deal_banner"
                                    value="{{ get_business_setting('flash_deal_banner') }}" class="selected-files">
                            </div>
                            <div class="file-preview box"></div>
                            <small>{{ translate('Will be shown in large device') }}</small>
                        </div>
                    </div> --}}
                    <!-- Flash Deal Page Banner - Small -->
                    {{-- <div class="form-group row">
                        <label
                            class="col-md-3 col-from-label">{{ translate('Flash Deal Page Banner - Small') }}</label>
                        <div class="col-md-8">
                            <div class="input-group " data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary">{{ translate('Browse') }}
                                    </div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="types[]" value="flash_deal_banner_small">
                                <input type="hidden" name="flash_deal_banner_small"
                                    value="{{ get_business_setting('flash_deal_banner_small') }}"
                                    class="selected-files">
                            </div>
                            <div class="file-preview box"></div>
                            <small>{{ translate('Will be shown in small device') }}</small>
                        </div>
                    </div> --}}
                    <!-- Update Button -->
                    <div class="mt-4 text-right">
                        <button type="submit"
                            class="btn btn-success w-230px btn-md rounded-2 fs-14 fw-700 shadow-success">{{ translate('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Theme -->
    <div class="col-lg-6">
        <div class="card shadow-none bg-light">
            <div class="card-header">
                <h6 class="fw-600 mb-0">{{ translate('Theme') }}</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('zotc_settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="types[]" value="theme">
                    <div class="row">
                        <!-- Home Classic -->
                        <div class="col-xxl-3 col-lg-4 col-sm-6 my-3">
                            <label class="aiz-megabox d-block mb-3">
                                <input value="classic" type="radio" name="theme"
                                    @if (get_zotc_setting('theme') == null || get_zotc_setting('theme') == 'classic') checked @endif>
                                <span class="d-block aiz-megabox-elem rounded-0 img-overlay">
                                    <div class="h-350px w-100 overflow-hidden">
                                        <img src="{{ static_asset('assets/img/pages/home-classic.png') }}"
                                            class="w-100" alt="home-page">
                                    </div>
                                </span>
                            </label>
                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                <span class="fs-14 fw-500 text-dark">{{ translate('Homepage 1 - Classic') }}</span>
                            </div>
                        </div>

                        <!-- Modern Classic -->
                        <div class="col-xxl-3 col-lg-4 col-sm-6 my-3">
                            <label class="aiz-megabox d-block mb-3">
                                <input value="modern" type="radio" name="theme"
                                    @if (get_zotc_setting('theme') == 'modern') checked @endif>
                                <span class="d-block aiz-megabox-elem rounded-0 img-overlay">
                                    <div class="h-350px w-100 overflow-hidden">
                                        <img src="{{ static_asset('assets/img/pages/home-classic.png') }}"
                                            class="w-100" alt="home-page">
                                    </div>
                                </span>
                            </label>
                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                <span class="fs-14 fw-500 text-dark">{{ translate('Homepage 2 - Modern') }}</span>
                            </div>
                        </div>

                        <!-- Minimal Classic -->
                        <div class="col-xxl-3 col-lg-4 col-sm-6 my-3">
                            <label class="aiz-megabox d-block mb-3">
                                <input value="minimal" type="radio" name="theme"
                                    @if (get_zotc_setting('theme') == 'minimal') checked @endif>
                                <span class="d-block aiz-megabox-elem rounded-0 img-overlay">
                                    <div class="h-350px w-100 overflow-hidden">
                                        <img src="{{ static_asset('assets/img/pages/home-classic.png') }}"
                                            class="w-100" alt="home-page">
                                    </div>
                                </span>
                            </label>
                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                <span class="fs-14 fw-500 text-dark">{{ translate('Homepage 3 - Minimal') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row bg-light mt-5 mb-3">
                        <div class="col-md-12 d-flex align-items-center justify-content-end">
                            <!-- Update Button -->
                            <button type="submit"
                                class="btn btn-success w-230px btn-md rounded-2 fs-14 fw-700 shadow-success">{{ translate('Update') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Product Details -->
        <div class="card shadow-none bg-light">
            <div class="card-header">
                <h6 class="fw-600 mb-0">{{ translate('Product Card Type') }}</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('business_settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="types[]" value="product_card_type">
                    <div class="row">
                        <!-- Card 1 -->
                        <div class="col-xxl-3 col-lg-4 col-sm-6 my-3">
                            <label class="aiz-megabox d-block mb-3">
                                <input value="1" type="radio" name="product_card_type"
                                    @if (get_business_setting('product_card_type') == null || get_business_setting('product_card_type') == '1') checked @endif>
                                <span class="d-block aiz-megabox-elem rounded-0 img-overlay">
                                    <div class="h-220px w-100 overflow-hidden">
                                        <img src="{{ static_asset('assets/img/product_card/1.jpeg') }}"
                                            class="w-100" alt="home-page">
                                    </div>
                                </span>
                            </label>
                            <div class="d-flex flex-wrap justify-content-center align-items-center">
                                <span class="fs-14 fw-500 text-dark">{{ translate('Card 1') }}</span>
                            </div>
                        </div>
                        <!-- Card 2 -->
                        <div class="col-xxl-3 col-lg-4 col-sm-6 my-3">
                            <label class="aiz-megabox d-block mb-3">
                                <input value="2" type="radio" name="product_card_type"
                                    @if (get_business_setting('product_card_type') == '2') checked @endif>
                                <span class="d-block aiz-megabox-elem rounded-0 img-overlay">
                                    <div class="h-220px w-100 overflow-hidden">
                                        <img src="{{ static_asset('assets/img/product_card/2.jpeg') }}"
                                            class="w-100" alt="home-page">
                                    </div>
                                </span>
                            </label>
                            <div class="d-flex flex-wrap justify-content-center align-items-center">
                                <span class="fs-14 fw-500 text-dark">{{ translate('Card 2') }}</span>
                            </div>
                        </div>
                        <!-- Card 3 -->
                        <div class="col-xxl-3 col-lg-4 col-sm-6 my-3">
                            <label class="aiz-megabox d-block mb-3">
                                <input value="3" type="radio" name="product_card_type"
                                    @if (get_business_setting('product_card_type') == '3') checked @endif>
                                <span class="d-block aiz-megabox-elem rounded-0 img-overlay">
                                    <div class="h-220px w-100 overflow-hidden">
                                        <img src="{{ static_asset('assets/img/product_card/3.jpeg') }}"
                                            class="w-100" alt="home-page">
                                    </div>
                                </span>
                            </label>
                            <div class="d-flex flex-wrap justify-content-center align-items-center">
                                <span class="fs-14 fw-500 text-dark">{{ translate('Card 3') }}</span>
                            </div>
                        </div>

                        <!-- Card 4 -->
                        <div class="col-xxl-3 col-lg-4 col-sm-6 my-3">
                            <label class="aiz-megabox d-block mb-3">
                                <input value="4" type="radio" name="product_card_type"
                                    @if (get_business_setting('product_card_type') == null || get_business_setting('product_card_type') == '4') checked @endif>
                                <span class="d-block aiz-megabox-elem rounded-0 img-overlay">
                                    <div class="h-220px w-100 overflow-hidden">
                                        <img src="{{ static_asset('assets/img/product_card/1.jpeg') }}"
                                            class="w-100" alt="home-page">
                                    </div>
                                </span>
                            </label>
                            <div class="d-flex flex-wrap justify-content-center align-items-center">
                                <span class="fs-14 fw-500 text-dark">{{ translate('Card 4') }}</span>
                            </div>
                        </div>
                        <!-- Card 5 -->
                        <div class="col-xxl-3 col-lg-4 col-sm-6 my-3">
                            <label class="aiz-megabox d-block mb-3">
                                <input value="5" type="radio" name="product_card_type"
                                    @if (get_business_setting('product_card_type') == '5') checked @endif>
                                <span class="d-block aiz-megabox-elem rounded-0 img-overlay">
                                    <div class="h-220px w-100 overflow-hidden">
                                        <img src="{{ static_asset('assets/img/product_card/2.jpeg') }}"
                                            class="w-100" alt="home-page">
                                    </div>
                                </span>
                            </label>
                            <div class="d-flex flex-wrap justify-content-center align-items-center">
                                <span class="fs-14 fw-500 text-dark">{{ translate('Card 5') }}</span>
                            </div>
                        </div>
                        <!-- Card 6 -->
                        <div class="col-xxl-3 col-lg-4 col-sm-6 my-3">
                            <label class="aiz-megabox d-block mb-3">
                                <input value="6" type="radio" name="product_card_type"
                                    @if (get_business_setting('product_card_type') == '6') checked @endif>
                                <span class="d-block aiz-megabox-elem rounded-0 img-overlay">
                                    <div class="h-220px w-100 overflow-hidden">
                                        <img src="{{ static_asset('assets/img/product_card/3.jpeg') }}"
                                            class="w-100" alt="home-page">
                                    </div>
                                </span>
                            </label>
                            <div class="d-flex flex-wrap justify-content-center align-items-center">
                                <span class="fs-14 fw-500 text-dark">{{ translate('Card 6') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row bg-light mt-5 mb-3">
                        <div class="col-md-12 d-flex align-items-center justify-content-end">
                            <!-- Update Button -->
                            <button type="submit"
                                class="btn btn-success w-230px btn-md rounded-2 fs-14 fw-700 shadow-success">{{ translate('Update') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <!-- Product Details -->
        <div class="card shadow-none bg-light">
            <div class="card-header">
                <h6 class="fw-600 mb-0">{{ translate('Product Details Columns') }}</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('business_settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{ translate('Product Details Columns') }}</label>
                        <div class="col-md-8">
                            <input type="hidden" name="types[]" value="product_details_columns">
                            <select class="form-control" name="product_details_columns">
                                <option value="3" @if (get_business_setting('product_details_columns') == 3) selected @endif>3
                                </option>
                                <option value="2" @if (get_business_setting('product_details_columns') == 2) selected @endif>2
                                </option>
                            </select>

                        </div>
                    </div>
                    <!-- Update Button -->
                    <div class="mt-4 text-right">
                        <button type="submit"
                            class="btn btn-success w-230px btn-md rounded-2 fs-14 fw-700 shadow-success">{{ translate('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Global SEO -->
        <div class="card shadow-none bg-light">
            <div class="card-header">
                <h6 class="fw-600 mb-0">{{ translate('Global SEO') }}</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('business_settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Meta Title -->
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{ translate('Meta Title') }}</label>
                        <div class="col-md-8">
                            <input type="hidden" name="types[]" value="meta_title">
                            <input type="text" class="form-control" placeholder="{{ translate('Title') }}"
                                name="meta_title" value="{{ get_business_setting('meta_title') }}">
                        </div>
                    </div>
                    <!-- Meta description -->
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{ translate('Meta description') }}</label>
                        <div class="col-md-8">
                            <input type="hidden" name="types[]" value="meta_description">
                            <textarea class="resize-off form-control" placeholder="{{ translate('Description') }}" name="meta_description">{{ get_business_setting('meta_description') }}</textarea>
                        </div>
                    </div>
                    <!-- Keywords -->
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{ translate('Keywords') }}</label>
                        <div class="col-md-8">
                            <input type="hidden" name="types[]" value="meta_keywords">
                            <textarea class="resize-off form-control" placeholder="{{ translate('Keyword, Keyword') }}" name="meta_keywords">{{ get_business_setting('meta_keywords') }}</textarea>
                            <small class="text-muted">{{ translate('Separate with coma') }}</small>
                        </div>
                    </div>
                    <!-- Meta Image -->
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{ translate('Meta Image') }}</label>
                        <div class="col-md-8">
                            <div class="input-group " data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary">{{ translate('Browse') }}
                                    </div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="types[]" value="meta_image">
                                <input type="hidden" name="meta_image"
                                    value="{{ get_business_setting('meta_image') }}" class="selected-files">
                            </div>
                            <div class="file-preview box"></div>
                        </div>
                    </div>
                    <!-- Update Button -->
                    <div class="mt-4 text-right">
                        <button type="submit"
                            class="btn btn-success w-230px btn-md rounded-2 fs-14 fw-700 shadow-success">{{ translate('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    {{-- authenticate layout --}}
    {{-- <div class="col-lg-6">
        @can('authentication_layout_settings')
            <div class="card shadow-none bg-light">
                <div class="card-header">
                    <h6 class="fw-600 mb-0">{{ translate('Authentication Page Layout') }}</h6>
                </div>
                <div class="card-body p-2rem">
                    <form action="{{ route('business_settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="types[]" value="authentication_layout_select">
                        @php $authentication_layout = get_business_setting('authentication_layout_select'); @endphp
                        <div class="row">

                            <!-- Boxed -->
                            <div class="col-xxl-3 col-lg-4 col-sm-6 my-3">
                                <label class="aiz-megabox d-block mb-3">
                                    <input value="boxed" type="radio" name="authentication_layout_select"
                                        @if ($authentication_layout == null || $authentication_layout == 'boxed') checked @endif>
                                    <span class="d-block aiz-megabox-elem rounded-0 img-overlay">
                                        <div class="h-190px w-100 overflow-hidden">
                                            <img src="{{ static_asset('assets/img/authentication_pages/boxed.png') }}"
                                                class="w-100" alt="authentication-page">
                                        </div>
                                    </span>
                                </label>
                                <div class="d-flex flex-wrap justify-content-between align-items-center">
                                    <span
                                        class="fs-14 fw-500 text-dark">{{ translate('Authentication Layout 1 - Boxed') }}</span>
                                    <span>
                                        <a href="javascript:void(0);" class="btn btn-xs btn-danger rounded-0"
                                            onclick="imageShowOverlay('{{ static_asset('assets/img/authentication_pages/boxed.png') }}')">{{ translate('View') }}</a>
                                    </span>
                                </div>
                            </div>

                            <!-- Free 2 -->
                            <div class="col-xxl-3 col-lg-4 col-sm-6 my-3">
                                <label class="aiz-megabox d-block mb-3">
                                    <input value="free" type="radio" name="authentication_layout_select"
                                        @if ($authentication_layout == 'free') checked @endif>
                                    <span class="d-block aiz-megabox-elem rounded-0 img-overlay">
                                        <div class="h-190px w-100 overflow-hidden">
                                            <img src="{{ static_asset('assets/img/authentication_pages/free.png') }}"
                                                class="w-100" alt="authentication-page">
                                        </div>
                                    </span>
                                </label>
                                <div class="d-flex flex-wrap justify-content-between align-items-center">
                                    <span
                                        class="fs-14 fw-500 text-dark">{{ translate('Authentication Layout 2 - Free') }}</span>
                                    <span>
                                        <a href="javascript:void(0);" class="btn btn-xs btn-danger rounded-0"
                                            onclick="imageShowOverlay('{{ static_asset('assets/img/authentication_pages/free.png') }}')">{{ translate('View') }}</a>
                                    </span>
                                </div>
                            </div>

                            <!-- Focused -->
                            <div class="col-xxl-3 col-lg-4 col-sm-6 my-3">
                                <label class="aiz-megabox d-block mb-3">
                                    <input value="focused" type="radio" name="authentication_layout_select"
                                        @if ($authentication_layout == 'focused') checked @endif>
                                    <span class="d-block aiz-megabox-elem rounded-0 img-overlay">
                                        <div class="h-190px w-100 overflow-hidden">
                                            <img src="{{ static_asset('assets/img/authentication_pages/focused.png') }}"
                                                class="w-100" alt="authentication-page">
                                        </div>
                                    </span>
                                </label>
                                <div class="d-flex flex-wrap justify-content-between align-items-center">
                                    <span
                                        class="fs-14 fw-500 text-dark">{{ translate('Authentication Layout 3 - Focused') }}</span>
                                    <span>
                                        <a href="javascript:void(0);" class="btn btn-xs btn-danger rounded-0"
                                            onclick="imageShowOverlay('{{ static_asset('assets/img/authentication_pages/focused.png') }}')">{{ translate('View') }}</a>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Update Button -->
                        <div class="mt-4 text-right">
                            <button type="submit"
                                class="btn btn-success w-230px btn-md rounded-2 fs-14 fw-700 shadow-success">{{ translate('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        @endcan
    </div> --}}

    <!-- Cookies Agreement -->
    {{-- <div class="col-lg-6">
        <div class="card shadow-none bg-light">
            <div class="card-header">
                <h6 class="fw-600 mb-0">{{ translate('Cookies Agreement') }}</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('business_settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Cookies Agreement Text -->
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{ translate('Cookies Agreement Text') }}</label>
                        <div class="col-md-8">
                            <input type="hidden" name="types[]" value="cookies_agreement_text">
                            <textarea name="cookies_agreement_text" rows="4" class="aiz-text-editor form-control"
                                data-buttons='[["font", ["bold"]],["insert", ["link"]]]'>{{ get_business_setting('cookies_agreement_text') }}</textarea>
                        </div>
                    </div>
                    <!-- Show Cookies Agreement -->
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{ translate('Show Cookies Agreement?') }}</label>
                        <div class="col-md-8">
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input type="hidden" name="types[]" value="show_cookies_agreement">
                                <input type="checkbox" name="show_cookies_agreement"
                                    @if (get_business_setting('show_cookies_agreement') == 'on') checked @endif>
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <!-- Update Button -->
                    <div class="mt-4 text-right">
                        <button type="submit"
                            class="btn btn-success w-230px btn-md rounded-2 fs-14 fw-700 shadow-success">{{ translate('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}

    <!-- Website Popup -->
    {{-- <div class="col-lg-6">
        <div class="card shadow-none bg-light">
            <div class="card-header">
                <h6 class="fw-600 mb-0">{{ translate('Website Popup') }}</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('business_settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Show website popup -->
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{ translate('Show website popup?') }}</label>
                        <div class="col-md-8">
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input type="hidden" name="types[]" value="show_website_popup">
                                <input type="checkbox" name="show_website_popup"
                                    @if (get_business_setting('show_website_popup') == 'on') checked @endif>
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <!-- Popup content -->
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{ translate('Popup content') }}</label>
                        <div class="col-md-8">
                            <input type="hidden" name="types[]" value="website_popup_content">
                            <textarea name="website_popup_content" rows="4" class="aiz-text-editor form-control">{{ get_business_setting('website_popup_content') }}</textarea>
                        </div>
                    </div>
                    <!-- Show Subscriber form -->
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{ translate('Show Subscriber form?') }}</label>
                        <div class="col-md-8">
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input type="hidden" name="types[]" value="show_subscribe_form">
                                <input type="checkbox" name="show_subscribe_form"
                                    @if (get_business_setting('show_subscribe_form') == 'on') checked @endif>
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <!-- Update Button -->
                    <div class="mt-4 text-right">
                        <button type="submit"
                            class="btn btn-success w-230px btn-md rounded-2 fs-14 fw-700 shadow-success">{{ translate('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}

    <!-- Product Default Description -->
    <div class="col-lg-6">
        <div class="card shadow-none bg-light">
            <div class="card-header">
                <h6 class="fw-600 mb-0">{{ translate('Product Default Description') }}</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('business_settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Description -->
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{ translate('Description') }}</label>
                        <div class="col-md-8">
                            <input type="hidden" name="types[]" value="product_default_description">
                            <textarea name="product_default_description" rows="4" class="aiz-text-editor form-control">{{ get_business_setting('product_default_description') }}</textarea>
                        </div>
                    </div>
                    <!-- Update Button -->
                    <div class="mt-4 text-right">
                        <button type="submit"
                            class="btn btn-success w-230px btn-md rounded-2 fs-14 fw-700 shadow-success">{{ translate('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Custom Script -->
    <div class="col-lg-6">
        <div class="card d-none">
            <div class="card-header">
                <h6 class="fw-600 mb-0">{{ translate('Custom Script') }}</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('business_settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Header custom script -->
                    <div class="form-group row">
                        <label
                            class="col-md-3 col-from-label">{{ translate('Header custom script - before </head>') }}</label>
                        <div class="col-md-8">
                            <input type="hidden" name="types[]" value="header_script">
                            <textarea name="header_script" rows="4" class="form-control" placeholder="<script>
                                & #10;...&# 10;
                            </script>">{{ get_business_setting('header_script') }}</textarea>
                            <small>{{ translate('Write script with <script> tag') }}</small>
                        </div>
                    </div>
                    <!-- Footer custom script -->
                    <div class="form-group row">
                        <label
                            class="col-md-3 col-from-label">{{ translate('Footer custom script - before </body>') }}</label>
                        <div class="col-md-8">
                            <input type="hidden" name="types[]" value="footer_script">
                            <textarea name="footer_script" rows="4" class="form-control" placeholder="<script>
                                & #10;...&# 10;
                            </script>">{{ get_business_setting('footer_script') }}</textarea>
                            <small>{{ translate('Write script with <script> tag') }}</small>
                        </div>
                    </div>
                    <!-- Update Button -->
                    <div class="mt-4 text-right">
                        <button type="submit"
                            class="btn btn-success w-230px btn-md rounded-2 fs-14 fw-700 shadow-success">{{ translate('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Contact Address -->
    {{-- <div class="card shadow-none bg-light">
                <div class="card-header">
                    <h6 class="fw-600 mb-0">{{ translate('Contact Address') }}</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('business_settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- Description -->
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Description') }}</label>
                            <div class="col-md-8">
                                <input type="hidden" name="types[]" value="contact_address">
                                <textarea name="contact_address" rows="4" class="resize-off form-control">{{ get_business_setting('contact_address') }}</textarea>
                            </div>
                        </div>
                        <!-- Update Button -->
                        <div class="mt-4 text-right">
                            <button type="submit"
                                class="btn btn-success w-230px btn-md rounded-2 fs-14 fw-700 shadow-success">{{ translate('Update') }}</button>
                        </div>
                    </form>
                </div>
    </div> --}}
</div>
