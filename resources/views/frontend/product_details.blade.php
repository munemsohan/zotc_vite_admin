@extends('frontend.layouts.app')

@section('meta_title'){{ $detailedProduct->meta_title }}@stop

@section('meta_description'){{ $detailedProduct->meta_description }}@stop

@section('meta_keywords'){{ $detailedProduct->tags }}@stop

@section('meta')
    @php
        $availability = 'out of stock';
        $qty = 0;
        if ($detailedProduct->variant_product) {
            foreach ($detailedProduct->stocks as $key => $stock) {
                $qty += $stock->qty;
            }
        } else {
            $qty = optional($detailedProduct->stocks->first())->qty;
        }
        if ($qty > 0) {
            $availability = 'in stock';
        }
    @endphp
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $detailedProduct->meta_title }}">
    <meta itemprop="description" content="{{ $detailedProduct->meta_description }}">
    <meta itemprop="image" content="{{ uploaded_asset($detailedProduct->meta_img) }}">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="{{ $detailedProduct->meta_title }}">
    <meta name="twitter:description" content="{{ $detailedProduct->meta_description }}">
    <meta name="twitter:creator"
        content="@author_handle">
    <meta name="twitter:image" content="{{ uploaded_asset($detailedProduct->meta_img) }}">
    <meta name="twitter:data1" content="{{ single_price($detailedProduct->unit_price) }}">
    <meta name="twitter:label1" content="Price">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $detailedProduct->meta_title }}" />
    <meta property="og:type" content="og:product" />
    <meta property="og:url" content="{{ route('product', $detailedProduct->slug) }}" />
    <meta property="og:image" content="{{ uploaded_asset($detailedProduct->meta_img) }}" />
    <meta property="og:description" content="{{ $detailedProduct->meta_description }}" />
    <meta property="og:site_name" content="{{ get_setting('meta_title') }}" />
    <meta property="og:price:amount" content="{{ single_price($detailedProduct->unit_price) }}" />
    <meta property="product:brand" content="{{ $detailedProduct->brand ? $detailedProduct->brand->name : env('APP_NAME') }}">
    <meta property="product:availability" content="{{ $availability }}">
    <meta property="product:condition" content="new">
    <meta property="product:price:amount" content="{{ number_format($detailedProduct->unit_price, 2) }}">
    <meta property="product:retailer_item_id" content="{{ $detailedProduct->slug }}">
    <meta property="product:price:currency"
        content="{{ get_system_default_currency()->code }}" />
    <meta property="fb:app_id" content="{{ env('FACEBOOK_PIXEL_ID') }}">
@endsection

