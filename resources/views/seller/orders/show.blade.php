@extends('backend.layouts.app')

@section('content')
    {{-- <style>
        .carrier_select {
            border: 1px solid #8b8b8b;
        }

        .carrier_select:hover {
            border: 2px solid #b11b00;
        }

        .carrier_select:focus {
            border: 2px solid #19c553;
        }
    </style> --}}

    @php
        $countries = get_active_countries();
        $shippingAddress = json_decode($order->shipping_address);
        $currentState = isset($shippingAddress->state) ? $shippingAddress->state : '';
        $currentCity = isset($shippingAddress->city) ? $shippingAddress->city : '';
    @endphp

    <div class="card">
        <div class="card-header">
            <h1 class="h2 fs-16 mb-0">{{ translate('Order Details') }}</h1>

            <div>
                <a href="{{ route('invoice.download', $order->id) }}" type="button"
                    class="btn btn-sm btn-icon btn-light mr-2">
                    <i class="las la-print fs-16"></i>
                </a>
                <a href="{{ url('admin/orders/editing/save/' . $order->id) }}" class="btn btn-primary btn-sm">Back To All
                    Orders</a>
            </div>
        </div>
        <div class="card-body">

            <div class="row gutters-5">
                {{-- <div class="col text-md-left text-center">
                </div> --}}
                @php
                    $delivery_status = $order->delivery_status;
                    $payment_status = $order->payment_status;
                    $admin_user_id = App\Models\User::where('user_type', 'admin')->first()->id;
                @endphp

                <div class="col-md-2 {{ count($countries) > 1 ? '' : 'd-none' }}">
                    <label>{{ translate('Country') }}</label>
                    <select class="form-control aiz-selectpicker rounded-0" data-live-search="true"
                        data-placeholder="{{ translate('Select your country') }}" name="country_id" required>
                        @if (count($countries) > 1)
                            <option value="">{{ translate('Select your country') }}</option>
                        @endif

                        @foreach ($countries as $key => $country)
                            <option value="{{ $country->id }}"
                                {{ $order->shipping_address && optional($shippingAddress)->country == $country->name ? 'selected' : '' }}>
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label>{{ translate('State/District') }}</label>
                    <select class="form-control mb-3 aiz-selectpicker rounded-0" data-live-search="true" name="state_id"
                        required>

                    </select>
                </div>

                <div class="col-md-2">
                    <label>{{ translate('City/Upazilla') }}</label>
                    <select class="form-control mb-3 aiz-selectpicker rounded-0" data-live-search="true" name="city_id"
                        required>

                    </select>
                </div>

                <div class="col-md-2">
                    <label>{{ translate('Postal Code') }}</label>
                    <input class="form-control" type="text" name="postal_code" id="postal_code"
                        value="{{ $order->shipping_address ? $shippingAddress->postal_code ?? '' : '' }}"
                        oninput="saveOrderAddress()">
                </div>

                <!--Assign Delivery Boy-->
                @if ($order->seller_id == $admin_user_id || get_business_setting('product_manage_by_admin') == 1)

                    {{-- <div class="col-md-3"></div> --}}

                    @if (addon_is_activated('delivery_boy'))
                        <div class="col-md-2">
                            <label for="assign_deliver_boy">{{ translate('Assign Deliver Boy') }}</label>
                            @if (
                                ($delivery_status == 'pending' || $delivery_status == 'confirmed' || $delivery_status == 'picked_up') &&
                                    auth()->user()->can('assign_delivery_boy_for_orders'))
                                <select class="form-control aiz-selectpicker" data-live-search="true"
                                    data-minimum-results-for-search="Infinity" id="assign_deliver_boy">
                                    <option value="">{{ translate('Select Delivery Boy') }}</option>
                                    @if (!empty($delivery_boys))
                                        @foreach ($delivery_boys as $delivery_boy)
                                            <option value="{{ $delivery_boy->id }}"
                                                @if ($order->assign_delivery_boy == $delivery_boy->id) selected @endif>
                                                {{ $delivery_boy->name }}
                                            </option>
                                        @endforeach
                                    @endif

                                </select>
                            @else
                                <input type="text" class="form-control"
                                    value="{{ optional($order->delivery_boy)->name }}" disabled>
                            @endif
                        </div>
                    @endif

                    <div class="col-md-2">
                        <label for="update_payment_status">{{ translate('Payment Status') }}</label>
                        @if (auth()->user()->can('update_order_payment_status'))
                            <select class="form-control aiz-selectpicker" data-minimum-results-for-search="Infinity"
                                id="update_payment_status">
                                <option value="unpaid" @if ($payment_status == 'unpaid') selected @endif>
                                    {{ translate('Unpaid') }}
                                </option>
                                <option value="partial" @if ($payment_status == 'partial') selected @endif>
                                    {{ translate('Partial') }}
                                </option>
                                <option value="paid" @if ($payment_status == 'paid') selected @endif>
                                    {{ translate('Paid') }}
                                </option>
                            </select>
                        @else
                            <input type="text" class="form-control" value="{{ $payment_status }}" disabled>
                        @endif
                    </div>
                    <div class="col-md-2">
                        <label for="update_delivery_status">{{ translate('Delivery Status') }}</label>
                        @if (auth()->user()->can('update_order_delivery_status') &&
                                $delivery_status != 'delivered' &&
                                $delivery_status != 'cancelled')
                            <select class="form-control aiz-selectpicker" data-minimum-results-for-search="Infinity"
                                id="update_delivery_status">
                                <option value="pending" @if ($delivery_status == 'pending') selected @endif>
                                    {{ translate('Pending') }}
                                </option>
                                <option value="carrier_pending" @if ($delivery_status == 'carrier_pending') selected @endif>
                                    {{ translate('Courier Pending') }}
                                </option>
                                <option value="on_hold" @if ($delivery_status == 'on_hold') selected @endif>
                                    {{ translate('On Hold') }}
                                </option>
                                <option value="approved" @if ($delivery_status == 'approved') selected @endif>
                                    {{ translate('Approved') }}
                                </option>
                                <option value="processing" @if ($delivery_status == 'processing') selected @endif>
                                    {{ translate('Processing') }}
                                </option>
                                <option value="shipped" @if ($delivery_status == 'shipped') selected @endif>
                                    {{ translate('Shipped') }}
                                </option>
                                <option value="in_transit" @if ($delivery_status == 'in_transit') selected @endif>
                                    {{ translate('In-Transit') }}
                                </option>
                                <option value="delivered" @if ($delivery_status == 'delivered') selected @endif>
                                    {{ translate('Delivered') }}
                                </option>
                                <option value="confirmed" @if ($delivery_status == 'confirmed') selected @endif>
                                    {{ translate('Confirmed') }}
                                </option>
                                <option value="picked_up" @if ($delivery_status == 'picked_up') selected @endif>
                                    {{ translate('Picked Up') }}
                                </option>
                                <option value="on_the_way" @if ($delivery_status == 'on_the_way') selected @endif>
                                    {{ translate('On The Way') }}
                                </option>
                                <option value="delivered" @if ($delivery_status == 'delivered') selected @endif>
                                    {{ translate('Delivered') }}
                                </option>
                                <option value="cancelled" @if ($delivery_status == 'cancelled') selected @endif>
                                    {{ translate('Cancel') }}
                                </option>
                            </select>
                        @else
                            <input type="text" class="form-control" value="{{ $delivery_status }}" disabled>
                        @endif
                    </div>
                    <div class="col-md-2">
                        <label for="update_tracking_code">
                            {{ translate('Tracking Code (optional)') }}
                        </label>
                        <input type="text" class="form-control" id="update_tracking_code"
                            value="{{ $order->tracking_code }}">
                    </div>
                    <div class="col-md-2">
                        <label>
                            {{ translate('Courier') }}
                        </label>
                        <select class="form-control" name="carrier" id="carrier">
                            <option value="">Select</option>
                            @foreach ($carriers as $carrier)
                                <option value="{{ $carrier->id }}"
                                    {{ $carrier->id == $order->carrier_id ? 'selected' : '' }}>
                                    {{ $carrier->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>

            @if (!$order->tracking_code)
                <form id="send-to-courier-form" method="POST">
                    <div class="row gutters-5 mb-2 py-1 my-1">
                        {{-- pathao div --}}
                        <div class="col-md-2" style="display: none" id="pathao_city_select">
                            <label>{{ translate('Select Pathao/Steadfast City') }}</label>
                            <select class="form-control h-40px" id="pathao_city" name="pathao_city_id">
                                <option value="">{{ translate('Select City') }}</option>
                            </select>
                        </div>
                        <div class="col-md-2" style="display: none" id="pathao_zone_select">
                            <label>{{ translate('Select Pathao Zone') }}</label>
                            <select class="form-control h-40px" id="pathao_zone" name="pathao_zone_id"></select>
                        </div>
                        <div class="col-md-2" style="display: none" id="pathao_area_select">
                            <label>{{ translate('Select Pathao Area') }}</label>
                            <select class="form-control h-40px" id="pathao_area" name="pathao_area_id"></select>
                        </div>
                        <div class="col-md-2" style="display: none" id="pathao_pickup_select">
                            <label>{{ translate('Pathao Pickup Type') }}</label>
                            <select class="form-control h-40px" id="pathao_delivery_type" name="pathao_delivery_type">
                                <option value="48">Normal Delivery</option>
                                <option value="12">On Demand Delivery</option>
                            </select>
                        </div>
                        {{-- end pathao div --}}

                        {{-- redx div --}}
                        <div class="col-md-2" style="display: none" id="redx_city_select">
                            <label>{{ translate('Select Redx City') }}</label>
                            <select class="form-control h-40px" id="redx_city">
                                <option value="">{{ translate('Select City') }}</option>
                            </select>
                        </div>
                        <div class="col-md-2" style="display: none" id="redx_area_select">
                            <label>{{ translate('Select Redx Area') }}</label>
                            <select class="form-control h-40px" id="redx_area" name="redx_area_id"></select>
                        </div>
                        {{-- end redx div --}}

                        <div class="col-md-2">
                            <label>{{ translate('Address') }}</label>
                            <textarea class="form-control" name="address" id="address" cols="30" rows="1"
                                oninput="saveOrderAddress()">{{ $order->shipping_address ? optional($shippingAddress)->address : '' }}</textarea>
                        </div>
                        <div class="col-md-2 text-end">
                            <button type="submit" class="btn btn-block btn-success mt-4" id="send-to-courier"
                                style="display: {{ $order->carrier_id ? 'block' : 'none' }}">
                                {{ translate('Send To Courier') }}
                            </button>
                        </div>
                    </div>
                </form>
            @endif

            <div class="row gutters-5 mt-5">
                <div class="col-md-3 text-md-left text-center">
                    @if ($shippingAddress)
                        <address>
                            <strong class="text-main">
                                {{ $shippingAddress->name ?? '' }}
                            </strong><br>
                            {{ $shippingAddress->email ?? '' }}<br>
                            {{ $shippingAddress->phone ?? '' }}<br>
                            {{ $shippingAddress->address ?? '' }},
                            {{ $shippingAddress->city ?? '' }},
                            @if (!empty($shippingAddress->state))
                                {{ $shippingAddress->state }} -
                            @endif
                            {{ $shippingAddress->postal_code ?? '' }}<br>
                            {{ $shippingAddress->country ?? '' }}
                        </address>
                    @else
                        @if ($order->user)
                            <address>
                                <strong class="text-main">
                                    {{ $order->user->name }}
                                </strong><br>
                                {{ $order->user->email }}<br>
                                {{ $order->user->phone }}<br>
                            </address>
                        @else
                            <address>
                                <strong class="text-main">
                                    Walk-in Customer
                                </strong><br>
                            </address>
                        @endif
                    @endif

                    @if ($order->manual_payment && is_array(json_decode($order->manual_payment_data, true)))
                        <br>
                        <strong class="text-main">{{ translate('Payment Information') }}</strong><br>
                        {{ translate('Name') }}: {{ json_decode($order->manual_payment_data)->name }},
                        {{ translate('Amount') }}:
                        {{ single_price(json_decode($order->manual_payment_data)->amount) }},
                        {{ translate('TRX ID') }}: {{ json_decode($order->manual_payment_data)->trx_id }}
                        <br>
                        @if ($order->manual_payment_data)
                            <a href="{{ uploaded_asset(json_decode($order->manual_payment_data)->photo) }}"
                                target="_blank">
                                <img src="{{ uploaded_asset(json_decode($order->manual_payment_data)->photo) }}"
                                    alt="" height="100">
                            </a>
                        @endif
                    @endif
                    @if ($order->delivery_status == 'carrier_pending')
                        @if ($order->carrier_id == 1)
                            <p>
                                <span>Courier: <b>{{ $order->carrier->name }}</b>,
                                    Consignment ID: <a
                                        href="https://merchant.pathao.com/tracking?consignment_id={{ $order->tracking_code }}"
                                        target="_blank" class="fw-bold">{{ $order->tracking_code }}</a></span>
                            </p>
                        @elseif ($order->carrier_id == 2)
                            @php
                                $trackingInfo = explode('-', $order->tracking_code);
                                $consignmentId = $trackingInfo[0];
                                $trackingId = $trackingInfo[1] ?? '';
                            @endphp
                            <p>
                                <span>Courier: <b>{{ $order->carrier->name }}</b>,
                                    Consignment ID: <b>{{ $consignmentId }}</b>,
                                    Tracking ID: <a href="https://steadfast.com.bd/t/{{ $trackingId }}" target="_blank"
                                        class="fw-bold">{{ $trackingId }}</a></span>
                            </p>
                        @endif
                    @endif

                </div>

                <div class="col-md-4">
                    <table class="table table-sm text-center table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Courier</th>
                                <th>Total</th>
                                <th>Delivered</th>
                                <th>Returned</th>
                                <th>Success Ratio</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                // Example response
                                $allFraudCheck = $order->fraud_status;
                                $courierDataArray = explode(';', $allFraudCheck);
                                $couriers = [];
                                $total_parcels = 0;
                                $delivered_parcels = 0;
                                $canceled_parcels = 0;

                                foreach ($courierDataArray as $courierData) {
                                    [$courier, $data] = explode(':', $courierData);
                                    [$total, $delivered, $canceled] = explode(',', $data);

                                    $couriers[$courier] = [
                                        'total' => (int) $total,
                                        'delivered' => (int) $delivered,
                                        'canceled' => (int) $canceled,
                                    ];

                                    if ($courier !== 'Total') {
                                        $total_parcels += (int) $total;
                                        $delivered_parcels += (int) $delivered;
                                        $canceled_parcels += (int) $canceled;
                                    }
                                }

                                $total_success_percentage =
                                    $total_parcels > 0 ? ($delivered_parcels / $total_parcels) * 100 : 0;
                            @endphp

                            @foreach ($couriers as $courier => $data)
                                @if ($courier !== 'Total')
                                    @php
                                        $total = $data['total'];
                                        $delivered = $data['delivered'];
                                        $canceled = $data['canceled'];
                                        $success_percentage = $total > 0 ? ($delivered / $total) * 100 : 0;
                                    @endphp
                                    <tr>
                                        <td>{{ $courier }}</td>
                                        <td>{{ $total }}</td>
                                        <td>{{ $delivered }}</td>
                                        <td>{{ $canceled }}</td>
                                        <td>{{ number_format($success_percentage, 2) }}%</td>
                                    </tr>
                                @endif
                            @endforeach

                            <tr>
                                <td><strong>Total</strong></td>
                                <td><strong>{{ $total_parcels }}</strong></td>
                                <td><strong>{{ $delivered_parcels }}</strong></td>
                                <td><strong>{{ $canceled_parcels }}</strong></td>
                                <td><strong>{{ number_format($total_success_percentage, 2) }}%</strong></td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <div class="progress mb-2">
                                        <div class="progress-bar bg-success" role="progressbar"
                                            style="width: {{ $total_success_percentage }}%"
                                            aria-valuenow="{{ $total_success_percentage }}" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                        <div class="progress-bar bg-danger" role="progressbar"
                                            style="width: {{ 100 - $total_success_percentage }}%"
                                            aria-valuenow="{{ 100 - $total_success_percentage }}" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                    <p class="mb-0 text-center">{{ (int) $total_success_percentage }}% Delivered</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-2">
                    <div class="table-responsive">
                        @php
                            $user_orders = \App\Models\Order::where('user_id', $order->user_id);

                            $all_orders = $user_orders->count();
                            $cancelled_orders = $user_orders->where('payment_status', 'cancelled')->count();

                            // Calculate the number of non-cancelled orders
                            $non_cancelled_orders = $all_orders - $cancelled_orders;
                            $percentage = $all_orders > 0 ? ($non_cancelled_orders / $all_orders) * 100 : 0;

                            // Adjusted percentage for the bg-success part
                            $success_percentage = max(0, min($percentage, 100));
                            // Remaining percentage for the bg-danger part
                            $danger_percentage = 100 - $success_percentage;
                        @endphp
                        <table class="table table-sm text-center table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Customer History</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <p><strong>Total Orders:</strong> {{ $all_orders }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p><strong>Total Delivered:</strong> {{ $non_cancelled_orders }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p><strong>Total Canceled:</strong> {{ $cancelled_orders }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="progress mb-2">
                                            <div class="progress-bar bg-success" role="progressbar"
                                                style="width: {{ $success_percentage }}%"
                                                aria-valuenow="{{ $success_percentage }}" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                            <div class="progress-bar bg-danger" role="progressbar"
                                                style="width: {{ $danger_percentage }}%"
                                                aria-valuenow="{{ $danger_percentage }}" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                        <p class="mb-0 text-center">{{ (int) $success_percentage }}% Delivered</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>


                </div>
                <div class="col-md-3">
                    <div class="d-flex justify-content-end">
                        {!! DNS1D::getBarcodeHTML($order->code, 'C128') !!}
                    </div>
                    <div class="d-flex justify-content-end">
                        <table>
                            <tbody>
                                <tr>
                                    <td class="text-main text-bold">{{ translate('Order #') }}</td>
                                    <td class="text-info text-bold text-right"> {{ $order->code }}</td>
                                </tr>
                                <tr>
                                    <td class="text-main text-bold">{{ translate('Order Status') }}</td>
                                    <td class="text-right">
                                        @if ($delivery_status == 'delivered')
                                            <span class="badge badge-inline badge-success">
                                                {{ translate(ucfirst(str_replace('_', ' ', $delivery_status))) }}
                                            </span>
                                        @else
                                            <span class="badge badge-inline badge-info">
                                                {{ translate(ucfirst(str_replace('_', ' ', $delivery_status))) }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-main text-bold">{{ translate('Order Date') }} </td>
                                    <td class="text-right">{{ date('d-m-Y h:i A', $order->date) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-main text-bold">
                                        {{ translate('Total amount') }}
                                    </td>
                                    <td class="text-right">
                                        {{ single_price($order->grand_total) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-main text-bold">{{ translate('Payment method') }}</td>
                                    <td class="text-right">
                                        {{ translate(ucfirst(str_replace('_', ' ', $order->payment_type))) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-main text-bold">{{ translate('Additional Info') }}</td>
                                    <td class="text-right">{{ $order->additional_info }}</td>
                                </tr>
                                @if (addon_is_activated('refund_request'))
                                    <tr>
                                        <td class="text-main text-bold">{{ translate('Refund') }}</td>
                                        <td class="text-right">
                                            @if (count($order->refund_requests) > 0)
                                                {{ count($order->refund_requests) }} {{ translate('Refund') }}
                                            @else
                                                {{ translate('No Refund') }}
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <hr class="new-section-sm bord-no">
            <div class="row">
                <div class="col-lg-12 table-responsive">
                    <table class="table-bordered aiz-table invoice-summary table text-center">
                        <thead>
                            <tr class="bg-trans-dark">
                                <th data-breakpoints="lg" class="min-col center">#</th>
                                <th width="10%">{{ translate('Photo') }}</th>
                                <th class="text-uppercase">{{ translate('Description') }}</th>
                                <th data-breakpoints="lg" class="text-uppercase">{{ translate('Delivery Type') }}</th>
                                <th data-breakpoints="lg" class="min-col text-uppercase" width="10%">
                                    {{ translate('Qty') }}
                                </th>
                                <th width="20%" data-breakpoints="lg" class="min-col text-uppercase">
                                    {{ translate('Price') }}</th>
                                <th width="20%" data-breakpoints="lg" class="min-col text-uppercase">
                                    {{ translate('Total') }}</th>
                                <th data-breakpoints="lg" class="min-col text-uppercase">
                                    #
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->orderDetails as $key => $orderDetail)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        @if ($orderDetail->product != null && $orderDetail->product->auction_product == 0)
                                            <a href="{{ route('product', $orderDetail->product->slug) }}"
                                                target="_blank">
                                                <img height="50"
                                                    src="{{ uploaded_asset($orderDetail->product->thumbnail_img) }}">
                                            </a>
                                        @elseif ($orderDetail->product != null && $orderDetail->product->auction_product == 1)
                                            <a href="{{ route('auction-product', $orderDetail->product->slug) }}"
                                                target="_blank">
                                                <img height="50"
                                                    src="{{ uploaded_asset($orderDetail->product->thumbnail_img) }}">
                                            </a>
                                        @else
                                            <strong>{{ translate('N/A') }}</strong>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($orderDetail->product != null && $orderDetail->product->auction_product == 0)
                                            <strong>
                                                <a href="{{ route('product', $orderDetail->product->slug) }}"
                                                    target="_blank" class="text-muted">
                                                    {{ $orderDetail->product->getTranslation('name') }}
                                                </a>
                                            </strong>
                                            <small>
                                                {{ $orderDetail->variation }}
                                            </small>
                                            <br>
                                            <small>
                                                @php
                                                    $product_stock = $orderDetail->product->stocks
                                                        ->where('variant', $orderDetail->variation)
                                                        ->first();
                                                @endphp
                                                {{ translate('SKU') }}: {{ $product_stock['sku'] ?? '' }}
                                            </small>
                                        @elseif ($orderDetail->product != null && $orderDetail->product->auction_product == 1)
                                            <strong>
                                                <a href="{{ route('auction-product', $orderDetail->product->slug) }}"
                                                    target="_blank" class="text-muted">
                                                    {{ $orderDetail->product->getTranslation('name') }}
                                                </a>
                                            </strong>
                                        @else
                                            <strong>{{ translate('Product Unavailable') }}</strong>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($order->shipping_type != null && $order->shipping_type == 'home_delivery')
                                            {{ translate('Home Delivery') }}
                                        @elseif ($order->shipping_type == 'pickup_point')
                                            @if ($order->pickup_point != null)
                                                {{ $order->pickup_point->getTranslation('name') }}
                                                ({{ translate('Pickup Point') }})
                                            @else
                                                {{ translate('Pickup Point') }}
                                            @endif
                                        @elseif($order->shipping_type == 'carrier')
                                            @if ($order->carrier_id != null)
                                                {{ $order->carrier_id->name }} ({{ translate('Courier') }})
                                                <br>
                                                {{ translate('Transit Time') . ' - ' . $order->carrier_id->transit_time }}
                                            @else
                                                {{ translate('Courier') }}
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        <input type="number" class="form-control text-center"
                                            onchange="update_order_product_quantity(this)"
                                            value="{{ $orderDetail->quantity }}"
                                            data-orderdetailid="{{ $orderDetail->id }}">
                                    </td>
                                    <td>
                                        {{ single_price($orderDetail->price / $orderDetail->quantity) }}
                                    </td>
                                    <td class="float-center">
                                        <input type="number" class="form-control text-center"
                                            onchange="update_order_product_price(this)"
                                            value="{{ $orderDetail->price }}"
                                            data-orderdetailid="{{ $orderDetail->id }}">
                                        {{-- {{ single_price($orderDetail->price) }} --}}
                                    </td>
                                    <td>
                                        <button class="btn btn-danger btn-xs" onclick="delete_product(this)"
                                            data-orderdetailid="{{ $orderDetail->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row my-2 border rounded p-2">
                <div class="col-md-4">
                    <select class="form-control aiz-selectpicker" data-live-search="true"
                        data-minimum-results-for-search="Infinity" id="add_new_product">
                        <option value="">{{ translate('Select Product') }}</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control text-center" placeholder="Quantity"
                        id="add_new_product_quantity" value="1">
                </div>

                <div class="col-md-4">
                    <button class="btn btn-success" id="add_product">Add new</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    {!! QrCode::size(100)->generate($order->track_url ?? $order->code) !!}
                    <p>{{ $order->track_url ?? $order->code }}</p>
                </div>
                <div class="col-md-6">
                    <div class="clearfix float-right">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>
                                        <strong class="text-muted">{{ translate('Sub Total') }} :</strong>
                                    </td>
                                    <td class="text-right text-danger">
                                        {{ single_price($order->orderDetails->sum('price')) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong class="text-muted">{{ translate('Tax') }} :</strong>
                                    </td>
                                    <td class="text-right text-danger">
                                        <i class="la la-plus m-2 text-danger fw-700"></i>
                                        <input type="number" class="form-control text-right float-right"
                                            onchange="update_order_tax(this)"
                                            value="{{ $order->orderDetails->sum('tax') }}"
                                            data-orderid="{{ $order->id }}" style="width: 100px">
                                        {{-- {{ single_price($order->orderDetails->sum('tax')) }} --}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong class="text-muted">{{ translate('Shipping') }} :</strong>
                                    </td>
                                    <td class="text-right text-danger">
                                        <i class="la la-plus m-2 text-danger fw-700"></i>
                                        <input type="number" class="form-control text-right float-right"
                                            onchange="update_order_shipping(this)"
                                            value="{{ $order->orderDetails->sum('shipping_cost') }}"
                                            data-orderid="{{ $order->id }}" style="width: 100px">
                                        {{-- {{ single_price($order->orderDetails->sum('shipping_cost')) }} --}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong class="text-muted">{{ translate('Coupon') }} :</strong>
                                    </td>
                                    <td class="text-right text-success">
                                        <i class="la la-minus m-2 text-success fw-700"></i>
                                        <input type="number" class="form-control text-right float-right"
                                            onchange="update_order_coupon(this)" value="{{ $order->coupon_discount }}"
                                            data-orderid="{{ $order->id }}" style="width: 100px">
                                        {{-- {{ single_price($order->coupon_discount) }} --}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong class="text-muted">{{ translate('TOTAL') }} :</strong>
                                    </td>
                                    <td class="text-right text-muted h5 text-danger">
                                        {{ single_price($order->grand_total) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong class="text-muted">{{ translate('Total payment') }} :</strong>
                                    </td>
                                    <td class="text-right text-success text-muted h5">
                                        {{ single_price($order->partialPayments->sum('amount')) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong class="text-muted">{{ translate('Due') }} :</strong>
                                    </td>
                                    <td class="text-right text-danger text-muted h5">
                                        {{ single_price($order->grand_total - $order->partialPayments->sum('amount')) }}
                                    </td>
                                </tr>
                                @if ($order->grand_total - $order->partialPayments->sum('amount') > 0)
                                    <tr>
                                        <td>
                                            <strong class="text-muted">{{ translate('Partial Payment') }} :</strong>
                                        </td>
                                        <td class="text-muted h5">
                                            <div class="d-flex">
                                                <input type="number" class="form-control" id="partial_payment"
                                                    style="width: 100px"
                                                    value="{{ $order->grand_total - $order->partialPayments->sum('amount') }}">
                                                <button class="btn btn-primary btn-sm ml-2"
                                                    id="partial_payment_submit">Pay</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>

                @if ($order->partialPayments->isNotEmpty())
                    <div class="col-md-12">
                        <p class="text-center">All Payments</p>
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->partialPayments as $payment)
                                    <tr>
                                        <td>{{ $payment->user->name }}</td>
                                        <td>৳{{ $payment->amount }}</td>
                                        <td>{{ date('d-m-Y h:i A', strtotime($payment->created_at)) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

            </div>

        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var country_id = $('[name=country_id]').val();
            get_states(country_id);

            var order_id = {{ $order->id }};
            var carrier = '{{ $order->carrier_id }}';

            $('#pathao_city_select, #pathao_zone_select, #pathao_area_select, #pathao_pickup_select, #redx_city_select, #redx_area_select')
                .hide();

            if (carrier == 1 || carrier == 2) {
                fetchPathaoCities();
                $('#pathao_city_select, #send-to-courier').show();

                if (carrier == 1) {
                    $('#pathao_zone_select, #pathao_area_select, #pathao_pickup_select').show();
                } else {
                    $('#pathao_zone_select, #pathao_area_select, #pathao_pickup_select').hide();
                }
            } else if (carrier == 3) {
                fetchRedxCities();
                $('#redx_city_select, #redx_area_select, #send-to-courier').show();
            } else if (carrier == 6) {
                $('#send-to-courier').show();
            } else {
                $('#send-to-courier').hide();
            }
        });

        $('#assign_deliver_boy').on('change', function() {
            var order_id = {{ $order->id }};
            var delivery_boy = $('#assign_deliver_boy').val();
            $.post('{{ route('orders.delivery-boy-assign') }}', {
                _token: '{{ @csrf_token() }}',
                order_id: order_id,
                delivery_boy: delivery_boy
            }, function(data) {
                AIZ.plugins.notify('success', '{{ translate('Delivery boy has been assigned') }}');
            });
        });

        $('#update_payment_status').on('change', function() {
            var order_id = {{ $order->id }};
            var status = $('#update_payment_status').val();
            $.post('{{ route('orders.update_payment_status') }}', {
                _token: '{{ @csrf_token() }}',
                order_id: order_id,
                status: status
            }, function(data) {
                AIZ.plugins.notify('success', '{{ translate('Payment status has been updated') }}');
            });
        });

        $('#update_delivery_status').on('change', function() {
            var order_id = {{ $order->id }};
            var status = $('#update_delivery_status').val();
            $.post('{{ route('orders.update_delivery_status') }}', {
                _token: '{{ @csrf_token() }}',
                order_id: order_id,
                status: status
            }, function(data) {
                AIZ.plugins.notify('success', '{{ translate('Delivery status has been updated') }}');
            });
        });

        $('#carrier').on('change', function() {
            var order_id = {{ $order->id }};
            var carrier = $(this).val();

            // Prepare data for AJAX request
            var requestData = {
                _token: '{{ csrf_token() }}',
                order_id: order_id,
                carrier: carrier
            };

            $.post('{{ route('orders.update_carrier') }}', requestData, function(data) {
                AIZ.plugins.notify('success', '{{ translate('Order Carrier has been updated') }}');
            });

            $('#pathao_city_select, #pathao_zone_select, #pathao_area_select, #pathao_pickup_select, #redx_city_select, #redx_area_select')
                .hide();

            if (carrier == 1 || carrier == 2) {
                fetchPathaoCities();
                $('#pathao_city_select, #send-to-courier').show();

                if (carrier == 1) {
                    $('#pathao_zone_select, #pathao_area_select, #pathao_pickup_select').show();
                } else {
                    $('#pathao_zone_select, #pathao_area_select, #pathao_pickup_select').hide();
                }
            } else if (carrier == 3) {
                fetchRedxCities();
                $('#redx_city_select, #redx_area_select, #send-to-courier').show();
            } else if (carrier == 6) {
                $('#send-to-courier').show();
            } else {
                $('#send-to-courier').hide();
            }
        });

        $('#update_tracking_code').on('change', function() {
            var order_id = {{ $order->id }};
            var tracking_code = $('#update_tracking_code').val();
            $.post('{{ route('orders.update_tracking_code') }}', {
                _token: '{{ @csrf_token() }}',
                order_id: order_id,
                tracking_code: tracking_code
            }, function(data) {
                AIZ.plugins.notify('success',
                    '{{ translate('Order tracking code has been updated') }}');
            });
        });

        // On city change, fetch zones and reset areas
        $('#pathao_city').on('change', function() {
            fetchPathaoZones($(this).val());
        });

        // On zone change, fetch areas
        $('#pathao_zone').on('change', function() {
            fetchPathaoAreas($(this).val());
        });

        $('#pathao_area').on('change', function() {
            saveOrderInfo();
        });

        $('#redx_city').on('change', function() {
            fetchRedxAreas($(this).val());
        });

        $('#send-to-courier-form').submit(function(e) {
            e.preventDefault();
            sendToCarrier();
        });

        $('#add_product').click(function() {
            var order_id = {{ $order->id }};
            var product_id = $('#add_new_product').val();
            var quantity = $('#add_new_product_quantity').val();

            if (product_id) {
                if (quantity == '' || quantity == 0) {
                    quantity = 1;
                }

                $.ajax({
                    url: "{{ route('order.add.product') }}",
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        _token: '{{ csrf_token() }}',
                        order_id: order_id,
                        product_id: product_id,
                        quantity: quantity
                    }),
                    success: function(data) {
                        if (data.success) {
                            AIZ.plugins.notify('success', data.message);
                            location.reload();
                        } else {
                            AIZ.plugins.notify('danger', data.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        AIZ.plugins.notify('danger', 'Error, something went wrong !');
                    },
                    complete: function() {
                        $submitButton.prop('disabled', false);
                    }
                });

            } else {
                AIZ.plugins.notify('danger', 'Please Select a product');
            }
        });

        $('#partial_payment_submit').click(function() {
            var $submitButton = $(this);

            $submitButton.prop('disabled', true);

            var order_id = {{ $order->id }};
            var amount = $('#partial_payment').val();

            if (amount == '' || amount == 0) {
                AIZ.plugins.notify('danger', 'Please Enter Valid Payment Amount');
            } else {
                $.ajax({
                    url: '{{ route('order.partial.payment') }}',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        _token: '{{ csrf_token() }}',
                        order_id: order_id,
                        amount: amount,
                    }),
                    success: function(data) {
                        if (data.success) {
                            AIZ.plugins.notify('success', data.message);
                            location.reload();
                        } else {
                            AIZ.plugins.notify('danger', data.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        AIZ.plugins.notify('danger', 'Error, something went wrong !');
                    },
                    complete: function() {
                        $submitButton.prop('disabled', false);
                    }
                });
            }
        });

        $(document).on('change', '[name=country_id]', function() {
            var country_id = $(this).val();
            get_states(country_id);
            saveOrderAddress();
        });

        $(document).on('change', '[name=state_id]', function() {
            var state_id = $(this).val();
            get_city(state_id);
            saveOrderAddress();
        });

        $(document).on('change', '[name=city_id]', function() {
            saveOrderAddress();
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

                    var currentState = '{{ $currentState }}';

                    $('[name="state_id"] option').each(function() {
                        if ($(this).text() == currentState) {
                            $(this).prop('selected', true).change();
                        }
                    });
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

                    var currentCity = '{{ $currentCity }}';
                    $('[name="city_id"] option').each(function() {
                        if ($(this).text() == currentCity) {
                            $(this).prop('selected', true).change();
                        }
                    });
                }
            });
        }

        function fetchPathaoCities() {
            $.ajax({
                url: "{{ route('pathao.cities') }}",
                method: "GET",
                success: function(response) {
                    $('#pathao_city').empty();
                    $('#pathao_city').append('<option value="">Select Pathao/Steadfast City</option>');
                    $.each(response, function(index, city) {
                        $('#pathao_city').append('<option value="' + city['city_id'] + '">' +
                            city['city_name'] + '</option>');

                        var existing_city = '{{ $order->city }}';
                        if (city['city_name'] == existing_city) {
                            $('#pathao_city').val(city['city_id']);
                        }
                    });

                    fetchPathaoZones($('#pathao_city').val());
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        // Function to fetch zones based on city id
        function fetchPathaoZones(cityId) {
            $.ajax({
                url: "{{ route('pathao.zones') }}",
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    city_id: cityId
                },
                success: function(response) {
                    $('#pathao_zone').empty();
                    $('#pathao_zone').append('<option value="">Select Pathao Zone</option>');
                    $.each(response, function(index, zone) {
                        $('#pathao_zone').append('<option value="' + zone['zone_id'] + '">' +
                            zone['zone_name'] + '</option>');

                        var exist_zone = '{{ $order->zone }}';
                        if (zone['zone_name'] == exist_zone) {
                            $('#pathao_zone').val(zone['zone_id']);
                        }
                    });

                    // After fetching zones, trigger fetching areas based on the first zone
                    fetchPathaoAreas($('#pathao_zone').val());
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        // Function to fetch areas based on zone id
        function fetchPathaoAreas(zoneId) {
            $.ajax({
                url: "{{ route('pathao.areas') }}",
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    zone_id: zoneId
                },
                success: function(response) {
                    $('#pathao_area').empty();
                    $('#pathao_area').append('<option value="">Select Pathao Area</option>');
                    $.each(response, function(index, area) {
                        $('#pathao_area').append('<option value="' + area['area_id'] + '">' +
                            area['area_name'] + '</option>');

                        var exist_area = '{{ $order->area }}';
                        if (area['area_name'] == exist_area) {
                            $('#pathao_area').val(area['area_id']);
                        }
                    });
                    saveOrderInfo();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        function fetchRedxCities() {
            $.ajax({
                url: "{{ route('redx.cities') }}",
                method: "GET",
                success: function(response) {
                    $('#redx_city').empty();
                    $('#redx_city').append('<option value="">Select Redx City</option>');
                    $.each(response, function(index, city) {
                        $('#redx_city').append('<option value="' + city['district_name'] + '">' +
                            city['district_name'] + '</option>');

                        var existing_city = '{{ $currentCity }}';
                        if (city['district_name'] == existing_city) {
                            $('#redx_city').val(city['district_name']);
                        }
                    });

                    fetchRedxAreas($('#redx_city').val());
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        function fetchRedxAreas(city) {
            $.ajax({
                url: "{{ route('redx.areas') }}",
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    city: city
                },
                success: function(response) {
                    $('#redx_area').empty();
                    $('#redx_area').append('<option value="">Select redx Area</option>');
                    $.each(response, function(index, area) {
                        $('#redx_area').append('<option value="' + area['id'] + '">' +
                            area['name'] + '</option>');

                        // var exist_area = '{{ $order->area }}';
                        // if (area['area_name'] == exist_area) {
                        //     $('#redx_area').val(area['area_id']);
                        // }
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        function saveOrderInfo() {
            var order_id = {{ $order->id }};
            var city = $('#pathao_city option:selected').text();
            var zone = $('#pathao_zone option:selected').text();
            var area = $('#pathao_area option:selected').text();

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

                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        };

        function saveOrderAddress() {
            var order_id = {{ $order->id }};
            var country = $('[name=country_id] option:selected').text().trim();
            var state = $('[name=state_id] option:selected').text().trim();
            var city = $('[name=city_id] option:selected').text().trim();
            var address = $('#address').val();
            var postal_code = $('#postal_code').val();

            $.post('{{ route('orders.update_address') }}', {
                _token: '{{ csrf_token() }}',
                order_id: order_id,
                country: country,
                state: state,
                city: city,
                address: address,
                postal_code: postal_code,
            }, function(data) {
                // AIZ.plugins.notify('success', '{{ translate('Order Address has been updated') }}');
            });
        };

        function sendToCarrier() {
            $('#send-to-courier').prop('disabled', true).html('Processing');

            var order_id = {{ $order->id }};
            var city_id = $('#pathao_city').val();
            var zone_id = $('#pathao_zone').val();
            var area_id = $('#pathao_area').val();
            var delivery_type = $('#pathao_delivery_type').val();

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
                    console.log(data);
                    if (data.success) {
                        AIZ.plugins.notify('success', data.message);
                        location.reload();
                    } else {
                        AIZ.plugins.notify('danger', data.message);
                        $('#send-to-courier').prop('disabled', false).html('Try Again').removeClass(
                            'btn-success').addClass(
                            'btn-danger');
                    }
                },
                error: function(xhr, status, error) {
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        AIZ.plugins.notify('danger', xhr.responseJSON.message);
                    } else {
                        AIZ.plugins.notify('danger', 'An error occurred while sending the request.');
                    }
                    $('#send-to-courier').prop('disabled', false).html('Try Again').removeClass(
                        'btn-success').addClass(
                        'btn-danger');
                }
            });
        }

        function update_order_product_quantity(input) {
            var quantity = $(input).val();
            var order_details_id = $(input).data('orderdetailid');

            $.ajax({
                url: '{{ route('order.product.quantity.update') }}',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    _token: '{{ csrf_token() }}',
                    order_details_id: order_details_id,
                    quantity: quantity,
                }),
                success: function(data) {
                    if (data.success) {
                        AIZ.plugins.notify('success', data.message);
                        location.reload();
                    } else {
                        AIZ.plugins.notify('danger', data.message);
                    }
                },
                error: function(xhr, status, error) {
                    AIZ.plugins.notify('danger', 'Error, something went wrong !');
                },
                complete: function() {
                    $submitButton.prop('disabled', false);
                }
            });
        }

        function update_order_product_price(input) {
            var price = $(input).val();
            var order_details_id = $(input).data('orderdetailid');

            $.ajax({
                url: '{{ route('order.product.price.update') }}',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    _token: '{{ csrf_token() }}',
                    order_details_id: order_details_id,
                    price: price,
                }),
                success: function(data) {
                    if (data.success) {
                        AIZ.plugins.notify('success', data.message);
                        location.reload();
                    } else {
                        AIZ.plugins.notify('danger', data.message);
                    }
                },
                error: function(xhr, status, error) {
                    AIZ.plugins.notify('danger', 'Error, something went wrong !');
                },
                complete: function() {
                    $submitButton.prop('disabled', false);
                }
            });
        }

        function delete_product(button) {
            var order_details_id = $(button).data('orderdetailid');

            $.ajax({
                url: '{{ route('order.product.delete') }}',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    _token: '{{ csrf_token() }}',
                    order_details_id: order_details_id,
                }),
                success: function(data) {
                    if (data.success) {
                        AIZ.plugins.notify('success', data.message);
                        location.reload();
                    } else {
                        AIZ.plugins.notify('danger', data.message);
                    }
                },
                error: function(xhr, status, error) {
                    AIZ.plugins.notify('danger', 'Error, something went wrong !');
                },
                complete: function() {
                    $submitButton.prop('disabled', false);
                }
            });
        }

        function update_order_tax(input) {
            var tax = $(input).val();
            var order_id = $(input).data('orderid');

            $.ajax({
                url: '{{ route('order.tax.update') }}',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    _token: '{{ csrf_token() }}',
                    order_id: order_id,
                    tax: tax,
                }),
                success: function(data) {
                    if (data.success) {
                        AIZ.plugins.notify('success', data.message);
                        location.reload();
                    } else {
                        AIZ.plugins.notify('danger', data.message);
                    }
                },
                error: function(xhr, status, error) {
                    AIZ.plugins.notify('danger', 'Error, something went wrong !');
                },
                complete: function() {
                    $submitButton.prop('disabled', false);
                }
            });
        }

        function update_order_shipping(input) {
            var shipping = $(input).val();
            var order_id = $(input).data('orderid');

            $.ajax({
                url: '{{ route('order.shipping.update') }}',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    _token: '{{ csrf_token() }}',
                    order_id: order_id,
                    shipping: shipping,
                }),
                success: function(data) {
                    if (data.success) {
                        AIZ.plugins.notify('success', data.message);
                        location.reload();
                    } else {
                        AIZ.plugins.notify('danger', data.message);
                    }
                },
                error: function(xhr, status, error) {
                    AIZ.plugins.notify('danger', 'Error, something went wrong !');
                },
                complete: function() {
                    $submitButton.prop('disabled', false);
                }
            });
        }

        function update_order_coupon(input) {
            var coupon = $(input).val();
            var order_id = $(input).data('orderid');

            $.ajax({
                url: '{{ route('order.coupon.update') }}',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    _token: '{{ csrf_token() }}',
                    order_id: order_id,
                    coupon: coupon,
                }),
                success: function(data) {
                    if (data.success) {
                        AIZ.plugins.notify('success', data.message);
                        location.reload();
                    } else {
                        AIZ.plugins.notify('danger', data.message);
                    }
                },
                error: function(xhr, status, error) {
                    AIZ.plugins.notify('danger', 'Error, something went wrong !');
                },
                complete: function() {
                    $submitButton.prop('disabled', false);
                }
            });
        }

        function fraudCheck() {
            var order_id = '{{ $order->id }}';
            var fraudtext = '{{ $order->fraud_status }}';

            if (fraudtext === '' || $(fraudtext).length === 0) {
                $.ajax({
                    url: "{{ url('admin/order/fraudcheck') }}/" + order_id,
                    type: 'GET',
                    success: function(response) {
                        $('#fraudcheck_' + order_id).html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", error);
                    }
                });
            }
        }
    </script>
@endsection
