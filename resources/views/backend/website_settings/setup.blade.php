@extends('backend.layouts.app')

@section('content')
    <style>
        .clickable-header {
            cursor: pointer;
        }

        .clickable-header:hover {
            background-color: #f5f5f5;
        }
    </style>

    <!-- Language Bar -->
    <ul class="nav nav-tabs nav-fill border-light language-bar">
        @foreach (get_all_active_language() as $key => $language)
            <li class="nav-item">
                <a class="nav-link text-reset @if ($language->code == $lang) active @else bg-soft-dark border-light border-left-0 @endif py-3"
                    href="{{ route('website-setup', ['lang' => $language->code]) }}">
                    <img src="{{ static_asset('assets/img/flags/' . $language->code . '.png') }}" height="11"
                        class="mr-1">
                    <span>{{ $language->name }}</span>
                </a>
            </li>
        @endforeach
    </ul>

    <div class="mt-2">
        {{-- row 1 --}}
        <div class="row">
            {{-- Homepage Settings --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header clickable-header" data-div="homepage_settings_div">
                        <h6>{{ translate('Homepage Settings') }}</h6>
                    </div>
                </div>
            </div>

            {{-- Appearance --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header clickable-header" data-div="appearance_div">
                        <h6>{{ translate('Appearance') }}</h6>
                    </div>
                </div>
            </div>

            {{-- Homepage Settings Div --}}
            <div id="homepage_settings_div" class="col-md-12 showcase d-none">
                @include('backend.website_settings.pages.classic.home_page_edit')
            </div>

            {{-- Appearance Div --}}
            <div id="appearance_div" class="col-md-12 showcase d-none">
                @include('backend.website_settings.appearance')
            </div>
        </div>

        {{-- row 2 --}}
        <div class="row">
            {{-- Header --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header clickable-header" data-div="header_div">
                        <h6>{{ translate('Header') }}</h6>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header clickable-header" data-div="footer_div">
                        <h6>{{ translate('Footer') }}</h6>
                    </div>
                </div>
            </div>

            {{-- Header Div --}}
            <div id="header_div" class="col-md-12 showcase d-none">
                @include('backend.website_settings.header')
            </div>

            {{-- Footer Div --}}
            <div id="footer_div" class="col-md-12 showcase d-none">
                @include('backend.website_settings.footer')
            </div>
        </div>

        {{-- row 3 --}}
        <div class="row">
            {{-- Cart Settings --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header clickable-header" data-div="cart_settings_div">
                        <h6>{{ translate('Cart Settings') }}</h6>
                    </div>
                </div>
            </div>

            {{-- Features --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header clickable-header" data-div="features_activation_div">
                        <h6>{{ translate('Features') }}</h6>
                    </div>
                </div>
            </div>

            {{-- Toggleable Divs --}}
            <div id="cart_settings_div" class="col-md-12 showcase d-none">
                @include('backend.cart.settings')
            </div>

            <div id="features_activation_div" class="col-md-12 showcase d-none">
                @include('backend.setup_configurations.activation')
            </div>
        </div>

        {{-- row 4 --}}
        <div class="row">
            {{-- Social Media / Analytics --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header clickable-header" data-div="social_media_div">
                        <h6>{{ translate('social_media_analytics') }}</h6>
                    </div>
                </div>
            </div>

            {{-- Pages --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header clickable-header" data-url="{{ route('website.pages') }}">
                        <h6>{{ translate('Pages') }}</h6>
                    </div>
                </div>
            </div>

            {{-- Toggleable Divs --}}
            <div id="social_media_div" class="col-md-12 showcase d-none">
                @include('backend.setup_configurations.social_login')
            </div>
        </div>

        {{-- row 5 --}}
        <div class="row">
            {{-- Domain --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header clickable-header" data-url="{{ route('domain') }}">
                        <h6>{{ translate('Domain') }}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{-- setup --}}
    <script>
        $(document).ready(function() {
            // Toggle showcase visibility or redirect to URL
            $('.clickable-header').on('click', function() {
                const targetDivId = $(this).data('div');
                const redirectUrl = $(this).data('url');

                if (redirectUrl) {
                    // If a URL is provided, redirect to it
                    window.location.href = redirectUrl;
                } else if (targetDivId) {
                    // Otherwise, toggle visibility of the target div
                    const targetDiv = $('#' + targetDivId);
                    $('.showcase').not(targetDiv).addClass('d-none');
                    targetDiv.toggleClass('d-none');
                }
            });
        });
    </script>

    {{-- home page settings --}}
    <script>
        AIZ.plugins.bootstrapSelect('refresh');

        $(document).ready(function() {
            var hash = document.location.hash;
            if (hash) {
                $('.nav-tabs a[href="' + hash + '"]').tab('show');
            } else {
                $('.nav-tabs a[href="#home_slider"]').tab('show');
            }

            // Change hash for page-reload
            $('.nav-tabs a').on('shown.bs.tab', function(e) {
                window.location.hash = e.target.hash;
            });

            $('#brand_count').change(function() {
                handleHomePageSettingsFormSubmission('#brand_count_form');
            });

            $('#featured_category_count').change(function() {
                handleHomePageSettingsFormSubmission('#featured_category_count_form');
            });

            // Toggle div visibility for buttons
            $('.div_toggle_btn').click(function() {
                const divId = $(this).data('div');
                $('#' + divId).toggleClass('d-none');
                $(this).toggleClass('show_div hide_div');
            });
        });

        function handleHomePageSettingsFormSubmission(formId) {
            var formData = $(formId).serialize();

            $.ajax({
                url: $(formId).attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                    AIZ.plugins.notify('success', '{{ translate('Settings updated successfully') }}');
                },
                error: function(xhr, status, error) {
                    AIZ.plugins.notify('danger', 'Something went wrong');
                }
            });
        }

        function updateHomePageSettings(el, type) {
            if ($(el).is(':checked')) {
                var value = 1;
            } else {
                var value = 0;
            }

            $.post('{{ route('business_settings.update.activation') }}', {
                _token: '{{ csrf_token() }}',
                type: type,
                value: value
            }, function(data) {
                if (data == '1') {
                    AIZ.plugins.notify('success', '{{ translate('Settings updated successfully') }}');
                } else {
                    AIZ.plugins.notify('danger', 'Something went wrong');
                }
            });
        }

        function checkCategoryStatus(checkbox) {
            if (checkbox.checked) {
                $('#full_slider_div').removeClass('d-none').addClass('d-flex justify-content-between align-items-center');
            } else {
                $('#full_slider_div').addClass('d-none').removeClass('d-flex justify-content-between align-items-center');
            }
        }

        function checkScrollTextStatus(checkbox) {
            if (checkbox.checked) {
                $('#scroll_text_div').removeClass('d-none').addClass('d-block');
            } else {
                $('#scroll_text_div').addClass('d-none').removeClass('d-block');
            }
        }
    </script>

    {{-- features --}}
    <script type="text/javascript">
        $(document).ready(function() {
            var formIds = [
                '#thermal_printer_form',
                '#order_minimum_pay_type_form',
                '#minimum_order_form',
                '#phone_number_after_buy_now_form',
                '#no_of_decimals',
                '#order_minimum_payment_amount_form',
                '#monthly_sales_form',
                '#monthly_order_form',
                '#yearly_sales_form',
                '#yearly_order_form',
            ];

            // Attach change event to inputs inside forms
            formIds.forEach(function(formId) {
                $(formId + ' input').change(function() {
                    handleFeaturesFormSubmission(formId);
                });
            });

            // Handle select change for all forms
            formIds.forEach(function(formId) {
                $(formId + ' select').change(function() {
                    handleFeaturesFormSubmission(formId);
                });
            });

            // Additional specific form handlers
            $('#print_width').change(function() {
                handleFeaturesFormSubmission($(this).closest('form').attr('id'));
            });

            $('#order_minimum_pay_type').change(function() {
                handleFeaturesFormSubmission($(this).closest('form').attr('id'));
            });
        });

        function handleFeaturesFormSubmission(formId) {
            var formData = $(formId).serialize();

            $.ajax({
                url: $(formId).attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                    AIZ.plugins.notify('success', '{{ translate('Settings updated successfully') }}');
                },
                error: function(xhr, status, error) {
                    // AIZ.plugins.notify('danger', 'Something went wrong');
                }
            });
        }

        function updateFeatureSettings(el, type) {
            if ($(el).is(':checked')) {
                var value = 1;
            } else {
                var value = 0;
            }

            $.post('{{ route('business_settings.update.activation') }}', {
                _token: '{{ csrf_token() }}',
                type: type,
                value: value
            }, function(data) {
                if (data == '1') {
                    AIZ.plugins.notify('success', '{{ translate('Settings updated successfully') }}');
                } else {
                    AIZ.plugins.notify('danger', 'Something went wrong');
                }
            });
        }
    </script>

    {{-- cart settings --}}
    <script type="text/javascript">
        function updateCartSettings(el, type) {
            if ($(el).is(':checked')) {
                var value = 1;
            } else {
                var value = 0;
            }
            $.post('{{ route('cart.settings.update') }}', {
                _token: '{{ csrf_token() }}',
                type: type,
                value: value
            }, function(data) {
                if (data == 1) {
                    AIZ.plugins.notify('success', '{{ translate('Cart Settings updated successfully') }}');
                } else {
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }

        function toggleCartCustomField(el) {
            if ($(el).is(':checked')) {
                $('#customFieldSettings').removeClass('d-none');
                $('#customFieldSettings').addClass('d-block');
                updateCartSettings(el, 'custom_field');
            } else {
                $('#customFieldSettings').removeClass('d-block');
                $('#customFieldSettings').addClass('d-none');
                updateCartSettings(el, 'custom_field');
            }
        }
    </script>

    {{-- payment method --}}
    <script type="text/javascript">
        $(document).ready(function() {
            var paymentFormIds = [
                '#bkash_form',
                '#nagad_form',
                '#sslcommerz_form',
                '#aamarpay_form',
                '#uddoktapay_form',
                '#paypal_form',
                '#stripe_form',
                '#mercadopago_form',
                '#iyzico_form',
                '#instamojo_form',
                '#paystack_form',
                '#payhere_form',
                '#ngenius_form',
                '#voguepay_form',
                '#razorpay_form',
                '#authorizenet_form',
                '#payku_form',
                '#paytm_form',
                '#toyyibpay_form',
                '#myfatoorah_form',
                '#flutterwave_form',
                '#payfast_form'
            ];

            paymentFormIds.forEach(function(formId) {
                $(formId + ' input').change(function(event) {
                    handlePaymentFormSubmission(formId);
                });
            });
        });

        $("#toggleOnlinepayment").on("click", function() {
            $("#online_payment_card_body").slideToggle(300);
            const buttonText = $(this).text() === "Show" ? "Hide" : "Show";
            $(this).text(buttonText);
        });

        $("#toggleManualPayment").on("click", function() {
            $("#manual_payment_card_body").slideToggle(300);
            const buttonText = $(this).text() === "Show" ? "Hide" : "Show";
            $(this).text(buttonText);
        });

        $("#toggleLinkPayment").on("click", function() {
            $("#link_payment_card_body").slideToggle(300);
            const buttonText = $(this).text() === "Show" ? "Hide" : "Show";
            $(this).text(buttonText);
        });

        function handlePaymentFormSubmission(formId) {
            var formData = $(formId).serialize();

            $.ajax({
                url: $(formId).attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                    AIZ.plugins.notify('success',
                        '{{ translate('Settings updated successfully') }}');
                },
                error: function(xhr, status, error) {
                    AIZ.plugins.notify('danger', 'Something went wrong');
                }
            });
        }

        function updatePaymentSettings(el, type) {
            if ($(el).is(':checked')) {
                var value = 1;
            } else {
                var value = 0;
            }

            $.post('{{ route('business_settings.update.activation') }}', {
                _token: '{{ csrf_token() }}',
                type: type,
                value: value
            }, function(data) {
                if (data == '1') {
                    AIZ.plugins.notify('success', '{{ translate('Settings updated successfully') }}');
                } else {
                    AIZ.plugins.notify('danger', 'Something went wrong');
                }
            });
        }
    </script>
@endsection