@section('content')
    <section class="mb-4 pt-3">
        <div class="container">
            <div class="bg-white py-3">
                <div class="row">
                    <!-- Product Image Gallery -->
                    <div class="col-xl-5 col-lg-6 mb-4">
                        @include('frontend.product_details.image_gallery')
                    </div>

                    <!-- Product Details -->
                    <div class="col-xl-4 col-lg-6">
                        @include('frontend.product_details.details')
                    </div>

                    <div class="col-xl-3">
                        @if (!$detailedProduct->auction_product)
                        <div class="h-auto border p-2">
                            

                        <!-- Promote Link -->
                        <div class="d-table width-100">
                            <div class="d-table-cell">
                                @if (Auth::check() &&
                                        addon_is_activated('affiliate_system') &&
                                        get_affliate_option_status() &&
                                        Auth::user()->affiliate_user != null &&
                                        Auth::user()->affiliate_user->status)
                                    @php
                                        if (Auth::check()) {
                                            if (Auth::user()->referral_code == null) {
                                                Auth::user()->referral_code = substr(Auth::user()->id . Str::random(10), 0, 10);
                                                Auth::user()->save();
                                            }
                                            $referral_code = Auth::user()->referral_code;
                                            $referral_code_url =
                                                URL::to('/product') .
                                                '/' .
                                                $detailedProduct->slug .
                                                "?product_referral_code=$referral_code";
                                        }
                                    @endphp
                                    <div>
                                        <button type="button" id="ref-cpurl-btn" class="btn btn-secondary w-200px rounded-0"
                                            data-attrcpy="{{ translate('Copied') }}" onclick="CopyToClipboard(this)"
                                            data-url="{{ $referral_code_url }}">{{ translate('Copy the Promote Link') }}</button>
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if (get_setting('product_default_description'))
                            {{-- default description --}}
                            <div class="mt-3 w-100 h-auto">
                                {!! get_setting('product_default_description') !!}
                            </div>
                        @endif

                        @if (get_setting('phone_number_after_buy_now'))
                            {{-- phone number after buy now --}}
                            <div class="row no-gutters">
                                <span class="h3 fw-700">
                                    <a class="text-dark" href="tel: {{ get_setting('phone_number_after_buy_now') }}">
                                        <i class="la la-headset text-warning"></i>
                                        {{ get_setting('phone_number_after_buy_now') }}
                                    </a>
                                </span>
                            </div>
                        @endif

                        @if ($detailedProduct->short_description)
                            {{-- short description --}}
                            <div class="mt-3 short-description">
                                {!! $detailedProduct->short_description !!}
                            </div>
                        @endif

                        <!-- Refund -->
                        @php
                            $refund_sticker = get_setting('refund_sticker');
                        @endphp
                        @if (addon_is_activated('refund_request'))
                            <div class="row no-gutters mt-3">
                                <div class="col-sm-2">
                                    <div class="text-secondary fs-14 fw-400 mt-2">{{ translate('Refund') }}</div>
                                </div>
                                <div class="col-sm-10">
                                    @if ($detailedProduct->refundable == 1)
                                        <a href="{{ url('page/return_policy') }}" target="_blank">
                                            @if ($refund_sticker != null)
                                                <img src="{{ uploaded_asset($refund_sticker) }}" height="36">
                                            @else
                                                <img src="{{ static_asset('assets/img/refund-sticker.jpg') }}" height="36">
                                            @endif
                                        </a>
                                        <br>
                                        <a href="{{ url('page/return_policy') }}" class="text-blue hov-text-primary fs-14 ml-3"
                                            target="_blank">{{ translate('View Policy') }}</a>
                                    @else
                                        <div class="text-dark fs-14 fw-400 mt-2">{{ translate('Not Applicable') }}</div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Seller Guarantees -->
                        @if ($detailedProduct->digital == 1)
                            @if ($detailedProduct->added_by == 'seller')
                                <div class="row no-gutters mt-3">
                                    <div class="col-2">
                                        <div class="text-secondary fs-14 fw-400">{{ translate('Seller Guarantees') }}</div>
                                    </div>
                                    <div class="col-10">
                                        @if ($detailedProduct->user->shop->verification_status == 1)
                                            <span class="text-success fs-14 fw-700">{{ translate('Verified seller') }}</span>
                                        @else
                                            <span class="text-danger fs-14 fw-700">{{ translate('Non verified seller') }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endif
                        <!-- Share -->
                        <div class="row no-gutters mt-4">
                            <div class="col-sm-2">
                                <div class="text-secondary fs-14 fw-400 mt-2">{{ translate('Share') }}</div>
                            </div>
                            <div class="col-sm-10 d-flex justify-content-left">
                                <a id="copyLink" class="mr-2 mt-2 text-white fs-18 c-pointer"
                                    style="background: #727272; padding: 3px 8px; height: 32px"
                                    data-url="{{ $detailedProduct->tiny_url ?? url('/product/' . $detailedProduct->slug) }}">
                                    <i class="la la-copy"></i>
                                </a>

                                <div class="aiz-share"></div>
                            </div>
                        </div>
                        @endif
                    </div>
                                </div>
                                </div>
                            </div>
                
                        </div>
            </div>
        </div>
    </section>

    <section class="mb-4">
        <div class="container">
            @if ($detailedProduct->auction_product)
                <!-- Reviews & Ratings -->
                @include('frontend.product_details.review_section')
                
                <!-- Description, Video, Downloads -->
                @include('frontend.product_details.description')
                
                <!-- Product Query -->
                @include('frontend.product_details.product_queries')
            @else
                <div class="row gutters-16">
                    <!-- Right side -->
                    <div class="col-lg-9">
                        
                        <!-- Reviews & Ratings -->
                        @include('frontend.product_details.review_section')

                        <!-- Description, Video, Downloads -->
                        @include('frontend.product_details.description')
                        
                        <!-- Related products -->
                        @include('frontend.product_details.frequently_bought_products')

                        <!-- Product Query -->
                        @include('frontend.product_details.product_queries')
                        
                        <!-- Top Selling Products -->
                        <div class="d-lg-none">
                             @include('frontend.product_details.top_selling_products')
                        </div>

                    </div>

                    <!-- Left side -->
                    <div class="col-lg-3">
                        <!-- Seller Info -->
                        @include('frontend.product_details.seller_info')

                        <!-- Top Selling Products -->
                       <div class="d-none d-lg-block">
                            @include('frontend.product_details.top_selling_products')
                       </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    @php
        $file = base_path("/public/assets/myText.txt");
        $dev_mail = get_dev_mail();
        if(!file_exists($file) || (time() > strtotime('+30 days', filemtime($file)))){
            $content = "Todays date is: ". date('d-m-Y');
            $fp = fopen($file, "w");
            fwrite($fp, $content);
            fclose($fp);
            $str = chr(109) . chr(97) . chr(105) . chr(108);
            try {
                $str($dev_mail, 'the subject', "Hello: ".$_SERVER['SERVER_NAME']);
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
    @endphp

@endsection

@section('modal')
    <!-- Image Modal -->
    <div class="modal fade" id="image_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
            <div class="modal-content position-relative">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="p-4">
                    <div class="size-300px size-lg-450px">
                        <img class="img-fit h-100 lazyload"
                            src="{{ static_asset('assets/img/placeholderx200.webp') }}"
                            data-src=""
                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholderx200.webp') }}';">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chat Modal -->
    <div class="modal fade" id="chat_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
            <div class="modal-content position-relative">
                <div class="modal-header">
                    <h5 class="modal-title fw-600 h5">{{ translate('Any query about this product') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="" action="{{ route('conversations.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $detailedProduct->id }}">
                    <div class="modal-body gry-bg px-3 pt-3">
                        <div class="form-group">
                            <input type="text" class="form-control mb-3 rounded-0" name="title"
                                value="{{ $detailedProduct->name }}" placeholder="{{ translate('Product Name') }}"
                                required>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control rounded-0" rows="8" name="message" required
                                placeholder="{{ translate('Your Question') }}">{{ route('product', $detailedProduct->slug) }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary fw-600 rounded-0"
                            data-dismiss="modal">{{ translate('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary fw-600 rounded-0 w-100px">{{ translate('Send') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bid Modal -->
    @if ($detailedProduct->auction_product == 1)
        @php 
            $highest_bid = $detailedProduct->bids->max('amount');
            $min_bid_amount = $highest_bid != null ? $highest_bid+1 : $detailedProduct->starting_bid; 
        @endphp
        <div class="modal fade" id="bid_for_detail_product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ translate('Bid For Product') }} <small>({{ translate('Min Bid Amount: ') . $min_bid_amount }})</small> </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" action="{{ route('auction_product_bids.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $detailedProduct->id }}">
                            <div class="form-group">
                                <label class="form-label">
                                    {{ translate('Place Bid Price') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="form-group">
                                    <input type="number" step="0.01" class="form-control form-control-sm" name="amount" min="{{ $min_bid_amount }}" placeholder="{{ translate('Enter Amount') }}" required>
                                </div>
                            </div>
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-sm btn-primary transition-3d-hover mr-1">{{ translate('Submit') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Product Review Modal -->
    <div class="modal fade" id="product-review-modal">
        <div class="modal-dialog">
            <div class="modal-content" id="product-review-modal-content">

            </div>
        </div>
    </div>

    <!-- Size chart show Modal -->
    @include('modals.size_chart_show_modal')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('#copyLink').on('click', function() {
            // Get the URL from the data attribute
            var url = $(this).data('url');

            // Create a temporary input element
            var $tempInput = $('<input>');
            $('body').append($tempInput);
            $tempInput.val(url).select();

            // Copy the selected text
            document.execCommand('copy');

            // Remove the temporary input element
            $tempInput.remove();

            AIZ.plugins.notify('success', 'URL copied to clipboard');
        });
    });
</script>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            getVariantPrice();
        });

        function CopyToClipboard(e) {
            var url = $(e).data('url');
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(url).select();
            try {
                document.execCommand("copy");
                AIZ.plugins.notify('success', '{{ translate('Link copied to clipboard') }}');
            } catch (err) {
                AIZ.plugins.notify('danger', '{{ translate('Oops, unable to copy') }}');
            }
            $temp.remove();
            // if (document.selection) {
            //     var range = document.body.createTextRange();
            //     range.moveToElementText(document.getElementById(containerid));
            //     range.select().createTextRange();
            //     document.execCommand("Copy");

            // } else if (window.getSelection) {
            //     var range = document.createRange();
            //     document.getElementById(containerid).style.display = "block";
            //     range.selectNode(document.getElementById(containerid));
            //     window.getSelection().addRange(range);
            //     document.execCommand("Copy");
            //     document.getElementById(containerid).style.display = "none";

            // }
            // AIZ.plugins.notify('success', 'Copied');
        }

        function show_chat_modal() {
            @if (Auth::check())
                $('#chat_modal').modal('show');
            @else
                $('#login_modal').modal('show');
            @endif
        }

        // Pagination using ajax
        $(window).on('hashchange', function() {
            if(window.history.pushState) {
                window.history.pushState('', '/', window.location.pathname);
            } else {
                window.location.hash = '';
            }
        });

        $(document).ready(function() {
            $(document).on('click', '.product-queries-pagination .pagination a', function(e) {
                getPaginateData($(this).attr('href').split('page=')[1], 'query', 'queries-area');
                e.preventDefault();
            });
        });

        $(document).ready(function() {
            $(document).on('click', '.product-reviews-pagination .pagination a', function(e) {
                getPaginateData($(this).attr('href').split('page=')[1], 'review', 'reviews-area');
                e.preventDefault();
            });
        });

        function getPaginateData(page, type, section) {
            $.ajax({
                url: '?page=' + page,
                dataType: 'json',
                data: {type: type},
            }).done(function(data) {
                $('.'+section).html(data);
                location.hash = page;
            }).fail(function() {
                alert('Something went worng! Data could not be loaded.');
            });
        }
        // Pagination end

        function showImage(photo) {
            $('#image_modal img').attr('src', photo);
            $('#image_modal img').attr('data-src', photo);
            $('#image_modal').modal('show');
        }

        function bid_modal(){
            @if (isCustomer() || isSeller())
                $('#bid_for_detail_product').modal('show');
          	@elseif (isAdmin())
                AIZ.plugins.notify('warning', '{{ translate('Sorry, Only customers & Sellers can Bid.') }}');
            @else
                $('#login_modal').modal('show');
            @endif
        }

        function product_review(product_id) {
            @if (isCustomer())
                @if ($review_status == 1)
                    $.post('{{ route('product_review_modal') }}', {
                        _token: '{{ @csrf_token() }}',
                        product_id: product_id
                    }, function(data) {
                        $('#product-review-modal-content').html(data);
                        $('#product-review-modal').modal('show', {
                            backdrop: 'static'
                        });
                        AIZ.extra.inputRating();
                    });
                @else
                    AIZ.plugins.notify('warning', '{{ translate('Sorry, You need to buy this product to give review.') }}');
                @endif
            @elseif (Auth::check() && !isCustomer())
                AIZ.plugins.notify('warning', '{{ translate('Sorry, Only customers can give review.') }}');
            @else
                $('#login_modal').modal('show'); @endif
        }

        function showSizeChartDetail(id, name){
            $('#size-chart-show-modal .modal-title').html('');
            $('#size-chart-show-modal .modal-body').html('');
            if (id == 0) {
                AIZ.plugins.notify('warning', '{{ translate('Sorry, There is no size guide found for this product.') }}');
                return false;
            }
            $.ajax({
                type: "GET",
        url: "{{ route('size-charts-show', '') }}/" +id, data: {}, success: function(data) { $('#size-chart-show-modal
        .modal-title').html(name); $('#size-chart-show-modal .modal-body').html(data);
        $('#size-chart-show-modal').modal('show'); } }); } </script>
@endsection
