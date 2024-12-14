<div class="p-3">
    @if (get_cart_setting('name') == 1)
        <div class="row">
            <div class="col-md-2 mt-md-2">
                <label>{{ translate('Name') }}</label>
            </div>
            <div class="col-md-10">
                <input class="form-control mb-3 rounded-0" placeholder="{{ translate('Your Name') }}" rows="2"
                    name="name" required></input>
            </div>
        </div>
    @endif

    @if (get_cart_setting('address') == 1)
        <!-- Address -->
        <div class="row">
            <div class="col-md-2 mt-md-2">
                <label>{{ translate('Address') }}</label>
            </div>
            <div class="col-md-10">
                <textarea class="form-control mb-3 rounded-0" placeholder="{{ translate('Your Address') }}" rows="2"
                    name="address" required></textarea>
            </div>
        </div>
    @endif

    {{-- @if (get_cart_setting('country') == 1) --}}
    <!-- Country -->
    @php
        $countries = get_active_countries();
    @endphp
    <div class="row {{ count($countries) == 1 ? 'd-none' : '' }}">
        <div class="col-md-2 mt-md-2">
            <label>{{ translate('Country') }}</label>
        </div>
        <div class="col-md-10">
            <div class="mb-3">
                <select class="form-control aiz-selectpicker rounded-0" data-live-search="true"
                    data-placeholder="{{ translate('Select your country') }}" name="country_id" required>
                    <option value="">{{ translate('Select your country') }}</option>
                    @foreach ($countries as $key => $country)
                        <option value="{{ $country->id }}" {{ count($countries) == 1 ? 'selected' : '' }}>
                            {{ $country->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    {{-- @endif --}}

    @if (get_cart_setting('state') == 1)
        <!-- State -->
        <div class="row">
            <div class="col-md-2 mt-md-2">
                <label>
                    {{ get_zotc_setting('currency') == 'BDT' ? translate('city') : translate('state') }}
                </label>
            </div>
            <div class="col-md-10">
                <select class="form-control mb-3 aiz-selectpicker rounded-0" data-live-search="true" name="state_id"
                    required>

                </select>
            </div>
        </div>
    @endif

    @if (get_cart_setting('city') == 1)
        <!-- City -->
        <div class="row">
            <div class="col-md-2 mt-md-2">
                <label>
                    {{ get_zotc_setting('currency') == 'BDT' ? translate('Thana') : translate('City') }}
                </label>
            </div>
            <div class="col-md-10">
                <select class="form-control mb-3 aiz-selectpicker rounded-0" data-live-search="true" name="city_id"
                    required>

                </select>
            </div>
        </div>
    @endif

    @if (get_setting('google_map') == 1)
        <!-- Google Map -->
        <div class="row mt-3 mb-3">
            <input id="searchInput" class="controls" type="text" placeholder="{{ translate('Enter a location') }}">
            <div id="map"></div>
            <ul id="geoData">
                <li style="display: none;">Full Address: <span id="location"></span></li>
                <li style="display: none;">Postal Code: <span id="postal_code"></span></li>
                <li style="display: none;">Country: <span id="country"></span></li>
                <li style="display: none;">Latitude: <span id="lat"></span></li>
                <li style="display: none;">Longitude: <span id="lon"></span></li>
            </ul>
        </div>
        <!-- Longitude -->
        <div class="row">
            <div class="col-md-2" id="">
                <label for="exampleInputuname">{{ translate('Longitude') }}</label>
            </div>
            <div class="col-md-10" id="">
                <input type="text" class="form-control mb-3 rounded-0" id="longitude" name="longitude"
                    readonly="">
            </div>
        </div>
        <!-- Latitude -->
        <div class="row">
            <div class="col-md-2" id="">
                <label for="exampleInputuname">{{ translate('Latitude') }}</label>
            </div>
            <div class="col-md-10" id="">
                <input type="text" class="form-control mb-3 rounded-0" id="latitude" name="latitude" readonly="">
            </div>
        </div>
    @endif

    @if (get_cart_setting('code') == 1)
        <!-- Postal code -->
        <div class="row">
            <div class="col-md-2 mt-md-2">
                <label>{{ translate('Postal code') }}</label>
            </div>
            <div class="col-md-10">
                <input type="text" class="form-control mb-3 rounded-0"
                    placeholder="{{ translate('Your Postal Code') }}" name="postal_code" value="" required>
            </div>
        </div>
    @endif

    @if (get_cart_setting('email') == 1)
        <div class="row">
            <div class="col-md-2 mt-md-2">
                <label>{{ translate('Email') }}</label>
            </div>
            <div class="col-md-10">
                <input type="email" class="form-control mb-3 rounded-0" placeholder="{{ translate('Your Email') }}"
                    name="email" value="" required>
            </div>
        </div>
    @endif

    @if (get_cart_setting('phone') == 1)
        <style>
            /* Remove default arrow */
            .no-arrow {
                -webkit-appearance: none;
                /* Safari and Chrome */
                -moz-appearance: none;
                /* Firefox */
                appearance: none;
            }
        </style>
        <!-- Phone -->
        <div class="row">
            <div class="col-md-2 mt-md-2">
                <label>{{ translate('Phone') }}</label>
            </div>
            <div class="col-md-1 mr-0 pr-0">
                <select class="form-control rounded-0 border-right-0 no-arrow p-0 text-center" name="country_code"
                    id="">
                    @foreach ($countries as $key => $country)
                        <option value="{{ $country->phonecode }}">{{ $country->phonecode }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-9 ml-0 pl-0">
                <input type="tel" class="form-control rounded-0" placeholder="" name="phone"
                    autocomplete="off" value="">
            </div>
        </div>
    @endif
</div>

{{-- <div class="px-3 pt-3 pb-4 row">
    <div class="col-md-2 mt-md-2"></div>
    <div class="col-md-10">
        <div class="bg-soft-info p-2">
            {{ translate('If you have already used the same mail address or phone number before, please ') }}
            <a href="javascript:void(0);" data-toggle="modal" data-target="#login_modal" class="fw-700 animate-underline-primary">{{ translate('Login') }}</a>
            {{ translate(' first to continue') }}
        </div>
    </div>
</div> --}}

@section('script')
    <script type="text/javascript">
        function submitShippingInfoForm(el) {
            var email = $("input[name='email']").val();
            var phone = $("input[name='country_code']").val() + $("input[name='phone']").val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('guest_customer_info_check') }}",
                type: 'POST',
                data: {
                    email: email,
                    phone: phone
                },
                success: function(response) {
                    if (response == 1) {
                        $('#login_modal').modal();
                        AIZ.plugins.notify('warning',
                            '{{ translate('You already have an account with this information. Please Login first.') }}'
                        );
                    } else {
                        $('#shipping_info_form').submit();
                    }
                }
            });
        }

        $(document).ready(function() {
            var country_id = $('[name=country_id]').val();
            get_states(country_id);

            var state_show = {{ get_cart_setting('state') }};

            if (state_show == 0) {
                get_city();
            }
        });

        $(document).on('change', '[name=country_id]', function() {
            var country_id = $(this).val();
            get_states(country_id);
        });

        $(document).on('change', '[name=state_id]', function() {
            var state_id = $(this).val();

            var shipping_type = "{{ get_setting('shipping_type') }}";

            if (shipping_type == "state_wise_shipping") {
                updateStateShippingCost(state_id);
            }

            var city_show = {{ get_cart_setting('city') }};

            if (city_show == 1) {
                get_city(state_id);
            }
        });

        $(document).on('change', '[name=city_id]', function() {
            var city_id = $(this).val();

            var shipping_type = "{{ get_setting('shipping_type') }}";

            if (shipping_type == "area_wise_shipping") {
                updateCityShippingCost(city_id);
            }
        });

        function get_states(country_id) {
            $('[name="state"]').html("");
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('get-state') }}",
                type: 'POST',
                data: {
                    country_id: country_id
                },
                success: function(response) {
                    var obj = JSON.parse(response);
                    if (obj != '') {
                        $('[name="state_id"]').html(obj);
                        AIZ.plugins.bootstrapSelect('refresh');
                    }
                }
            });
        }

        function get_city(state_id) {
            $('[name="city"]').html("");
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('get-city') }}",
                type: 'POST',
                data: {
                    state_id: state_id
                },
                success: function(response) {
                    var obj = JSON.parse(response);
                    if (obj != '') {
                        $('[name="city_id"]').html(obj);
                        AIZ.plugins.bootstrapSelect('refresh');
                    }
                }
            });
        }

        function updateStateShippingCost(state_id) {
            $.ajax({
                url: '/updateStateShippingCost/' + state_id,
                type: 'GET',
                success: function(response) {
                    if (response.status === 'success') {
                        // AIZ.plugins.notify('success', response.message);
                        // window.location.reload();
                        $('#shipping').val(response.cost);
                        $('#shipping_text').text(response.shipping_cost);
                        calculateTotal();
                    } else {
                        AIZ.plugins.notify('danger', '{{ translate('Failed to add shipping to cart') }}');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        function updateCityShippingCost(city_id) {
            $.ajax({
                url: '/updateCityShippingCost/' + city_id,
                type: 'GET',
                success: function(response) {
                    if (response.status === 'success') {
                        // AIZ.plugins.notify('success', response.message);
                        // window.location.reload();
                        $('#shipping').val(response.cost);
                        $('#shipping_text').text(response.shipping_cost);
                        calculateTotal();
                    } else {
                        AIZ.plugins.notify('danger', '{{ translate('Failed to add shipping to cart') }}');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        function calculateTotal() {
            var shipping = parseFloat($('#shipping').val());
            var subtotal = 0;

            $('.product_total').each(function() {
                var product_total = parseFloat($(this).val());
                subtotal += isNaN(product_total) ? 0 : product_total;
            });

            var total = shipping + subtotal;

            $.ajax({
                url: '/calculate-price/' + subtotal,
                type: 'GET',
                success: function(response) {
                    $('#subtotal').text(response);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });

            $.ajax({
                url: '/calculate-price/' + total,
                type: 'GET',
                success: function(response) {
                    $('#total').text(response);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        var isPhoneShown = true,
            countryData = window.intlTelInputGlobals.getCountryData(),
            input = document.querySelector("#phone-code");

        for (var i = 0; i < countryData.length; i++) {
            var country = countryData[i];
            if (country.iso2 == 'bd') {
                country.dialCode = '88';
            }
        }

        var iti = intlTelInput(input, {
            separateDialCode: true,
            utilsScript: "{{ static_asset('assets/js/intlTelutils.js') }}?1590403638580",
            onlyCountries: @php
                echo json_encode(\App\Models\Country::where('status', 1)->pluck('code')->toArray());
            @endphp,
            customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
                if (selectedCountryData.iso2 == 'bd') {
                    return "01xxxxxxxxx";
                }
                return selectedCountryPlaceholder;
            }
        });

        var country = iti.getSelectedCountryData();
        $('input[name=country_code]').val(country.dialCode);

        input.addEventListener("countrychange", function(e) {
            // var currentMask = e.currentTarget.placeholder;

            var country = iti.getSelectedCountryData();
            $('input[name=country_code]').val(country.dialCode);

        });
    </script>


    @if (get_setting('google_map') == 1)
        @include('frontend.' . get_setting('homepage_select') . '.partials.google_map')
    @endif
@endsection
