@extends('frontend.layouts.app')

@section('content')
    <!-- Order Confirmation -->
    <section class="py-4">
        <div class="container text-left">
            <div class="row">
                <div class="col-xl-8 mx-auto">

                    <div class="row my-2">
                        <div class="col-xxl-5 col-xl-6 col-lg-8 mx-auto">
                            <form class="" action="{{ route('orders.track') }}" method="GET"
                                enctype="multipart/form-data">
                                <div class="bg-white border rounded-0">
                                    <div class="fs-15 fw-600 p-3 border-bottom text-center">
                                        {{ translate('Check Your Order Status') }}
                                    </div>
                                    <div class="form-box-content p-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control rounded-0 mb-3"
                                                placeholder="{{ translate('Order Code') }}" name="order_code" required>
                                        </div>
                                        <div class="text-right">
                                            <button type="submit"
                                                class="btn btn-primary rounded-0 w-150px">{{ translate('Track Order') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    @if (isset($combined_order))
                        @php
                            $first_order = $combined_order->orders->first();
                        @endphp

                        <!-- Order Summary -->
                        <div class="mb-4 bg-white p-4 border">
                            <div class="fs-16 text-soft-dark pb-2 border-bottom d-flex justify-content-between">
                                <h5 class="fw-600 ">
                                    {{ translate('Invoice Download') }}
                                    <a class="btn btn-sm p-2 btn-primary" href="{{ url('invoice/' . $order->id) }}"><i
                                            class="la la-download"></i></a>
                                </h5>

                                @if ($order->tracking_code)
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
                                                Tracking ID: <a href="https://steadfast.com.bd/t/{{ $trackingId }}"
                                                    target="_blank" class="fw-bold">{{ $trackingId }}</a></span>
                                        </p>
                                    @endif
                                @endif

                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table fs-14 text-soft-dark">
                                        <tr>
                                            <td class="w-50 fw-600 border-top-0 pl-0 py-2">{{ translate('Order date') }}:
                                            </td>
                                            <td class="border-top-0 py-2">{{ date('d-m-Y H:i A', $first_order->date) }}
                                            </td>
                                        </tr>
                                        @if (json_decode($first_order->shipping_address)->name)
                                            <tr>
                                                <td class="w-50 fw-600 border-top-0 pl-0 py-2">{{ translate('Name') }}:
                                                </td>
                                                <td class="border-top-0 py-2">
                                                    {{ json_decode($first_order->shipping_address)->name }}</td>
                                            </tr>
                                        @endif
                                        @if (json_decode($first_order->shipping_address)->email)
                                            <tr>
                                                <td class="w-50 fw-600 border-top-0 pl-0 py-2">{{ translate('Email') }}:
                                                </td>
                                                <td class="border-top-0 py-2">
                                                    @php
                                                        $email = json_decode($first_order->shipping_address)->email;

                                                        $parts = explode('@', $email);
                                                        $name = $parts[0];
                                                        $domain = $parts[1];

                                                        $nameLength = strlen($name);
                                                        if ($nameLength > 2) {
                                                            $maskedName =
                                                                $name[0] .
                                                                str_repeat('*', $nameLength - 2) .
                                                                $name[$nameLength - 1];
                                                        } else {
                                                            // If the name is too short to mask, just return the email as is
                                                            $maskedName = $name;
                                                        }

                                                    @endphp
                                                    {{ $maskedName . '@' . $domain }}
                                                </td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td class="w-50 fw-600 border-top-0 pl-0 py-2">
                                                {{ translate('Shipping address') }}:
                                            </td>
                                            <td class="border-top-0 py-2">
                                                @if (json_decode($first_order->shipping_address)->address)
                                                    {{ json_decode($first_order->shipping_address)->address }},
                                                @endif
                                                @if (json_decode($first_order->shipping_address)->city)
                                                    {{ json_decode($first_order->shipping_address)->city }},
                                                @endif
                                                @if (json_decode($first_order->shipping_address)->country)
                                                    {{ json_decode($first_order->shipping_address)->country }}
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table">
                                        <tr>
                                            <td class="w-50 fw-600 border-top-0 py-2">{{ translate('Order status') }}:</td>
                                            <td class="border-top-0 pr-0 py-2">
                                                {{ translate(ucfirst(str_replace('_', ' ', $first_order->delivery_status))) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="w-50 fw-600 border-top-0 py-2">
                                                {{ translate('Total order amount') }}:
                                            </td>
                                            <td class="border-top-0 pr-0 py-2">
                                                {{ single_price($combined_order->grand_total) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="w-50 fw-600 border-top-0 py-2">{{ translate('Shipping') }}:</td>
                                            <td class="border-top-0 pr-0 py-2">{{ translate('Flat shipping rate') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="w-50 fw-600 border-top-0 py-2">{{ translate('Payment method') }}:
                                            </td>
                                            <td class="border-top-0 pr-0 py-2">
                                                {{ translate(ucfirst(str_replace('_', ' ', $first_order->payment_type))) }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Orders Info -->
                        @foreach ($combined_order->orders as $order)
                            <div class="card shadow-none border rounded-0">
                                <div class="card-body">
                                    <!-- Order Code -->
                                    <div class="text-center py-1 mb-4">
                                        <h2 class="h5 fs-20">{{ translate('Order Code:') }} <span
                                                class="fw-700 text-primary">{{ $order->code }}</span></h2>
                                    </div>
                                    <!-- Order Details -->
                                    <div>
                                        <h5 class="fw-600 text-soft-dark mb-3 fs-16 pb-2">{{ translate('Order Details') }}
                                        </h5>
                                        <!-- Product Details -->
                                        <div>
                                            <table class="table table-responsive-md text-soft-dark fs-14">
                                                <thead>
                                                    <tr>
                                                        <th class="opacity-60 border-top-0 pl-0">#</th>
                                                        <th class="opacity-60 border-top-0" width="30%">
                                                            {{ translate('Product') }}</th>
                                                        <th class="opacity-60 border-top-0">{{ translate('Variation') }}
                                                        </th>
                                                        <th class="opacity-60 border-top-0">{{ translate('Quantity') }}
                                                        </th>
                                                        <th class="opacity-60 border-top-0">
                                                            {{ translate('Delivery Type') }}
                                                        </th>
                                                        <th class="text-right opacity-60 border-top-0 pr-0">
                                                            {{ translate('Price') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($order->orderDetails as $key => $orderDetail)
                                                        <tr>
                                                            <td class="border-top-0 border-bottom pl-0">{{ $key + 1 }}
                                                            </td>
                                                            <td class="border-top-0 border-bottom">
                                                                @if ($orderDetail->product != null)
                                                                    <a href="{{ route('product', $orderDetail->product->slug) }}"
                                                                        target="_blank" class="text-reset">
                                                                        {{ $orderDetail->product->getTranslation('name') }}
                                                                        @php
                                                                            if ($orderDetail->combo_id != null) {
                                                                                $combo = \App\ComboProduct::findOrFail(
                                                                                    $orderDetail->combo_id,
                                                                                );

                                                                                echo '(' . $combo->combo_title . ')';
                                                                            }
                                                                        @endphp
                                                                    </a>
                                                                @else
                                                                    <strong>{{ translate('Product Unavailable') }}</strong>
                                                                @endif
                                                            </td>
                                                            <td class="border-top-0 border-bottom">
                                                                {{ $orderDetail->variation }}
                                                            </td>
                                                            <td class="border-top-0 border-bottom">
                                                                {{ $orderDetail->quantity }}
                                                            </td>
                                                            <td class="border-top-0 border-bottom">
                                                                @if ($order->shipping_type != null && $order->shipping_type == 'home_delivery')
                                                                    {{ translate('Home Delivery') }}
                                                                @elseif ($order->shipping_type != null && $order->shipping_type == 'carrier')
                                                                    {{ translate('Carrier') }}
                                                                @elseif ($order->shipping_type == 'pickup_point')
                                                                    @if ($order->pickup_point != null)
                                                                        {{ $order->pickup_point->getTranslation('name') }}
                                                                        ({{ translate('Pickip Point') }})
                                                                    @endif
                                                                @endif
                                                            </td>
                                                            <td class="border-top-0 border-bottom pr-0 text-right">
                                                                {{ single_price($orderDetail->price) }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- Order Amounts -->
                                        <div class="row">
                                            <div class="col-xl-7 col-md-6 ml-auto mr-0">
                                                {!! QrCode::size(100)->generate($order->track_url ?? $order->code) !!}
                                                <p style="margin-top: 5px">{{ $order->track_url }}</p>
                                            </div>
                                            <div class="col-xl-5 col-md-6 ml-auto mr-0">
                                                <table class="table ">
                                                    <tbody>
                                                        <!-- Subtotal -->
                                                        <tr>
                                                            <th class="border-top-0 py-2">{{ translate('Subtotal') }}</th>
                                                            <td class="text-right border-top-0 pr-0 py-2">
                                                                <span
                                                                    class="fw-600">{{ single_price($order->orderDetails->sum('price')) }}</span>
                                                            </td>
                                                        </tr>
                                                        <!-- Shipping -->
                                                        <tr>
                                                            <th class="border-top-0 py-2">{{ translate('Shipping') }}</th>
                                                            <td class="text-right border-top-0 pr-0 py-2">
                                                                <span>{{ single_price($order->orderDetails->sum('shipping_cost')) }}</span>
                                                            </td>
                                                        </tr>
                                                        <!-- Tax -->
                                                        <tr>
                                                            <th class="border-top-0 py-2">{{ translate('Tax') }}</th>
                                                            <td class="text-right border-top-0 pr-0 py-2">
                                                                <span>{{ single_price($order->orderDetails->sum('tax')) }}</span>
                                                            </td>
                                                        </tr>
                                                        <!-- Coupon Discount -->
                                                        <tr>
                                                            <th class="border-top-0 py-2">
                                                                {{ translate('Coupon Discount') }}
                                                            </th>
                                                            <td class="text-right border-top-0 pr-0 py-2">
                                                                <span>{{ single_price($order->coupon_discount) }}</span>
                                                            </td>
                                                        </tr>
                                                        <!-- Total -->
                                                        <tr>
                                                            <th class="py-2"><span
                                                                    class="fw-600">{{ translate('Total') }}</span></th>
                                                            <td class="text-right pr-0">
                                                                <strong><span>{{ single_price($order->grand_total) }}</span></strong>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
