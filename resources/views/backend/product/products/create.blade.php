@extends('backend.layouts.app')

@section('content')

    @php
        CoreComponentRepository::instantiateShopRepository();
        CoreComponentRepository::initializeCache();
    @endphp

    <div class="page-content">
        <div class="aiz-titlebar text-left mt-2 pb-2 px-3 px-md-2rem border-bottom border-gray">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="h3">{{ translate('Add New Product') }}</h1>
                </div>
                {{-- <div class="col text-right">
                <a class="btn has-transition btn-xs p-0 hov-svg-danger" href="{{ route('home') }}" 
                    target="_blank" data-toggle="tooltip" data-placement="top" data-title="{{ translate('View Tutorial Video') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="19.887" height="16" viewBox="0 0 19.887 16">
                        <path id="_42fbab5a39cb8436403668a76e5a774b" data-name="42fbab5a39cb8436403668a76e5a774b" d="M18.723,8H5.5A3.333,3.333,0,0,0,2.17,11.333v9.333A3.333,3.333,0,0,0,5.5,24h13.22a3.333,3.333,0,0,0,3.333-3.333V11.333A3.333,3.333,0,0,0,18.723,8Zm-3.04,8.88-5.47,2.933a1,1,0,0,1-1.473-.88V13.067a1,1,0,0,1,1.473-.88l5.47,2.933a1,1,0,0,1,0,1.76Zm-5.61-3.257L14.5,16l-4.43,2.377Z" transform="translate(-2.17 -8)" fill="#9da3ae"/>
                    </svg>
                </a>
            </div> --}}
            </div>
        </div>

        <div class="d-sm-flex">

            <div class="flex-grow-1 p-sm-3 p-lg-2rem mb-2rem mb-md-0">
                <!-- Error Meassages -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data"
                    enctype="multipart/form-data" id="choice_form">
                    @csrf
                    <!-- General -->
                    <div class="bg-white">
                        <!-- Product Information -->
                        {{-- <h5 class="mb-3 pb-3 fs-17 fw-700" style="border-bottom: 1px dashed #e4e5eb;">
                            {{ translate('Product Information') }}</h5> --}}
                        <div class="row">

                            <div class="col-md-6">
                                <!-- Product Name -->
                                <div class="form-group row">
                                    <label class="col-xxl-3 col-from-label fs-13">{{ translate('Product Name') }}
                                        <span class="text-danger">*</span></label>
                                    <div class="col-xxl-9">
                                        <input type="text" class="form-control" name="name"
                                            value="{{ old('name') }}" placeholder="{{ translate('Product Name') }}"
                                            onchange="update_sku()">
                                    </div>
                                </div>
                                <!-- Brand -->
                                <div class="form-group row" id="brand">
                                    <label class="col-xxl-3 col-from-label fs-13">{{ translate('Brand') }}</label>
                                    <div class="col-xxl-9">
                                        <select class="form-control aiz-selectpicker" name="brand_id" id="brand_id"
                                            data-live-search="true">
                                            <option value="">{{ translate('Select Brand') }}</option>
                                            @foreach (\App\Models\Brand::all() as $brand)
                                                <option value="{{ $brand->id }}" @selected(old('brand_id') == $brand->id)>
                                                    {{ $brand->getTranslation('name') }}</option>
                                            @endforeach
                                        </select>
                                        <small
                                            class="text-muted">{{ translate("You can choose a brand if you'd like to display your product by brand.") }}</small>
                                    </div>
                                </div>

                                <!-- Unit price -->
                                <div class="form-group row">
                                    <label class="col-xxl-3 col-from-label fs-13">{{ translate('Unit price') }}
                                        <span class="text-danger">*</span></label>
                                    <div class="col-xxl-9">
                                        <input type="number" lang="en" min="0" step="0.01"
                                            placeholder="{{ translate('Unit price') }}" value="{{ old('unit_price') }}"
                                            name="unit_price" class="form-control">
                                    </div>
                                </div>

                                <!-- Quantity -->
                                <div class="form-group row">
                                    <label class="col-xxl-3 col-from-label">{{ translate('Quantity') }}
                                        <span class="text-danger">*</span></label>
                                    <div class="col-xxl-6">
                                        <input type="number" lang="en" min="0" value="100" step="1"
                                            placeholder="{{ translate('Quantity') }}" name="current_stock"
                                            class="form-control">
                                    </div>
                                </div>

                                <!-- Product Files & Media -->
                                {{-- <h5 class="mb-3 pb-3 fs-17 fw-700" style="border-bottom: 1px dashed #e4e5eb;">
                                            {{ translate('Product Files & Media') }}</h5> --}}
                                <!-- Gallery Images -->
                                <div class="form-group row">
                                    <label class="col-xxl-3 col-from-label fs-13"
                                        for="signinSrEmail">{{ translate('Gallery Images') }}
                                        <small>(750x750)</small></label>
                                    <div class="col-xxl-9">
                                        <div class="input-group" data-toggle="aizuploader" data-uploadtype="product"
                                            data-type="image" data-multiple="true">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                    {{ translate('Browse') }}</div>
                                            </div>
                                            <div class="form-control file-amount">
                                                {{ translate('Choose File') }}
                                            </div>
                                            <input type="hidden" name="photos" class="selected-files">
                                        </div>
                                        <div class="file-preview box sm">
                                        </div>
                                        <small
                                            class="text-muted">{{ translate('These images are visible in product details page gallery. Use 750x750 sizes images.') }}</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Product Category -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0 h6">{{ translate('Product Category') }}</h5>
                                        <h6 class="float-right fs-13 mb-0">
                                            {{ translate('Select Main') }}
                                            <span class="position-relative main-category-info-icon">
                                                <i class="las la-question-circle fs-18 text-info"></i>
                                                <span
                                                    class="main-category-info bg-soft-info p-2 position-absolute d-none border">{{ translate('This will be used for commission based calculations and homepage category wise product Show.') }}</span>
                                            </span>
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="h-300px overflow-auto c-scrollbar-light">
                                            <ul class="hummingbird-treeview-converter list-unstyled"
                                                data-checkbox-name="category_ids[]" data-radio-name="category_id">
                                                @foreach ($categories as $category)
                                                    <li id="{{ $category->id }}">
                                                        {{ $category->getTranslation('name') }}</li>
                                                    @foreach ($category->childrenCategories as $childCategory)
                                                        @include(
                                                            'backend.product.products.child_category',
                                                            ['child_category' => $childCategory]
                                                        )
                                                    @endforeach
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Description -->
                                <div class="form-group">
                                    <label class="fs-13">{{ translate('Description') }}</label>
                                    <div class="">
                                        <textarea class="aiz-text-editor" name="description">{{ old('description') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Short Description -->
                                <div class="form-group">
                                    <label class="fs-13">{{ translate('Short Description') }}</label>
                                    <div class="">
                                        <textarea class="aiz-text-editor" name="short_description" rows="2">{{ old('short_description') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Save Button -->
                    <div class="my-4">
                        <button type="button" id="advance_button"
                            class="mx-2 btn btn-primary w-230px btn-md rounded-2 fs-14 fw-700 shadow-primary action-btn">{{ translate('Advanced Menu') }}</button>
                    </div>

                    <div id="advance_div" style="display: none">
                        <div class="bg-white">
                            <div class="row">
                                <div class="col-md-6 d-none">
                                    {{-- quick contact --}}
                                    <div class="form-group row">
                                        <label class="col-xxl-3 col-from-label fs-13">{{ translate('Quick Contact') }}
                                        </label>
                                        <div class="col-xxl-9">
                                            <input type="number" class="form-control" name="quick_contact"
                                                value="{{ old('quick_contact') ?? '' }}" placeholder="Contact Number">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <!-- Unit -->
                                    <div class="form-group row">
                                        <label class="col-xxl-3 col-from-label fs-13">{{ translate('Unit') }}
                                            <span class="text-danger">*</span></label>
                                        <div class="col-xxl-9">
                                            <input type="text" class="form-control" name="unit"
                                                value="{{ old('unit') ?? 'pc' }}"
                                                placeholder="{{ translate('Unit (e.g. KG, Pc etc)') }}">
                                        </div>
                                    </div>

                                    <!-- Weight -->
                                    <div class="form-group row">
                                        <label class="col-xxl-3 col-from-label fs-13">{{ translate('Weight') }}
                                            <small>({{ translate('In Kg') }})</small></label>
                                        <div class="col-xxl-9">
                                            <input type="number" class="form-control" name="weight"
                                                value="{{ old('weight') ?? 0.0 }}" step="0.01" placeholder="0.00">
                                        </div>
                                    </div>

                                    <!-- Quantity -->
                                    <div class="form-group row">
                                        <label
                                            class="col-xxl-3 col-from-label fs-13">{{ translate('Minimum Purchase Qty') }}
                                            <span class="text-danger">*</span></label>
                                        <div class="col-xxl-9">
                                            <input type="number" lang="en" class="form-control" name="min_qty"
                                                value="{{ old('min_qty') ?? 1 }}" min="1">
                                            <small
                                                class="text-muted">{{ translate('The minimum quantity needs to be purchased by your customer.') }}</small>
                                        </div>
                                    </div>

                                    <link
                                        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css"
                                        rel="stylesheet">
                                    <style>
                                        .bootstrap-tagsinput {
                                            width: 100%;
                                        }

                                        .bootstrap-tagsinput .tag {
                                            margin-right: 2px;
                                            color: white;
                                            background-color: #007bff;
                                            padding: 5px;
                                            border-radius: 3px;
                                            display: inline-block;
                                        }
                                    </style>

                                    <!-- jQuery -->
                                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                                    <!-- Bootstrap Tags Input JS -->
                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>

                                    <!-- Tags -->
                                    <div class="form-group row">
                                        <label class="col-xxl-3 col-from-label fs-13">{{ translate('Tags') }}
                                            <span class="text-danger">*</span></label>
                                        <div class="col-xxl-9">
                                            <input type="text" class="form-control bootstrap-tagsinput" name="tags"
                                                id="tags" value=""
                                                placeholder="{{ translate('Type to add a tag') }}" data-role="tagsinput">
                                            <small
                                                class="text-muted">{{ translate("Press 'ENTER' or comma to seperate Tags") }}</small>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-xxl-3 col-from-label">{{ translate('purchase_price') }}</label>
                                        <div class="col-xxl-9">
                                            <input type="text" placeholder="{{ translate('purchase_price') }}"
                                                name="purchase_price" class="form-control" value="0">
                                        </div>
                                    </div>

                                    @if (addon_is_activated('pos_system'))
                                        <!-- Barcode -->
                                        <div class="form-group row">
                                            <label
                                                class="col-xxl-3 col-from-label fs-13">{{ translate('Barcode') }}</label>
                                            <div class="col-xxl-9">
                                                <input type="text" class="form-control" name="barcode"
                                                    value="{{ old('barcode') }}"
                                                    placeholder="{{ translate('Barcode') }}">
                                            </div>
                                        </div>
                                    @endif

                                    @if (addon_is_activated('refund_request'))
                                        <!-- refund_request -->
                                        <div class="form-group row mt-4 mb-4">
                                            <label
                                                class="col-xxl-3 col-from-label fs-13">{{ translate('Refundable') }}</label>
                                            <div class="col-xxl-9">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="refundable" checked value="1">
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    <!-- Status -->
                                    {{-- <h5 class="mb-3 pb-3 fs-17 fw-700" style="border-bottom: 1px dashed #e4e5eb;">
                                    {{ translate('Status') }}</h5> --}}
                                    <div class="w-100">
                                        <!-- Featured -->
                                        <div class="form-group row">
                                            <label class="col-md-3 col-from-label">{{ translate('Featured') }}</label>
                                            <div class="col-md-9">
                                                <label class="aiz-switch aiz-switch-success mb-0 d-block">
                                                    <input type="checkbox" name="featured" value="1">
                                                    <span></span>
                                                </label>
                                                <small
                                                    class="text-muted">{{ translate('If you enable this, this product will be granted as a featured product.') }}</small>
                                            </div>
                                        </div>
                                        <!-- Todays Deal -->
                                        <div class="form-group row">
                                            <label class="col-md-3 col-from-label">{{ translate('Todays Deal') }}</label>
                                            <div class="col-md-9">
                                                <label class="aiz-switch aiz-switch-success mb-0 d-block">
                                                    <input type="checkbox" name="todays_deal" value="1">
                                                    <span></span>
                                                </label>
                                                <small
                                                    class="text-muted">{{ translate('If you enable this, this product will be granted as a todays deal product.') }}</small>
                                            </div>
                                        </div>

                                        <!-- Add To Flash -->
                                        <div class="form-group row">
                                            <label class="col-md-3 col-from-label">{{ translate('Add To Flash') }}</label>
                                            <div class="col-xxl-9">
                                                <select class="form-control aiz-selectpicker" name="flash_deal_id"
                                                    id="flash_deal">
                                                    <option value="">{{ translate('Choose Flash Title') }}</option>
                                                    @foreach (\App\Models\FlashDeal::where('status', 1)->get() as $flash_deal)
                                                        <option value="{{ $flash_deal->id }}">
                                                            {{ $flash_deal->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <!-- Discount -->
                                        <div class="form-group row">
                                            <label
                                                class="col-md-3 col-from-label">{{ translate('Discount') }}<br>({{ translate('for_flash_deal') }})</label>
                                            <div class="col-xxl-9">
                                                <input type="number" name="flash_discount" value="0"
                                                    min="0" step="0.01" class="form-control">
                                            </div>
                                        </div>
                                        <!-- Discount Type -->
                                        <div class="form-group row">
                                            <label
                                                class="col-md-3 col-from-label">{{ translate('Discount Type') }}<br>({{ translate('for_flash_deal') }})</label>
                                            <div class="col-xxl-9">
                                                <select class="form-control aiz-selectpicker" name="flash_discount_type"
                                                    id="flash_discount_type">
                                                    <option value="">{{ translate('Choose Discount Type') }}
                                                    </option>
                                                    <option value="amount">{{ translate('Flat') }}</option>
                                                    <option value="percent">{{ translate('Percent') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Price & Stock -->
                                    {{-- <h5 class="mb-3 pb-3 fs-17 fw-700" style="border-bottom: 1px dashed #e4e5eb;">
                                    {{ translate('Product price & stock') }}</h5> --}}
                                    <div class="w-100">
                                        <div>
                                            <p>{{ translate('Choose the attributes of this product and then input values of each attribute') }}
                                            </p>
                                        </div>
                                        <!-- Colors -->
                                        <div class="form-group row gutters-5">
                                            <div class="col-md-3">
                                                <input type="text" class="form-control"
                                                    value="{{ translate('Colors') }}" disabled>
                                            </div>
                                            <div class="col-md-9">
                                                <select class="form-control aiz-selectpicker" data-live-search="true"
                                                    data-selected-text-format="count" name="colors[]" id="colors"
                                                    multiple>
                                                    @foreach (\App\Models\Color::orderBy('name', 'asc')->get() as $key => $color)
                                                        <option value="{{ $color->code }}"
                                                            data-content="<span><span class='size-15px d-inline-block mr-2 rounded border' style='background:{{ $color->code }}'></span><span>{{ $color->name }}</span></span>">
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <!-- Attributes -->
                                        {{-- <div class="form-group row gutters-5">
                                            <div class="col-md-3">
                                                <input type="text" class="form-control"
                                                    value="{{ translate('Attributes') }}" disabled>
                                            </div>
                                            <div class="col-md-9">
                                                <select name="choice_attributes[]" id="choice_attributes"
                                                    class="form-control aiz-selectpicker"
                                                    data-selected-text-format="count" data-live-search="true" multiple
                                                    data-placeholder="{{ translate('Choose Attributes') }}">
                                                    @foreach (\App\Models\Attribute::all() as $key => $attribute)
                                                        <option value="{{ $attribute->id }}">
                                                            {{ $attribute->getTranslation('name') }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> --}}

                                        <!-- choice options -->
                                        <div class="customer_choice_options mb-4" id="customer_choice_options">
                                            @foreach (\App\Models\Attribute::all() as $key => $attribute)
                                                <div class="form-group row gutters-5">
                                                    <div class="col-md-3">
                                                        <input type="hidden" name="choice_no[]"
                                                            value="{{ $attribute->id }}">
                                                        <input type="text" class="form-control" name="choice[]"
                                                            value="{{ $attribute->getTranslation('name') }}"
                                                            placeholder="{{ translate('Choice Title') }}" readonly>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <select class="form-control aiz-selectpicker attribute_choice"
                                                            data-live-search="true"
                                                            name="choice_options_{{ $attribute->id }}[]"
                                                            data-selected-text-format="count" multiple>
                                                            @php
                                                                $all_attribute_values = \App\Models\AttributeValue::with(
                                                                    'attribute',
                                                                )
                                                                    ->where('attribute_id', $attribute->id)
                                                                    ->get();
                                                            @endphp
                                                            @foreach ($all_attribute_values as $row)
                                                                <option value="{{ $row->value }}">{{ $row->value }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <!-- sku combination -->
                                        <div class="sku_combination" id="sku_combination"></div>

                                        <!-- Discount Date Range -->
                                        <div class="form-group row">
                                            <label class="col-sm-3 control-label"
                                                for="start_date">{{ translate('Discount Date Range') }}</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control aiz-date-range"
                                                    name="date_range" placeholder="{{ translate('Select Date') }}"
                                                    data-time-picker="true" data-format="DD-MM-Y HH:mm:ss"
                                                    data-separator=" to " autocomplete="off">
                                            </div>
                                        </div>
                                        <!-- Discount -->
                                        <div class="form-group row">
                                            <label class="col-md-3 col-from-label">{{ translate('Discount') }} <span
                                                    class="text-danger">*</span></label>
                                            <div class="col-md-6">
                                                <input type="number" lang="en" min="0" value="0"
                                                    step="0.01" placeholder="{{ translate('Discount') }}"
                                                    name="discount" class="form-control">
                                            </div>
                                            <div class="col-md-3">
                                                <select class="form-control aiz-selectpicker" name="discount_type">
                                                    <option value="amount" @selected(old('discount_type') == 'amount')>
                                                        {{ translate('Flat') }}</option>
                                                    <option value="percent" @selected(old('discount_type') == 'percent')>
                                                        {{ translate('Percent') }}</option>
                                                </select>
                                            </div>
                                        </div>

                                        @if (addon_is_activated('club_point'))
                                            <!-- club point -->
                                            <div class="form-group row">
                                                <label class="col-md-3 col-from-label">
                                                    {{ translate('Set Point') }}
                                                </label>
                                                <div class="col-md-6">
                                                    <input type="number" lang="en" min="0" value="0"
                                                        step="1" placeholder="{{ translate('1') }}"
                                                        name="earn_point" class="form-control">
                                                </div>
                                            </div>
                                        @endif

                                        <div id="show-hide-div">
                                            <!-- SKU -->
                                            <div class="form-group row">
                                                <label class="col-md-3 col-from-label">
                                                    {{ translate('SKU') }}
                                                </label>
                                                <div class="col-md-6">
                                                    <input type="text" placeholder="{{ translate('SKU') }}"
                                                        name="sku" value="{{ old('sku') ?? generate_sku() }}"
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- External link -->
                                        <div class="form-group row">
                                            <label class="col-md-3 col-from-label">
                                                {{ translate('External link') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" placeholder="{{ translate('External link') }}"
                                                    value="{{ old('external_link') }}" name="external_link"
                                                    class="form-control">
                                                <small
                                                    class="text-muted">{{ translate('Leave it blank if you do not use external site link') }}</small>
                                            </div>
                                        </div>
                                        <!-- External link button text -->
                                        <div class="form-group row">
                                            <label class="col-md-3 col-from-label">
                                                {{ translate('External link button text') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text"
                                                    placeholder="{{ translate('External link button text') }}"
                                                    name="external_link_btn" value="{{ old('external_link_btn') }}"
                                                    class="form-control">
                                                <small
                                                    class="text-muted">{{ translate('Leave it blank if you do not use external site link') }}</small>
                                            </div>
                                        </div>


                                        <!-- Video Provider -->
                                        <div class="form-group row">
                                            <label
                                                class="col-md-3 col-from-label">{{ translate('Video Provider') }}</label>
                                            <div class="col-md-9">
                                                <select class="form-control aiz-selectpicker" name="video_provider"
                                                    id="video_provider">
                                                    <option value="youtube" @selected(old('video_provider') == 'youtube')>
                                                        {{ translate('Youtube') }}</option>
                                                    <option value="dailymotion" @selected(old('video_provider') == 'dailymotion')>
                                                        {{ translate('Dailymotion') }}</option>
                                                    <option value="vimeo" @selected(old('video_provider') == 'vimeo')>
                                                        {{ translate('Vimeo') }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- Video Link -->
                                        <div class="form-group row">
                                            <label class="col-md-3 col-from-label">{{ translate('Video Link') }}</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="video_link"
                                                    value="{{ old('video_link') }}"
                                                    placeholder="{{ translate('Video Link') }}">
                                                <small
                                                    class="text-muted">{{ translate("Use proper link without extra parameter. Don't use short share link/embeded iframe code.") }}</small>
                                            </div>
                                        </div>
                                        <!-- PDF Specification -->
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label"
                                                for="signinSrEmail">{{ translate('PDF Specification') }}</label>
                                            <div class="col-md-9">
                                                <div class="input-group" data-toggle="aizuploader" data-type="document">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                            {{ translate('Browse') }}</div>
                                                    </div>
                                                    <div class="form-control file-amount">{{ translate('Choose File') }}
                                                    </div>
                                                    <input type="hidden" name="pdf" class="selected-files">
                                                </div>
                                                <div class="file-preview box sm">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Stock Visibility State -->
                                    {{-- <h5 class="mb-3 pb-3 fs-17 fw-700" style="border-bottom: 1px dashed #e4e5eb;">
                                    {{ translate('Stock Visibility State') }}</h5> --}}
                                </div>

                                <div class="col-md-6">
                                    <!-- Low Stock Quantity -->
                                    {{-- <h5 class="mb-3 pb-3 fs-17 fw-700" style="border-bottom: 1px dashed #e4e5eb;">
                                    {{ translate('Low Stock Quantity Warning') }}</h5> --}}
                                    <div class="w-100 mt-4">
                                        <div class="form-group row">
                                            <label class="col-md-3 col-from-label">
                                                {{ translate('Low Stock Quantity Warning') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="number" name="low_stock_quantity" value="1"
                                                    min="0" step="1" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Minimum Order Amount -->
                                    {{-- <h5 class="mb-3 pb-3 fs-17 fw-700" style="border-bottom: 1px dashed #e4e5eb;">
                                        {{ translate('Minimum Order Amount') }}</h5> --}}
                                    <div class="w-100 mb-3">
                                        <div class="form-group row">
                                            <label class="col-md-3 col-from-label">
                                                {{ translate('Minimum Order Amount') }}
                                            </label>
                                            <div class="col-md-6">
                                                <input type="number" name="minimum_pay" value="0"
                                                    class="form-control">
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group row">
                                                    <label
                                                        class="col-md-9 col-from-label">{{ translate('With Shipping Cost') }}</label>
                                                    <div class="col-md-3">
                                                        <label class="aiz-switch aiz-switch-success mb-0">
                                                            <input type="checkbox" name="minimum_pay_with_shipping"
                                                                value="1">
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label
                                                        class="col-md-9 col-from-label">{{ translate('For Each Product') }}</label>
                                                    <div class="col-md-3">
                                                        <label class="aiz-switch aiz-switch-success mb-0">
                                                            <input type="checkbox" name="minimum_pay_each_product"
                                                                value="1">
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Show Stock Quantity -->
                                        <div class="form-group row">
                                            <label
                                                class="col-md-3 col-from-label">{{ translate('Show Stock Quantity') }}</label>
                                            <div class="col-md-9">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="radio" name="stock_visibility_state" value="quantity"
                                                        checked>
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                        <!-- Show Stock With Text Only -->
                                        <div class="form-group row">
                                            <label
                                                class="col-md-3 col-from-label">{{ translate('Show Stock With Text Only') }}</label>
                                            <div class="col-md-9">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="radio" name="stock_visibility_state" value="text">
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                        <!-- Hide Stock -->
                                        <div class="form-group row">
                                            <label class="col-md-3 col-from-label">{{ translate('Hide Stock') }}</label>
                                            <div class="col-md-9">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="radio" name="stock_visibility_state" value="hide">
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Shipping -->
                                    <div class="w-100">
                                        <!-- Shipping Configuration -->
                                        {{-- <h5 class="mb-3 pb-3 fs-17 fw-700">
                                            {{ translate('Shipping Configuration') }}</h5> --}}
                                        <div class="w-100">
                                            <!-- Cash On Delivery -->
                                            @if (get_business_setting('cash_payment') == '1')
                                                <div class="form-group row">
                                                    <label
                                                        class="col-md-3 col-from-label">{{ translate('Cash On Delivery') }}</label>
                                                    <div class="col-md-9">
                                                        <label class="aiz-switch aiz-switch-success mb-0">
                                                            <input type="checkbox" name="cash_on_delivery" value="1"
                                                                checked="">
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            @else
                                                <p>
                                                    {{ translate('Cash On Delivery option is disabled. Activate this feature from here') }}
                                                    <a href="{{ route('activation.index') }}"
                                                        class="aiz-side-nav-link {{ areActiveRoutes(['shipping_configuration.index', 'shipping_configuration.edit', 'shipping_configuration.update']) }}">
                                                        <span
                                                            class="aiz-side-nav-text">{{ translate('Cash Payment Activation') }}</span>
                                                    </a>
                                                </p>
                                            @endif

                                            @if (get_business_setting('shipping_type') == 'product_wise_shipping')
                                                <!-- Free Shipping -->
                                                <div class="form-group row">
                                                    <label
                                                        class="col-md-3 col-from-label">{{ translate('Free Shipping') }}</label>
                                                    <div class="col-md-9">
                                                        <label class="aiz-switch aiz-switch-success mb-0">
                                                            <input type="radio" name="shipping_type" value="free"
                                                                checked>
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <!-- Flat Rate -->
                                                <div class="form-group row">
                                                    <label
                                                        class="col-md-3 col-from-label">{{ translate('Flat Rate') }}</label>
                                                    <div class="col-md-9">
                                                        <label class="aiz-switch aiz-switch-success mb-0">
                                                            <input type="radio" name="shipping_type" value="flat_rate">
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <!-- Shipping cost -->
                                                <div class="flat_rate_shipping_div" style="display: none">
                                                    <div class="form-group row">
                                                        <label
                                                            class="col-md-3 col-from-label">{{ translate('Shipping cost') }}</label>
                                                        <div class="col-md-9">
                                                            <input type="number" lang="en" min="0"
                                                                value="0" step="0.01"
                                                                placeholder="{{ translate('Shipping cost') }}"
                                                                name="flat_shipping_cost" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Is Product Quantity Mulitiply -->
                                                <div class="form-group row">
                                                    <label
                                                        class="col-md-3 col-from-label">{{ translate('Is Product Quantity Mulitiply') }}</label>
                                                    <div class="col-md-9">
                                                        <label class="aiz-switch aiz-switch-success mb-0">
                                                            <input type="checkbox" name="is_quantity_multiplied"
                                                                value="1">
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            @else
                                                <p>
                                                    {{ translate('Product wise shipping cost is disable. Shipping cost is configured from here') }}
                                                    <a href="{{ route('shipping_configuration.index') }}"
                                                        class="aiz-side-nav-link {{ areActiveRoutes(['shipping_configuration.index', 'shipping_configuration.edit', 'shipping_configuration.update']) }}">
                                                        <span
                                                            class="aiz-side-nav-text">{{ translate('Shipping Configuration') }}</span>
                                                    </a>
                                                </p>
                                            @endif
                                        </div>

                                        <!-- Estimate Shipping Time -->
                                        <div class="w-100">
                                            <div class="form-group row">
                                                <label
                                                    class="col-md-3 col-from-label">{{ translate('Estimate Shipping Time') }}</label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <input type="number" class="form-control"
                                                            name="est_shipping_days"
                                                            value="{{ old('est_shipping_days') }}" min="1"
                                                            step="1"
                                                            placeholder="{{ translate('Shipping Days') }}">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"
                                                                id="inputGroupPrepend">{{ translate('Days') }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Vat & TAX -->
                                        <div class="w-100">
                                            @foreach (\App\Models\Tax::where('tax_status', 1)->get() as $tax)
                                                <div class="form-row">
                                                    <label for="name" class="col-md-2">
                                                        {{ $tax->name }}
                                                        <input type="hidden" value="{{ $tax->id }}"
                                                            name="tax_id[]">
                                                    </label>
                                                    <div class="form-group col-md-5">
                                                        <input type="number" lang="en" min="0"
                                                            value="0" step="0.01"
                                                            placeholder="{{ translate('Tax') }}" name="tax[]"
                                                            class="form-control">
                                                    </div>
                                                    <div class="form-group col-md-5">
                                                        <select class="form-control aiz-selectpicker" name="tax_type[]">
                                                            <option value="amount">{{ translate('Flat') }}</option>
                                                            <option value="percent">{{ translate('Percent') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <!-- Dropshop -->
                                        <div class="w-100">
                                            <div id="dropship-rows">
                                                <div class="form-row dropship-row">
                                                    <label for="name" class="col-md-2">
                                                        <p>Dropship Price</p>
                                                    </label>
                                                    <div class="form-group col-md-4">
                                                        <input type="text" placeholder="1-5" name="dropship_range[]"
                                                            class="form-control">
                                                    </div>
                                                    <div class="form-group col-md-5">
                                                        <input type="text" placeholder="Price" name="dropship_price[]"
                                                            class="form-control">
                                                    </div>
                                                    <div class="form-group col-md-1">
                                                        <button type="button" class="btn btn-sm btn-danger remove-row">
                                                            <i class="la la-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" id="add-row" class="btn btn-primary mt-2">
                                                <i class="la la-plus"></i> Add Price Range
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SEO -->
                            <div class="bg-white d-none">
                                <!-- tab Title -->
                                <h5 class="mb-3 pb-3 fs-17 fw-700" style="border-bottom: 1px dashed #e4e5eb;">
                                    {{ translate('SEO Meta Tags') }}</h5>
                                <div class="w-100">
                                    <!-- Meta Title -->
                                    <div class="form-group row">
                                        <label class="col-md-3 col-from-label">{{ translate('Meta Title') }}</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="meta_title"
                                                value="{{ old('meta_title') }}"
                                                placeholder="{{ translate('Meta Title') }}">
                                        </div>
                                    </div>
                                    <!-- Description -->
                                    <div class="form-group row">
                                        <label class="col-md-3 col-from-label">{{ translate('Description') }}</label>
                                        <div class="col-md-9">
                                            <textarea name="meta_description" rows="8" class="form-control">{{ old('meta_description') }}</textarea>
                                        </div>
                                    </div>
                                    <!--Meta Image -->
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label"
                                            for="signinSrEmail">{{ translate('Meta Image') }}</label>
                                        <div class="col-md-9">
                                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                        {{ translate('Browse') }}</div>
                                                </div>
                                                <div class="form-control file-amount">{{ translate('Choose File') }}
                                                </div>
                                                <input type="hidden" name="meta_img" class="selected-files">
                                            </div>
                                            <div class="file-preview box sm">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Frequently Bought Product -->
                            <div class="bg-white">
                                <!-- tab Title -->
                                <h5 class="mb-3 pb-3 fs-17 fw-700">{{ translate('Frequently Bought') }}</h5>
                                <div class="w-100">
                                    <div class="d-flex mb-4">
                                        <div class="radio mar-btm mr-5 d-flex align-items-center">
                                            <input id="fq_brought_select_products" type="radio"
                                                name="frequently_bought_selection_type" value="product"
                                                onchange="fq_brought_product_selection_type()" checked>
                                            <label for="fq_brought_select_products"
                                                class="fs-14 fw-700 mb-0 ml-2">{{ translate('Select Product') }}</label>
                                        </div>
                                        <div class="radio mar-btm mr-3 d-flex align-items-center">
                                            <input id="fq_brought_select_category" type="radio"
                                                name="frequently_bought_selection_type" value="category"
                                                onchange="fq_brought_product_selection_type()">
                                            <label for="fq_brought_select_category"
                                                class="fs-14 fw-700 mb-0 ml-2">{{ translate('Select Category') }}</label>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-body">
                                            <div class="fq_brought_select_product_div">

                                                <div id="selected-fq-brought-products">

                                                </div>

                                                <button type="button"
                                                    class="btn btn-block border border-dashed hov-bg-soft-secondary fs-14 rounded-0 d-flex align-items-center justify-content-center"
                                                    onclick="showFqBroughtProductModal()">
                                                    <i class="las la-plus"></i>
                                                    <span class="ml-2">{{ translate('Add More') }}</span>
                                                </button>
                                            </div>

                                            {{-- Select Category for Frequently Bought Product --}}
                                            <div class="fq_brought_select_category_div d-none">
                                                <div class="form-group row">
                                                    <label
                                                        class="col-md-2 col-from-label">{{ translate('Category') }}</label>
                                                    <div class="col-md-10">
                                                        <select class="form-control aiz-selectpicker"
                                                            data-placeholder="{{ translate('Select a Category') }}"
                                                            name="fq_brought_product_category_id" data-live-search="true"
                                                            required>
                                                            @foreach ($categories as $category)
                                                                <option value="{{ $category->id }}">
                                                                    {{ $category->getTranslation('name') }}</option>
                                                                @foreach ($category->childrenCategories as $childCategory)
                                                                    @include('categories.child_category', [
                                                                        'child_category' => $childCategory,
                                                                    ])
                                                                @endforeach
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Save Button -->
                    <div class="mt-4 text-right">
                        <button type="submit" name="button" value="unpublish"
                            class="mx-2 btn btn-light w-230px btn-md rounded-2 fs-14 fw-700 shadow-secondary border-soft-secondary action-btn">{{ translate('Save & Unpublish') }}</button>
                        <button type="submit" name="button" value="publish"
                            class="mx-2 btn btn-success w-230px btn-md rounded-2 fs-14 fw-700 shadow-success action-btn">{{ translate('Save & Publish') }}</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection

@section('modal')
    <!-- Frequently Bought Product Select Modal -->
    @include('modals.product_select_modal')
@endsection

@section('script')
    <!-- Treeview js -->
    <script src="{{ static_asset('assets/js/hummingbird-treeview.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            initializeTreeView();
            handleFormSubmission();
            handleShippingTypeChange();
            handleMinimumPayCheckboxes();
            initializeSkuUpdateEvents();
            initializeFqBroughtProductSelectionType();
            handleTabHashChange();
            initializeAdvanceButton();
            initializeAddRowButton();

            $('#tags').on('keydown', function(e) {
                if (e.key === 'Enter' || e.keyCode === 13) {
                    e.preventDefault();
                }
            });

            // $('#tags').tagsinput({
            //     trimValue: true,
            // });
        });

        function initializeTreeView() {
            $("#treeview").hummingbird();
            var main_id = '{{ old('category_id') }}';
            var selected_ids = @json(old('category_ids') ?? []);

            if (selected_ids.length > 0) {
                selectCategories(selected_ids);
            } else {
                selectFirstCategory();
            }

            if (main_id) {
                $('#treeview input:radio[value=' + main_id + ']').prop('checked', true);
            } else {
                $('#treeview input:radio').first().prop('checked', true);
            }
        }

        function selectCategories(selected_ids) {
            selected_ids.forEach(function(element) {
                let checkbox = $('#treeview input:checkbox#' + element);
                checkbox.prop('checked', true);
                checkbox.parents("ul").css("display", "block");
                checkbox.parents("li").children('.las').removeClass("la-plus").addClass('la-minus');
            });
        }

        function selectFirstCategory() {
            let firstCategory = $('#treeview input:checkbox').first();
            firstCategory.prop('checked', true);
            firstCategory.parents("ul").css("display", "block");
            firstCategory.parents("li").children('.las').removeClass("la-plus").addClass('la-minus');
        }

        function handleFormSubmission() {
            $('form').on('submit', function(e) {
                if ($(".action-btn").attr('attempted') === 'true') {
                    e.preventDefault();
                } else {
                    $(".action-btn").attr("attempted", 'true');
                }
            });
        }

        function handleShippingTypeChange() {
            $("[name=shipping_type]").on("change", function() {
                $(".flat_rate_shipping_div").toggle($(this).val() === 'flat_rate');
            });
        }

        function handleMinimumPayCheckboxes() {
            $('#minimum_pay_with_shipping, #minimum_pay_each_product').on('change', function() {
                $(this).val($(this).is(':checked') ? 1 : 0);
            }).change();
        }

        function initializeSkuUpdateEvents() {
            $(document).on("change", ".attribute_choice", update_sku);
            $('#colors').on('change', update_sku);
            $('.attribute_choice').on('change', update_sku);
            $('input[name="unit_price"], input[name="name"]').on('keyup', update_sku);
        }

        function update_sku() {
            $.ajax({
                type: "POST",
                url: '{{ route('products.sku_combination') }}',
                data: $('#choice_form').serialize(),
                success: function(data) {
                    console.log(data);
                    $('#sku_combination').html(data);
                    AIZ.uploader.previewGenerate();
                    AIZ.plugins.fooTable();
                    $('#show-hide-div').toggle(data.trim().length <= 1);
                }
            });
        }

        function initializeFqBroughtProductSelectionType() {
            fq_brought_product_selection_type();
        }

        function fq_brought_product_selection_type() {
            var productSelectionType = $("input[name='frequently_bought_selection_type']:checked").val();
            $('.fq_brought_select_product_div').toggleClass('d-none', productSelectionType !== 'product');
            $('.fq_brought_select_category_div').toggleClass('d-none', productSelectionType !== 'category');
        }

        function showFqBroughtProductModal() {
            $('#fq-brought-product-select-modal').modal('show', {
                backdrop: 'static'
            });
        }

        function filterFqBroughtProduct() {
            var searchKey = $('input[name=search_keyword]').val();
            var fqBroughCategory = $('select[name=fq_brough_category]').val();
            $.post('{{ route('product.search') }}', {
                _token: AIZ.data.csrf,
                product_id: null,
                search_key: searchKey,
                category: fqBroughCategory,
                product_type: "physical"
            }, function(data) {
                $('#product-list').html(data);
                AIZ.plugins.fooTable();
            });
        }

        function addFqBroughtProduct() {
            var selectedProducts = $("input:checkbox[name=fq_brought_product_id]:checked").map(function() {
                return $(this).val();
            }).get();

            var fqBroughtProductIds = $("input[name='fq_brought_product_ids[]']").map(function() {
                return $(this).val();
            }).get();

            var productIds = [...new Set([...selectedProducts, ...fqBroughtProductIds])];

            $.post('{{ route('get-selected-products') }}', {
                _token: '{{ @csrf_token() }}',
                product_ids: productIds
            }, function(data) {
                $('#fq-brought-product-select-modal').modal('hide');
                $('#selected-fq-brought-products').html(data);
                AIZ.plugins.fooTable();
            });
        }

        function handleTabHashChange() {
            var hash = document.location.hash;
            if (hash) {
                $('.nav-tabs a[href="' + hash + '"]').tab('show');
            } else {
                $('.nav-tabs a[href="#general"]').tab('show');
            }

            $('.nav-tabs a').on('shown.bs.tab', function(e) {
                window.location.hash = e.target.hash;
            });
        }

        function initializeAdvanceButton() {
            $('#advance_button').click(function() {
                $('#advance_div').slideToggle();
            });
        }

        function initializeAddRowButton() {
            $('#add-row').click(function() {
                var newRow = `
                    <div class="form-row dropship-row">
                        <label for="name" class="col-md-2"><p>Dropship Price</p></label>
                        <div class="form-group col-md-4"><input type="text" placeholder="1-5" name="dropship_range[]" class="form-control"></div>
                        <div class="form-group col-md-5"><input type="text" placeholder="Price" name="dropship_price[]" class="form-control"></div>
                        <div class="form-group col-md-1"><button type="button" class="btn btn-sm btn-danger remove-row"><i class="la la-trash"></i></button></div>
                    </div>`;
                $('#dropship-rows').append(newRow);
            });

            $(document).on('click', '.remove-row', function() {
                $(this).closest('.form-row').remove();
            });
        }
    </script>
@endsection
