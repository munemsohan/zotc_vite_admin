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

        {{-- Header --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header clickable-header" data-div="header_div">
                    <h6>{{ translate('Header') }}</h6>
                </div>
            </div>
        </div>

        {{-- Toggleable Divs --}}
        <div id="homepage_settings_div" class="col-md-12 showcase d-none">
            @include('backend.website_settings.pages.classic.home_page_edit')
        </div>

        <div id="header_div" class="col-md-12 showcase d-none">
            @include('backend.website_settings.header')
        </div>
    </div>

    {{-- row 2 --}}
    <div class="row">
        {{-- Appearance --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header clickable-header" data-div="appearance_div">
                    <h6>{{ translate('Appearance') }}</h6>
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

        {{-- Toggleable Divs --}}
        <div id="appearance_div" class="col-md-12 showcase d-none">
            @include('backend.website_settings.appearance')
        </div>

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
        {{-- Social media / Analytics --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header clickable-header" data-div="social_media_div">
                    <h6>{{ translate('Social media / Analytics') }}</h6>
                </div>
            </div>
        </div>

        {{-- Payment Methods --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header clickable-header" data-div="payment_method_div">
                    <h6>{{ translate('Payment Methods') }}</h6>
                </div>
            </div>
        </div>

        {{-- Toggleable Divs --}}
        <div id="social_media_div" class="col-md-12 showcase d-none">
            @include('backend.setup_configurations.social_login')
        </div>

        <div id="payment_method_div" class="col-md-12 showcase d-none">
            @include('backend.setup_configurations.payment_method')
        </div>
    </div>

    {{-- row 5 --}}
    <div class="row">
        {{-- Pages --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header clickable-header" data-url="{{ route('website.pages') }}">
                    <h6>{{ translate('Pages') }}</h6>
                </div>
            </div>
        </div>

        {{-- Domain --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header clickable-header" data-url="{{ route('domain') }}">
                    <h6>{{ translate('Domain') }}</h6>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
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

            // Toggle div visibility for buttons
            $('.div_toggle_btn').click(function() {
                const divId = $(this).data('div');
                $('#' + divId).toggleClass('d-none');
                $(this).toggleClass('show_div hide_div');
            });

            // Forms for change event handling
            const formIds = [
                '#thermal_printer_form',
                '#order_minimum_pay_type_form',
                '#minimum_order_form',
                '#phone_number_after_buy_now_form',
                '#order_minimum_payment_amount_form',
                '#monthly_sales_form',
                '#monthly_order_form',
                '#yearly_sales_form',
                '#yearly_order_form',
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
                '#payfast_form',
            ];

            // Attach change event to inputs and selects inside forms
            formIds.forEach(function(formId) {
                $(`${formId} input, ${formId} select`).on('change', function() {
                    handleFormSubmission(formId);
                });
            });

            // Toggle card body functionality
            $("[id^='toggle']").on('click', function() {
                const targetId = $(this).data('target');
                $(`#${targetId}`).slideToggle(300);
                const buttonText = $(this).text() === "Show" ? "Hide" : "Show";
                $(this).text(buttonText);
            });
        });

        // Handle form submission
        function handleFormSubmission(formId) {
            const formData = $(formId).serialize();
            const actionUrl = $(formId).attr('action');

            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: formData,
                success: function() {
                    AIZ.plugins.notify('success', '{{ translate('Settings updated successfully') }}');
                },
                error: function() {
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                },
            });
        }

        // Update settings for checkbox inputs
        function updateSettings(el, type, route) {
            const value = $(el).is(':checked') ? 1 : 0;

            $.post(route, {
                _token: '{{ csrf_token() }}',
                type: type,
                value: value,
            }).done(function(data) {
                const status = data == '1' ? 'success' : 'danger';
                const message = data == '1' ?
                    '{{ translate('Settings updated successfully') }}' :
                    '{{ translate('Something went wrong') }}';
                AIZ.plugins.notify(status, message);
            });
        }

        // Toggle custom field settings
        function toggleCustomField(el) {
            const isChecked = $(el).is(':checked');
            $('#customFieldSettings').toggleClass('d-none', !isChecked).toggleClass('d-block', isChecked);
            updateSettings(el, 'custom_field', '{{ route('cart.settings.update') }}');
        }
    </script>
@endsection
