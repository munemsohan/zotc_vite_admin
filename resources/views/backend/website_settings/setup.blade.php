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
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.clickable-header').on('click', function() {
                const targetDiv = $('#' + $(this).data('div'));
                $('.showcase').not(targetDiv).addClass('d-none');
                targetDiv.toggleClass('d-none');
            });

            $('.div_toggle_btn').click(function() {
                var divId = $(this).data('div');
                $('#' + divId).toggleClass('d-none');
                $(this).toggleClass('show_div hide_div');
            });

            var formIds = [
                '#thermal_printer_form',
                '#order_minimum_pay_type_form',
                '#minimum_order_form',
                '#phone_number_after_buy_now_form',
                '#order_minimum_payment_amount_form',
                '#monthly_sales_form',
                '#monthly_order_form',
                '#yearly_sales_form',
                '#yearly_order_form',
            ];

            // Attach change event to inputs inside forms
            formIds.forEach(function(formId) {
                $(formId + ' input').change(function() {
                    handleFormSubmission(formId);
                });
            });

            // Handle select change for all forms
            formIds.forEach(function(formId) {
                $(formId + ' select').change(function() {
                    handleFormSubmission(formId);
                });
            });

            // Additional specific form handlers
            $('#print_width').change(function() {
                handleFormSubmission($(this).closest('form').attr('id'));
            });

            $('#order_minimum_pay_type').change(function() {
                handleFormSubmission($(this).closest('form').attr('id'));
            });
        });

        function handleFormSubmission(formId) {
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

        function updateSettings(el, type) {
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


        function updateSettings(el, type) {
            if ($(el).is(':checked')) {
                var value = 1;
            } else {
                var value = 0;
            }

            $.post('{{ route('business_settings.update.checkbox') }}', {
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

        function toggleCustomField(el) {
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
@endsection
