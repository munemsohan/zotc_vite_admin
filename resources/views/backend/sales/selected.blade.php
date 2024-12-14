@extends('backend.layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <button class="btn btn-danger mb-2 float-right" id="send_all">Send All Couriers</button>
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>{{ translate('Order Code') }}</th>
                        <th data-breakpoints="md">{{ translate('Np') }}</th>
                        <th data-breakpoints="md">{{ translate('Customer') }}</th>
                        <th data-breakpoints="md">{{ translate('Amount') }}</th>
                        <th data-breakpoints="md">{{ translate('Status') }}</th>
                        @if (addon_is_activated('refund_request'))
                            <th>{{ translate('Refund') }}</th>
                        @endif
                        <th data-breakpoints="md">{{ translate('Couriers') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $key => $order)
                        <input type="hidden" id="exist_city_{{ $order->id }}" value="{{ $order->city }}">
                        <input type="hidden" id="exist_zone_{{ $order->id }}" value="{{ $order->zone }}">
                        <input type="hidden" id="exist_area_{{ $order->id }}" value="{{ $order->area }}">

                        <tr class="order_row" data-orderid="{{ $order->id }}" data-carrierid="{{ $order->carrier_id }}">
                            <td>
                                {{ $order->code }}
                                @if ($order->viewed == 0)
                                    <span class="badge badge-inline badge-info">{{ translate('New') }}</span>
                                @endif
                                @if (addon_is_activated('pos_system') && $order->order_from == 'pos')
                                    <span class="badge badge-inline badge-danger">{{ translate('POS') }}</span>
                                @endif
                            </td>
                            <td>
                                {{ count($order->orderDetails) }}
                            </td>
                            <td>
                                @if ($order->user != null)
                                    {{ $order->user->name }}
                                @else
                                    Guest ({{ $order->guest_id }})
                                @endif
                            </td>
                            <td>
                                {{ single_price($order->grand_total) }}
                                <br>
                                @if ($order->payment_status == 'paid')
                                    <span class="badge badge-inline badge-success">{{ translate('Paid') }}</span>
                                @else
                                    <span class="badge badge-inline badge-danger">{{ translate('Unpaid') }}</span>
                                @endif
                            </td>
                            <td>
                                {{ translate(ucfirst(str_replace('_', ' ', $order->delivery_status))) }}
                                <br>
                                {{ translate(ucfirst(str_replace('_', ' ', $order->payment_type))) }}
                            </td>

                            @if (addon_is_activated('refund_request'))
                                <td>
                                    @if (count($order->refund_requests) > 0)
                                        {{ count($order->refund_requests) }} {{ translate('Refund') }}
                                    @else
                                        {{ translate('No Refund') }}
                                    @endif
                                </td>
                            @endif
                            <td>
                                <select class="form-control carrier_select" data-orderid="{{ $order->id }}"
                                    name="carrier" id="carrier_{{ $order->id }}">
                                    <option value="">Select</option>
                                    @foreach ($carriers as $carrier)
                                        <option value="{{ $carrier->id }}"
                                            {{ $carrier->id == $order->carrier_id ? 'selected' : '' }}>
                                            {{ $carrier->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        @if (!$order->tracking_code)
                            <tr>
                                <td colspan="7">
                                    <div class="row gutters-5 mb-2 py-1 my-1">
                                        <input type="hidden" name="order_id" value="{{ $order->id }}">

                                        <div class="col-md-2" style="display: none"
                                            id="pathao_city_select_{{ $order->id }}">
                                            <label>{{ translate('Select City') }}</label>
                                            <select class="form-control pathao_city" data-orderid="{{ $order->id }}"
                                                id="pathao_city_{{ $order->id }}" name="city_id">
                                                <option value="">{{ translate('Select City') }}</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2" style="display: none"
                                            id="pathao_zone_select_{{ $order->id }}">
                                            <label>{{ translate('Select Zone') }}</label>
                                            <select class="form-control pathao_zone" data-orderid="{{ $order->id }}"
                                                id="pathao_zone_{{ $order->id }}" name="zone_id"></select>
                                        </div>
                                        <div class="col-md-2" style="display: none"
                                            id="pathao_area_select_{{ $order->id }}">
                                            <label>{{ translate('Select Area') }}</label>
                                            <select class="form-control pathao_area" data-orderid="{{ $order->id }}"
                                                id="pathao_area_{{ $order->id }}" name="area_id"></select>
                                        </div>
                                        <div class="col-md-2">
                                            <label>{{ translate('Address') }}</label>
                                            <textarea class="form-control" name="address" id="address_{{ $order->id }}" cols="30" rows="1"
                                                oninput="saveOrderAddress()">{{ json_decode($order->shipping_address)->address }}</textarea>
                                        </div>
                                        <div class="col-md-2" style="display: none"
                                            id="pathao_pickup_select_{{ $order->id }}">
                                            <label>{{ translate('Pickup Type') }}</label>
                                            <select class="form-control" id="delivery_type_{{ $order->id }}"
                                                name="delivery_type">
                                                <option value="48">Normal Delivery</option>
                                                <option value="12">On Demand Delivery</option>
                                            </select>
                                        </div>

                                        <div class="col-md-2 text-end">
                                            <button type="submit" class="btn btn-success mt-4 carrier_submit"
                                                id="send_to_carrier_{{ $order->id }}"
                                                data-orderid="{{ $order->id }}"
                                                style="display: {{ $order->carrier_id ? 'block' : 'none' }}">Send To
                                                Courier</button>
                                        </div>
                                    </div>

                                </td>

                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.order_row').each(function() {
                var order_id = $(this).data('orderid');
                var carrier = $(this).data('carrierid');

                if (carrier == '1') {
                    fetchPathaoCities(order_id);
                    $('#pathao_city_select_' + order_id).show();
                    $('#pathao_zone_select_' + order_id).show();
                    $('#pathao_area_select_' + order_id).show();
                    $('#pathao_pickup_select_' + order_id).show();
                } else if (carrier == '2') {
                    fetchPathaoCities(order_id);
                    $('#pathao_city_select_' + order_id).show();
                    $('#pathao_zone_select_' + order_id).hide();
                    $('#pathao_area_select_' + order_id).hide();
                    $('#pathao_pickup_select_' + order_id).hide();
                }
            });

            // Function to save Pathao info
            function saveOrderInfo(order_id, city, zone, area) {
                $.ajax({
                    url: "{{ route('save.carrier.info') }}",
                    method: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        order_id: order_id,
                        city: city,
                        zone: zone,
                        area: area
                    },
                    success: function(response) {
                        // Handle success if needed
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }

            // Function to fetch cities based on carrier change
            function fetchPathaoCities(order_id) {
                $.ajax({
                    url: "{{ route('pathao.cities') }}",
                    method: "GET",
                    success: function(response) {
                        $('#pathao_city_' + order_id).empty();
                        $.each(response, function(index, city) {
                            $('#pathao_city_' + order_id).append('<option value="' + city[
                                    'city_id'] + '">' +
                                city['city_name'] + '</option>');

                            var exist_city = $('#exist_city_' + order_id).val();
                            if (city['city_name'] == exist_city) {
                                $('#pathao_city_' + order_id).val(city['city_id']);
                            }
                        });

                        fetchPathaoZones($('#pathao_city_' + order_id).val(), order_id);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }

            // Function to fetch zones based on city id
            function fetchPathaoZones(cityId, order_id) {
                $.ajax({
                    url: "{{ route('pathao.zones') }}",
                    method: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        city_id: cityId
                    },
                    success: function(response) {
                        $('#pathao_zone_' + order_id).empty();
                        $.each(response, function(index, zone) {
                            $('#pathao_zone_' + order_id).append('<option value="' + zone[
                                    'zone_id'] +
                                '">' +
                                zone['zone_name'] + '</option>');

                            var exist_zone = $('#exist_zone_' + order_id).val();
                            if (zone['zone_name'] == exist_zone) {
                                $('#pathao_zone_' + order_id).val(zone['zone_id']);
                            }
                        });

                        // After fetching zones, trigger fetching areas based on the first zone
                        fetchPathaoAreas($('#pathao_zone_' + order_id).val(), order_id);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }

            // Function to fetch areas based on zone id
            function fetchPathaoAreas(zoneId, order_id) {
                $.ajax({
                    url: "{{ route('pathao.areas') }}",
                    method: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        zone_id: zoneId
                    },
                    success: function(response) {
                        $('#pathao_area_' + order_id).empty();
                        $.each(response, function(index, area) {
                            $('#pathao_area_' + order_id).append('<option value="' + area[
                                    'area_id'] +
                                '">' +
                                area['area_name'] + '</option>');

                            var exist_area = $('#exist_area_' + order_id).val();
                            if (area['area_name'] == exist_area) {
                                $('#pathao_area_' + order_id).val(area['area_id']);
                            }
                        });

                        var city = $('#pathao_city_' + order_id + ' option:selected').text();
                        var zone = $('#pathao_zone_' + order_id + ' option:selected').text();
                        var area = $('#pathao_area_' + order_id + ' option:selected').text();
                        saveOrderInfo(order_id, city, zone, area);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }

            // On city change, fetch zones and reset areas
            $('.pathao_city').on('change', function() {
                var order_id = $(this).data('orderid');
                fetchPathaoZones($(this).val(), order_id);
            });

            // On zone change, fetch areas
            $('.pathao_zone').on('change', function() {
                var order_id = $(this).data('orderid');
                fetchPathaoAreas($(this).val(), $(this).data('orderid'));
            });

            $('.pathao_area').on('change', function() {
                var order_id = $(this).data('orderid');
                var city = $('#pathao_city_' + order_id + ' option:selected').text();
                var zone = $('#pathao_zone_' + order_id + ' option:selected').text();
                var area = $('#pathao_area_' + order_id + ' option:selected').text();
                saveOrderInfo(order_id, city, zone, area);
            });

            // Event handler for carrier selection change
            $('.carrier_select').on('change', function() {
                var order_id = $(this).data('orderid');
                var carrier = $(this).val();

                // Prepare data for AJAX request
                var requestData = {
                    _token: '{{ csrf_token() }}',
                    order_id: order_id,
                    carrier: carrier
                };

                // Update carrier via AJAX
                $.post('{{ route('orders.update_carrier') }}', requestData, function(data) {

                    // Hide all related divs by default
                    $('#pathao_city_select_' + order_id + ', #pathao_zone_select_' + order_id +
                        ', #pathao_area_select_' + order_id + ', #pathao_pickup_select_' +
                        order_id).hide();

                    // Show specific divs based on carrier selection
                    if (carrier == 1 || carrier == 2) {
                        fetchPathaoCities(order_id);
                        $('#pathao_city_select_' + order_id + ', #send_to_carrier_' + order_id)
                            .show();

                        // Show or hide additional elements based on carrier selection
                        if (carrier == 1) {
                            $('#pathao_zone_select_' + order_id + ', #pathao_area_select_' +
                                order_id + ', #pathao_pickup_select_' + order_id).show();
                        } else {
                            $('#pathao_zone_select_' + order_id + ', #pathao_area_select_' +
                                order_id + ', #pathao_pickup_select_' + order_id).hide();
                        }
                    } else if (carrier == 3) {
                        $('#send_to_carrier_' + order_id).show();
                    } else {
                        $('#send_to_carrier_' + order_id).hide();
                    }
                }).fail(function(xhr, status, error) {
                    // Handle AJAX error
                    console.error(xhr.responseText);
                    // Notify failure
                    AIZ.plugins.notify('danger',
                        '{{ translate('An error occurred while updating Order Carrier') }}');
                });
            });
        });


        $('#send_all').on('click', function() {
            var $sendAllButton = $(this);
            $sendAllButton.prop('disabled', true);

            // Trigger click event for carrier_submit buttons that are not hidden and not disabled
            $('.carrier_submit').not(':hidden,:disabled').trigger('click');
        });

        $('.carrier_submit').on('click', function() {
            var $submitButton = $(this);
            $submitButton.prop('disabled', true).html('Processing');

            var order_id = $submitButton.data('orderid');
            var city_id = $('#pathao_city_' + order_id).val();
            var zone_id = $('#pathao_zone_' + order_id).val();
            var area_id = $('#pathao_area_' + order_id).val();
            var delivery_type = $('#delivery_type_' + order_id).val();

            var $this = $(this);

            $.ajax({
                url: '{{ route('carrier.send.request') }}',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    _token: '{{ csrf_token() }}',
                    order_id: order_id,
                    city_id: city_id,
                    zone_id: zone_id,
                    area_id: area_id,
                    delivery_type: delivery_type,
                }),
                success: function(data) {
                    if (data.success) {
                        AIZ.plugins.notify('success', data.message);
                        $this.html('Success').prop('disabled', true);
                    } else {
                        AIZ.plugins.notify('danger', data.message);
                        $this.prop('disabled', false).html('Try Again').removeClass('btn-success')
                            .addClass(
                                'btn-danger');
                    }
                },
                error: function(xhr, status, error) {
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        AIZ.plugins.notify('danger', xhr.responseJSON.message);
                    } else {
                        AIZ.plugins.notify('danger', 'An error occurred while sending the request.');
                    }
                    $this.prop('disabled', false).html('Try Again').removeClass('btn-success').addClass(
                        'btn-danger');
                }
            });
        });
    </script>
@endsection
