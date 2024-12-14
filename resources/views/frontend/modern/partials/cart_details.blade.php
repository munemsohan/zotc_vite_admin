@php
    $tax = 0;
    $shipping = 0;
    $product_shipping_cost = 0;
@endphp

<div class="container">
    @if ($carts && count($carts) > 0)
        <form action="{{ route('payment.checkout') }}" class="form-default" role="form" method="POST" id="checkout-form">
            @csrf
            <div class="row">
                <div class="col-md-6 mx-auto rounded">
                    {{-- cart summary --}}
                    <div class="border bg-white p-3 p-lg-4 text-left">
                        <div class="mb-4">
                            <!-- Headers -->
                            <div class="row gutters-5 d-none d-lg-flex border-bottom mb-3 pb-3 text-secondary fs-12">
                                <div class="col-1 fw-600"></div>
                                <div class="col-4 fw-600 text-center">{{ translate('Product') }}</div>
                                <div class="col-2 fw-600 text-center">{{ translate('Price') }}</div>
                                <div class="col-3 fw-600 text-center">{{ translate('Qty') }}</div>
                                {{-- <div class="col fw-600">{{ translate('Tax') }}</div> --}}
                                <div class="col-2 fw-600 text-right">{{ translate('Total') }}</div>
                            </div>
                            <!-- Cart Items -->
                            <ul class="list-group list-group-flush">
                                @php
                                    $subtotal = 0;
                                @endphp
                                @foreach ($carts as $key => $cartItem)
                                    @php
                                        $product = get_single_product($cartItem['product_id']);
                                        $product_stock = $product->stocks
                                            ->where('variant', $cartItem['variation'])
                                            ->first();
                                        // $subtotal = $subtotal + ($cartItem['price']  + $cartItem['tax']) * $cartItem['quantity'];
                                        $subtotal =
                                            $subtotal +
                                            cart_product_price($cartItem, $product, false) * $cartItem['quantity'];
                                        $product_name_with_choice = '';
                                        if ($cartItem['variation'] != null) {
                                            $product_name_with_choice = $cartItem['variation'];
                                        }
                                    @endphp
                                    <li class="list-group-item px-0">
                                        <div class="row gutters-5 align-items-center">
                                            <div class="col-md-12">
                                                <span class="fs-14 fw-500 mb-1">
                                                    {{ $key + 1 }}. {{ $product->getTranslation('name') }}
                                                </span>
                                            </div>
                                            <!-- Remove From Cart -->
                                            <div class="col-md-1 col-2">
                                                <a href="javascript:void(0)"
                                                    onclick="removeFromCartView(event, {{ $cartItem['id'] }})"
                                                    class="btn btn-icon btn-sm btn-soft-primary bg-soft-secondary-base hov-bg-primary btn-circle">
                                                    <i class="las la-trash fs-16"></i>
                                                </a>
                                            </div>

                                            <!-- Product Image -->
                                            <div class="col-md-4 col-8 d-flex align-items-center mb-2 mb-md-0">
                                                <span class="mx-0">
                                                    <img src="{{ get_image($product->thumbnail) }}"
                                                        class="img-fit size-50px"
                                                        alt="{{ $product->getTranslation('name') }}"
                                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholderx200.webp') }}';">
                                                </span>
                                                <span class="fs-14 mx-1">{{ $product_name_with_choice }}</span>
                                            </div>

                                            <!-- Price -->
                                            <div class="col-md-2 col-2 my-3 my-md-0">
                                                <span
                                                    class="opacity-60 fs-12 d-block d-md-none">{{ translate('Price') }}</span>
                                                <span
                                                    class="fw-700 fs-14">{{ cart_product_price($cartItem, $product, true, false) }}</span>
                                                <input type="hidden" id="product_price_{{ $cartItem['id'] }}"
                                                    value="{{ cart_product_price($cartItem, $product, false, false) }}">
                                            </div>

                                            <!-- Quantity -->
                                            <div class="col-md-3 col-6">
                                                @if ($cartItem['digital'] != 1 && $product->auction_product == 0)
                                                    <div class="d-flex justify-content-between aiz-plus-minus mx-0">
                                                        <button
                                                            class="btn col-auto btn-icon btn-sm btn-circle btn-light text-danger"
                                                            type="button" data-type="minus"
                                                            data-field="quantity[{{ $cartItem['id'] }}]">
                                                            <i class="las la-minus"></i>
                                                        </button>
                                                        <input type="number" name="quantity[{{ $cartItem['id'] }}]"
                                                            class="col text-center border-0 text-left p-0 flex-grow-1 fs-14 input-number"
                                                            placeholder="1" value="{{ $cartItem['quantity'] }}"
                                                            min="{{ $product->min_qty }}"
                                                            max="{{ $product_stock->qty }}"
                                                            onchange="updateQuantity({{ $cartItem['id'] }}, this)">
                                                        <button
                                                            class="btn col-auto btn-icon btn-sm btn-circle btn-light text-success"
                                                            type="button" data-type="plus"
                                                            data-field="quantity[{{ $cartItem['id'] }}]">
                                                            <i class="las la-plus"></i>
                                                        </button>
                                                    </div>
                                                @elseif($product->auction_product == 1)
                                                    <span class="fw-700 fs-14">1</span>
                                                @endif
                                            </div>

                                            <!-- Tax -->
                                            {{-- <div class="col-md col-4 order-3 order-md-0 my-3 my-md-0">
                                                    <span
                                                        class="opacity-60 fs-12 d-block d-md-none">{{ translate('Tax') }}</span>
                                                    <span
                                                        class="fw-700 fs-14">{{ cart_product_tax($cartItem, $product) }}</span>
                                                </div> --}}

                                            <!-- Total -->
                                            <div class="col-md-2 col-6 text-right">
                                                <span
                                                    class="opacity-60 fs-12 d-block d-md-none">{{ translate('Total') }}</span>
                                                <span class="fw-700 fs-16 text-primary"
                                                    id="product_total_{{ $cartItem['id'] }}">{{ single_price(cart_product_price($cartItem, $product, false) * $cartItem['quantity']) }}</span>
                                                <input type="hidden" class="product_total"
                                                    id="product_total_input_{{ $cartItem['id'] }}"
                                                    value="{{ cart_product_price($cartItem, $product, false) * $cartItem['quantity'] }}">
                                            </div>

                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="row">
                            @foreach ($carts as $key => $cartItem)
                                @php
                                    $product = get_single_product($cartItem['product_id']);

                                    $tax += cart_product_tax($cartItem, $product, false) * $cartItem['quantity'];
                                    $product_shipping_cost = $cartItem['shipping_cost'];

                                    $shipping += $product_shipping_cost;

                                    $product_name_with_choice = $product->getTranslation('name');
                                    if ($cartItem['variant'] != null) {
                                        $product_name_with_choice =
                                            $product->getTranslation('name') . ' - ' . $cartItem['variant'];
                                    }
                                @endphp
                            @endforeach

                            @if ($tax)
                                <!-- tax -->
                                <div class="px-0 py-2 d-flex justify-content-between">
                                    <span class="opacity-60 fs-14">{{ translate('Tax') }}</span>
                                    <span class="fw-700 fs-16">{{ single_price($tax) }}</span>
                                </div>
                            @endif

                            @php
                                $coupon_discount = 0;
                            @endphp
                            @if (get_setting('coupon_system') == 1)
                                @php
                                    $coupon_code = null;
                                @endphp

                                @foreach ($carts as $key => $cartItem)
                                    @if ($cartItem->coupon_applied == 1)
                                        @php
                                            $coupon_code = $cartItem->coupon_code;
                                            break;
                                        @endphp
                                    @endif
                                @endforeach

                                @php
                                    $coupon_discount = $carts->sum('discount');
                                @endphp
                            @endif

                            @php $subtotal_for_min_order_amount = 0; @endphp
                            @foreach ($carts as $key => $cartItem)
                                @php $subtotal_for_min_order_amount += cart_product_price($cartItem, $cartItem->product, false, false) * $cartItem['quantity']; @endphp
                            @endforeach
                            @if (get_setting('minimum_order_amount_check') == 1 &&
                                    $subtotal_for_min_order_amount < get_setting('minimum_order_amount'))
                                <span class="badge badge-inline badge-primary fs-12 rounded-0 px-2">
                                    {{ translate('Minimum Order Amount') . ' ' . single_price(get_setting('minimum_order_amount')) }}
                                </span>
                            @endif
                            @php
                                $total = $subtotal + $tax + $shipping;
                                if (Session::has('club_point')) {
                                    $total -= Session::get('club_point');
                                }
                                if ($coupon_discount > 0) {
                                    $total -= $coupon_discount;
                                }
                            @endphp
                            <div class="col-6">
                                <div class="card rounded-0 shadow-none border-0 mb-0">
                                    <div class="p-1 border-bottom-0">
                                        <h3 class="fs-14 mb-0 mb-0">
                                            {{ translate('Summary') }}

                                            <span class="badge badge-inline w-auto badge-primary fs-12 rounded-0 px-2">
                                                {{ count($carts) }}
                                                {{ translate('Items') }}
                                            </span>
                                        </h3>
                                    </div>

                                    <!-- Club point -->
                                    @if (addon_is_activated('club_point'))
                                        <div class="p-1 w-100 d-flex align-items-center justify-content-between">
                                            <h3 class="fs-14 mb-0">
                                                {{ translate('Clubpoint') }}
                                                <span
                                                    class="badge badge-inline w-auto badge-secondary-base fs-14 rounded-0 px-2 text-white">
                                                    @php
                                                        $total_point = 0;
                                                    @endphp
                                                    @foreach ($carts as $key => $cartItem)
                                                        @php
                                                            $product = get_single_product($cartItem['product_id']);
                                                            $total_point +=
                                                                $product->earn_point * $cartItem['quantity'];
                                                        @endphp
                                                    @endforeach

                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12"
                                                        height="12" viewBox="0 0 12 12" class="mr-2">
                                                        <g id="Group_23922" data-name="Group 23922"
                                                            transform="translate(-973 -633)">
                                                            <circle id="Ellipse_39" data-name="Ellipse 39"
                                                                cx="6" cy="6" r="6"
                                                                transform="translate(973 633)" fill="#fff" />
                                                            <g id="Group_23920" data-name="Group 23920"
                                                                transform="translate(973 633)">
                                                                <path id="Path_28698" data-name="Path 28698"
                                                                    d="M7.667,3H4.333L3,5,6,9,9,5Z"
                                                                    transform="translate(0 0)" fill="#f3af3d" />
                                                                <path id="Path_28699" data-name="Path 28699"
                                                                    d="M5.33,3h-1L3,5,6,9,4.331,5Z"
                                                                    transform="translate(0 0)" fill="#f3af3d"
                                                                    opacity="0.5" />
                                                                <path id="Path_28700" data-name="Path 28700"
                                                                    d="M12.666,3h1L15,5,12,9l1.664-4Z"
                                                                    transform="translate(-5.995 0)" fill="#f3af3d" />
                                                            </g>
                                                        </g>
                                                    </svg>
                                                    {{ $total_point }}
                                                </span>
                                            </h3>
                                        </div>
                                    @endif

                                    <!-- Coupon System -->
                                    @if (get_setting('coupon_system') == 1)
                                        @if ($coupon_discount > 0 && $coupon_code)
                                            <div class="mt-1">
                                                {{-- <form class="" id="remove-coupon-form" enctype="multipart/form-data">
                                            @csrf --}}
                                                <div class="input-group">
                                                    <div class="form-control">{{ $coupon_code }}</div>
                                                    <div class="input-group-append">
                                                        <button type="button" id="coupon-remove"
                                                            class="btn btn-primary">{{ translate('Change Coupon') }}</button>
                                                    </div>
                                                </div>
                                                {{-- </form> --}}
                                            </div>
                                        @else
                                            <h3 class="fs-14 text-success mt-3">Have Coupon Code?
                                                <span onclick="coupon_toggle()" style="cursor: pointer"><u>Apply
                                                        Here</u></span>
                                            </h3>

                                            <div id="coupon_div" class="my-3" style="display: none">
                                                {{-- <form class="" id="apply-coupon-form" enctype="multipart/form-data">
                                                @csrf --}}
                                                <input type="hidden" name="owner_id"
                                                    value="{{ $carts[0]['owner_id'] }}">
                                                <div class="input-group">
                                                    <input type="text" class="form-control rounded-0"
                                                        name="code" onkeydown="return event.key != 'Enter';"
                                                        placeholder="{{ translate('Enter Coupon Code here') }}">
                                                    <div class="input-group-append">
                                                        <button type="button" id="coupon-apply"
                                                            class="btn btn-sm btn-primary rounded-0">{{ translate('Apply') }}</button>
                                                    </div>
                                                </div>
                                                {{-- </form> --}}
                                            </div>
                                        @endif
                                    @endif
                                    <!-- Products Info -->
                                    <input type="hidden" id="sub_total" value="{{ $subtotal }}">

                                    <table class="table">
                                        <tfoot>
                                            <!-- Redeem point -->
                                            @if (Session::has('club_point'))
                                                <tr class="cart-shipping">
                                                    <th class="pl-0 fs-14 pt-0 pb-2 text-dark fw-600 border-top-0">
                                                        {{ translate('Redeem point') }}
                                                    </th>
                                                    <td
                                                        class="text-right pr-0 fs-14 pt-0 pb-2 fw-600 text-primary border-top-0">
                                                        <span
                                                            class="fw-600">{{ single_price(Session::get('club_point')) }}</span>
                                                    </td>
                                                </tr>
                                            @endif
                                            <!-- Coupon Discount -->
                                            @if ($coupon_discount > 0)
                                                <tr class="cart-shipping">
                                                    <th class="pl-0 fs-14 pt-0 pb-2 text-dark fw-600 border-top-0">
                                                        {{ translate('Coupon Discount') }}</th>
                                                    <td
                                                        class="text-right pr-0 fs-14 pt-0 pb-2 fw-600 text-primary border-top-0">
                                                        <span
                                                            class="fw-600">{{ single_price($coupon_discount) }}</span>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <div class="col-6">
                                <!-- Subtotal -->
                                <div class="px-0 py-2 d-flex justify-content-between border-top">
                                    <span class="opacity-60 fs-14">{{ translate('Subtotal') }}</span>
                                    <span class="fw-700 fs-16" id="subtotal">{{ single_price($subtotal) }}</span>
                                </div>

                                <!-- shipping -->
                                <div class="px-0 py-2 d-flex justify-content-between">
                                    <span class="opacity-60 fs-14">{{ translate('Shipping') }}</span>
                                    <input type="hidden" value="{{ $shipping }}" id="shipping">
                                    <span class="fw-700 fs-16"
                                        id="shipping_text">{{ single_price($shipping) }}</span>
                                </div>

                                <!-- Total -->
                                <div class="px-0 py-2 d-flex justify-content-between border-top">
                                    <span class="fw-bold fs-14">{{ translate('Total') }}</span>
                                    <span class="fw-700 fs-16" id="total">{{ single_price($total) }}</span>
                                </div>
                            </div>


                            @if (get_cart_setting('additional_info') == 1)
                                <div class="col-md-12">
                                    <h3 class="fs-14 mb-0">Any additional info?
                                        <span class="text-primary" onclick="addi_info_toggle()"
                                            style="cursor: pointer"><u>Click
                                                Here</u></span>
                                    </h3>
                                    <div id="addi_info_div" class="form-group px-3 pt-3" style="display: none">
                                        <textarea name="additional_info" rows="5" class="form-control"
                                            placeholder="{{ translate('Type your text') }}"></textarea>
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div>


                </div>

                <div class="col-md-6 mx-auto rounded">
                    <div class="border">
                        {{-- <form class="form-default" id="shipping_info_form" data-toggle="validator"
                            action="{{ route('checkout.store_shipping_infostore') }}" role="form" method="POST"> --}}

                        @include('frontend.shipping_info', ['carts' => $carts])

                        {{-- @include('frontend.delivery_info', ['carts' => $carts]) --}}
                        {{-- </form> --}}
                    </div>

                    {{-- <div class="border text-left mt-2">
                    @include('frontend.delivery_info')
                </div> --}}

                    @if ($carts[0]['shipping_type'] == 'custom')
                        <div class="border mt-2">
                            <div class="card rounded border-0 shadow-sm">
                                <div class="card-header">
                                    <h5 class="fs-16 fw-600 mb-0">{{ translate('Select Shipping Option') }}</h5>
                                </div>
                                <div class="card-body d-flex justify-content-left">
                                    @php
                                        $custom_shippings = json_decode(get_setting('custom_shipping_info'), true);
                                    @endphp
                                    @if (!empty($custom_shippings))
                                        @foreach ($custom_shippings as $key => $value)
                                            <div class="form-check mr-3">
                                                <input class="form-check-input" type="radio"
                                                    name="custom_shipping_cost" id="shipping_{{ $key }}"
                                                    value="{{ $value }}"
                                                    onchange="updateCustomShippingCost(this)"
                                                    {{ $shipping == $value ? 'checked' : '' }}>
                                                <label class="form-check-label" for="shipping_{{ $key }}">
                                                    {{ $key }}
                                                </label>
                                            </div>
                                        @endforeach
                                    @else
                                        <p>No custom shipping options available.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="border text-left mt-2">

                        <input type="hidden" name="owner_id" value="{{ $carts[0]['owner_id'] }}">

                        <div class="card rounded border-0 shadow-sm">
                            <div class="card-header p-3">
                                <h3 class="fs-16 fw-600 mb-0">
                                    {{ translate('Select a payment option') }}
                                </h3>
                            </div>
                            <div class="card-body text-center">
                                <div class="row">
                                    <div class="col-xxl-8 col-xl-10 mx-auto">
                                        <div class="row gutters-10">
                                            @if (get_setting('uddoktapay_payment') == 1)
                                                <div class="col-6 col-md-4">
                                                    <label class="aiz-megabox d-block mb-3">
                                                        <input value="uddoktapay" class="online_payment"
                                                            type="radio" name="payment_option" checked>
                                                        <span class="d-block aiz-megabox-elem p-3 h-auto">
                                                            <img src="{{ static_asset('assets/img/cards/up_payment_logo.png') }}"
                                                                class="img-fluid mb-2">
                                                            <span class="d-block text-center">
                                                                <span
                                                                    class="d-block fw-600 fs-15">{{ translate('bKash/Rocket/Nagad/Upay') }}</span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                            @if (get_setting('paypal_payment') == 1)
                                                <div class="col-6 col-md-4">
                                                    <label class="aiz-megabox d-block mb-3">
                                                        <input value="paypal" class="online_payment" type="radio"
                                                            name="payment_option" checked>
                                                        <span class="d-block aiz-megabox-elem p-3 h-auto">
                                                            <img src="{{ static_asset('assets/img/cards/paypal.png') }}"
                                                                class="img-fluid mb-2">
                                                            <span class="d-block text-center">
                                                                <span
                                                                    class="d-block fw-600 fs-15">{{ translate('Paypal') }}</span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                            @if (get_setting('stripe_payment') == 1)
                                                <div class="col-6 col-md-4">
                                                    <label class="aiz-megabox d-block mb-3">
                                                        <input value="stripe" class="online_payment" type="radio"
                                                            name="payment_option" checked>
                                                        <span class="d-block aiz-megabox-elem p-3 h-auto">
                                                            <img src="{{ static_asset('assets/img/cards/stripe.png') }}"
                                                                class="img-fluid mb-2">
                                                            <span class="d-block text-center">
                                                                <span
                                                                    class="d-block fw-600 fs-15">{{ translate('Stripe') }}</span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                            @if (get_setting('mercadopago_payment') == 1)
                                                <div class="col-6 col-md-4">
                                                    <label class="aiz-megabox d-block mb-3">
                                                        <input value="mercadopago" class="online_payment"
                                                            type="radio" name="payment_option" checked>
                                                        <span class="d-block aiz-megabox-elem p-3 h-auto">
                                                            <img src="{{ static_asset('assets/img/cards/mercadopago.png') }}"
                                                                class="img-fluid mb-2">
                                                            <span class="d-block text-center">
                                                                <span
                                                                    class="d-block fw-600 fs-15">{{ translate('Mercadopago') }}</span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                            @if (get_setting('sslcommerz_payment') == 1)
                                                <div class="col-6 col-md-4">
                                                    <label class="aiz-megabox d-block mb-3">
                                                        <input value="sslcommerz" class="online_payment"
                                                            type="radio" name="payment_option" checked>
                                                        <span class="d-block aiz-megabox-elem p-3 h-auto">
                                                            <img src="{{ static_asset('assets/img/cards/sslcommerz.png') }}"
                                                                class="img-fluid mb-2">
                                                            <span class="d-block text-center">
                                                                <span
                                                                    class="d-block fw-600 fs-15">{{ translate('sslcommerz') }}</span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                            @if (get_setting('instamojo_payment') == 1)
                                                <div class="col-6 col-md-4">
                                                    <label class="aiz-megabox d-block mb-3">
                                                        <input value="instamojo" class="online_payment"
                                                            type="radio" name="payment_option" checked>
                                                        <span class="d-block aiz-megabox-elem p-3 h-auto">
                                                            <img src="{{ static_asset('assets/img/cards/instamojo.png') }}"
                                                                class="img-fluid mb-2">
                                                            <span class="d-block text-center">
                                                                <span
                                                                    class="d-block fw-600 fs-15">{{ translate('Instamojo') }}</span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                            @if (get_setting('razorpay') == 1)
                                                <div class="col-6 col-md-4">
                                                    <label class="aiz-megabox d-block mb-3">
                                                        <input value="razorpay" class="online_payment" type="radio"
                                                            name="payment_option" checked>
                                                        <span class="d-block aiz-megabox-elem p-3 h-auto">
                                                            <img src="{{ static_asset('assets/img/cards/rozarpay.png') }}"
                                                                class="img-fluid mb-2">
                                                            <span class="d-block text-center">
                                                                <span
                                                                    class="d-block fw-600 fs-15">{{ translate('Razorpay') }}</span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                            @if (get_setting('paystack') == 1)
                                                <div class="col-6 col-md-4">
                                                    <label class="aiz-megabox d-block mb-3">
                                                        <input value="paystack" class="online_payment" type="radio"
                                                            name="payment_option" checked>
                                                        <span class="d-block aiz-megabox-elem p-3 h-auto">
                                                            <img src="{{ static_asset('assets/img/cards/paystack.png') }}"
                                                                class="img-fluid mb-2">
                                                            <span class="d-block text-center">
                                                                <span
                                                                    class="d-block fw-600 fs-15">{{ translate('Paystack') }}</span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                            @if (get_setting('voguepay') == 1)
                                                <div class="col-6 col-md-4">
                                                    <label class="aiz-megabox d-block mb-3">
                                                        <input value="voguepay" class="online_payment" type="radio"
                                                            name="payment_option" checked>
                                                        <span class="d-block aiz-megabox-elem p-3 h-auto">
                                                            <img src="{{ static_asset('assets/img/cards/vogue.png') }}"
                                                                class="img-fluid mb-2">
                                                            <span class="d-block text-center">
                                                                <span
                                                                    class="d-block fw-600 fs-15">{{ translate('VoguePay') }}</span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                            @if (get_setting('payhere') == 1)
                                                <div class="col-6 col-md-4">
                                                    <label class="aiz-megabox d-block mb-3">
                                                        <input value="payhere" class="online_payment" type="radio"
                                                            name="payment_option" checked>
                                                        <span class="d-block aiz-megabox-elem p-3 h-auto">
                                                            <img src="{{ static_asset('assets/img/cards/payhere.png') }}"
                                                                class="img-fluid mb-2">
                                                            <span class="d-block text-center">
                                                                <span
                                                                    class="d-block fw-600 fs-15">{{ translate('payhere') }}</span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                            @if (get_setting('ngenius') == 1)
                                                <div class="col-6 col-md-4">
                                                    <label class="aiz-megabox d-block mb-3">
                                                        <input value="ngenius" class="online_payment" type="radio"
                                                            name="payment_option" checked>
                                                        <span class="d-block aiz-megabox-elem p-3 h-auto">
                                                            <img src="{{ static_asset('assets/img/cards/ngenius.png') }}"
                                                                class="img-fluid mb-2">
                                                            <span class="d-block text-center">
                                                                <span
                                                                    class="d-block fw-600 fs-15">{{ translate('ngenius') }}</span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                            @if (get_setting('iyzico') == 1)
                                                <div class="col-6 col-md-4">
                                                    <label class="aiz-megabox d-block mb-3">
                                                        <input value="iyzico" class="online_payment" type="radio"
                                                            name="payment_option" checked>
                                                        <span class="d-block aiz-megabox-elem p-3 h-auto">
                                                            <img src="{{ static_asset('assets/img/cards/iyzico.png') }}"
                                                                class="img-fluid mb-2">
                                                            <span class="d-block text-center">
                                                                <span
                                                                    class="d-block fw-600 fs-15">{{ translate('Iyzico') }}</span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                            @if (get_setting('nagad') == 1)
                                                <div class="col-6 col-md-4">
                                                    <label class="aiz-megabox d-block mb-3">
                                                        <input value="nagad" class="online_payment" type="radio"
                                                            name="payment_option" checked>
                                                        <span class="d-block aiz-megabox-elem p-3 h-auto">
                                                            <img src="{{ static_asset('assets/img/cards/nagad.png') }}"
                                                                class="img-fluid mb-2">
                                                            <span class="d-block text-center">
                                                                <span
                                                                    class="d-block fw-600 fs-15">{{ translate('Nagad') }}</span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                            @if (get_setting('bkash') == 1)
                                                <div class="col-6 col-md-4">
                                                    <label class="aiz-megabox d-block mb-3">
                                                        <input value="bkash" class="online_payment" type="radio"
                                                            name="payment_option" checked>
                                                        <span class="d-block aiz-megabox-elem p-3 h-auto">
                                                            <img src="{{ static_asset('assets/img/cards/bkash.png') }}"
                                                                class="img-fluid mb-2">
                                                            <span class="d-block text-center">
                                                                <span
                                                                    class="d-block fw-600 fs-15">{{ translate('Bkash') }}</span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                            @if (get_setting('aamarpay') == 1)
                                                <div class="col-6 col-md-4">
                                                    <label class="aiz-megabox d-block mb-3">
                                                        <input value="aamarpay" class="online_payment" type="radio"
                                                            name="payment_option" checked>
                                                        <span class="d-block aiz-megabox-elem p-3 h-auto">
                                                            <img src="{{ static_asset('assets/img/cards/aamarpay.png') }}"
                                                                class="img-fluid mb-2">
                                                            <span class="d-block text-center">
                                                                <span
                                                                    class="d-block fw-600 fs-15">{{ translate('Aamarpay') }}</span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                            @if (get_setting('authorizenet') == 1)
                                                <div class="col-6 col-md-4">
                                                    <label class="aiz-megabox d-block mb-3">
                                                        <input value="authorizenet" class="online_payment"
                                                            type="radio" name="payment_option" checked>
                                                        <span class="d-block aiz-megabox-elem p-3 h-auto">
                                                            <img src="{{ static_asset('assets/img/cards/authorizenet.png') }}"
                                                                class="img-fluid mb-2">
                                                            <span class="d-block text-center">
                                                                <span
                                                                    class="d-block fw-600 fs-15">{{ translate('Authorize Net') }}</span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                            @if (get_setting('payku') == 1)
                                                <div class="col-6 col-md-4">
                                                    <label class="aiz-megabox d-block mb-3">
                                                        <input value="payku" class="online_payment" type="radio"
                                                            name="payment_option" checked>
                                                        <span class="d-block aiz-megabox-elem p-3 h-auto">
                                                            <img src="{{ static_asset('assets/img/cards/payku.png') }}"
                                                                class="img-fluid mb-2">
                                                            <span class="d-block text-center">
                                                                <span
                                                                    class="d-block fw-600 fs-15">{{ translate('Payku') }}</span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                            @if (addon_is_activated('african_pg'))
                                                @if (get_setting('flutterwave') == 1)
                                                    <div class="col-6 col-md-4">
                                                        <label class="aiz-megabox d-block mb-3">
                                                            <input value="flutterwave" class="online_payment"
                                                                type="radio" name="payment_option" checked>
                                                            <span class="d-block aiz-megabox-elem p-3 h-auto">
                                                                <img src="{{ static_asset('assets/img/cards/flutterwave.png') }}"
                                                                    class="img-fluid mb-2">
                                                                <span class="d-block text-center">
                                                                    <span
                                                                        class="d-block fw-600 fs-15">{{ translate('flutterwave') }}</span>
                                                                </span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                @endif
                                                @if (get_setting('payfast') == 1)
                                                    <div class="col-6 col-md-4">
                                                        <label class="aiz-megabox d-block mb-3">
                                                            <input value="payfast" class="online_payment"
                                                                type="radio" name="payment_option" checked>
                                                            <span class="d-block aiz-megabox-elem p-3 h-auto">
                                                                <img src="{{ static_asset('assets/img/cards/payfast.png') }}"
                                                                    class="img-fluid mb-2">
                                                                <span class="d-block text-center">
                                                                    <span
                                                                        class="d-block fw-600 fs-15">{{ translate('payfast') }}</span>
                                                                </span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                @endif
                                            @endif
                                            @if (addon_is_activated('paytm'))
                                                @if (get_setting('paytm_payment') == 1)
                                                    <div class="col-6 col-md-4">
                                                        <label class="aiz-megabox d-block mb-3">
                                                            <input value="paytm" class="online_payment"
                                                                type="radio" name="payment_option" checked>
                                                            <span class="d-block aiz-megabox-elem p-3 h-auto">
                                                                <img src="{{ static_asset('assets/img/cards/paytm.jpg') }}"
                                                                    class="img-fluid mb-2">
                                                                <span class="d-block text-center">
                                                                    <span
                                                                        class="d-block fw-600 fs-15">{{ translate('Paytm') }}</span>
                                                                </span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                @endif
                                                @if (get_setting('toyyibpay_payment') == 1)
                                                    <div class="col-6 col-md-4">
                                                        <label class="aiz-megabox d-block mb-3">
                                                            <input value="toyyibpay" class="online_payment"
                                                                type="radio" name="payment_option" checked>
                                                            <span class="d-block aiz-megabox-elem p-3 h-auto">
                                                                <img src="{{ static_asset('assets/img/cards/toyyibpay.png') }}"
                                                                    class="img-fluid mb-2">
                                                                <span class="d-block text-center">
                                                                    <span
                                                                        class="d-block fw-600 fs-15">{{ translate('ToyyibPay') }}</span>
                                                                </span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                @endif
                                                @if (get_setting('myfatoorah') == 1)
                                                    <div class="col-6 col-md-4">
                                                        <label class="aiz-megabox d-block mb-3">
                                                            <input value="myfatoorah" class="online_payment"
                                                                type="radio" name="payment_option" checked>
                                                            <span class="d-block aiz-megabox-elem p-3 h-auto">
                                                                <img src="{{ static_asset('assets/img/cards/myfatoorah.png') }}"
                                                                    class="img-fluid mb-2">
                                                                <span class="d-block text-center">
                                                                    <span
                                                                        class="d-block fw-600 fs-15">{{ translate('MyFatoorah') }}</span>
                                                                </span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                @endif
                                            @endif
                                            @if (get_setting('cash_payment') == 1)
                                                @php
                                                    $digital = 0;
                                                    $cod_on = 1;
                                                    foreach ($carts as $cartItem) {
                                                        $product = \App\Models\Product::find($cartItem['product_id']);
                                                        if ($product['digital'] == 1) {
                                                            $digital = 1;
                                                        }
                                                        if ($product['cash_on_delivery'] == 0) {
                                                            $cod_on = 0;
                                                        }
                                                    }
                                                @endphp
                                                @if ($digital != 1 && $cod_on == 1)
                                                    <div class="col-6 col-md-4">
                                                        <label class="aiz-megabox d-block mb-3">
                                                            <input value="cash_on_delivery" class="online_payment"
                                                                type="radio" name="payment_option" checked>
                                                            <span class="d-block aiz-megabox-elem p-3 h-auto">
                                                                <img src="{{ static_asset('assets/img/cards/cod.png') }}"
                                                                    class="img-fluid mb-2">
                                                                <span class="d-block text-center">
                                                                    <span
                                                                        class="d-block fw-600 fs-15">{{ translate('COD') }}</span>
                                                                </span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                @endif
                                            @endif
                                            {{-- @if (Auth::check()) --}}
                                            @if (addon_is_activated('offline_payment'))
                                                @foreach (\App\Models\ManualPaymentMethod::all() as $method)
                                                    <div class="col-6 col-md-4">
                                                        <label class="aiz-megabox d-block mb-3">
                                                            <input value="{{ $method->heading }}" type="radio"
                                                                name="payment_option" class="offline_payment_option"
                                                                onchange="toggleManualPaymentData({{ $method->id }} , '{{ $method->type }}')"
                                                                data-id="{{ $method->id }}">
                                                            <span class="d-block aiz-megabox-elem p-3 h-auto">
                                                                <img src="{{ uploaded_asset($method->photo) }}"
                                                                    class="img-fluid mb-2">
                                                                <span class="d-block text-center">
                                                                    <span
                                                                        class="d-block fw-600 fs-15">{{ str_replace('_manual', '', $method->heading) }}</span>
                                                                </span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                @endforeach

                                                @foreach (\App\Models\ManualPaymentMethod::all() as $method)
                                                    <div id="manual_payment_info_{{ $method->id }}"
                                                        class="d-none">
                                                        @php echo $method->description @endphp
                                                        @if ($method->bank_info != null && $method->type == 'bank_payment')
                                                            @foreach (json_decode($method->bank_info) as $key => $info)
                                                                @if ($info->bank_name)
                                                                    <p>{{ translate('Bank Name') }} :
                                                                        {{ $info->bank_name }} </p>
                                                                @endif
                                                                @if ($info->account_name)
                                                                    <p>{{ translate('Account Name') }} :
                                                                        {{ $info->account_name }}</p>
                                                                @endif
                                                                @if ($info->account_number)
                                                                    <p>{{ translate('Account Number') }} :
                                                                        {{ $info->account_number }}</p>
                                                                @endif
                                                                @if ($info->routing_number)
                                                                    <p>{{ translate('Routing Number') }} :
                                                                        {{ $info->routing_number }}</p>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                @endforeach
                                            @endif
                                            {{-- @endif --}}

                                            @if (Auth::check() && get_setting('wallet_system') == 1)
                                                <div class="col-6 col-md-4">
                                                    <div class="py-2 text-center">
                                                        @if (Auth::user()->balance < $total)
                                                            <button type="button" class="btn btn-secondary" disabled>
                                                                {{ translate('Insufficient Balance') }}
                                                            </button>
                                                        @else
                                                            <button type="button" onclick="use_wallet()"
                                                                class="btn btn-primary fw-600">
                                                                {{ translate('Pay with wallet') }}
                                                            </button>
                                                        @endif

                                                        <div class="h6 mt-3">
                                                            <span
                                                                class="opacity-80">{{ translate('Wallet Balance :') }}</span>
                                                            <span
                                                                class="fw-600">{{ single_price(Auth::user()->balance) }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @if (addon_is_activated('offline_payment'))
                                    <div class="d-none mb-3 rounded border bg-white p-3 text-left">
                                        <div id="manual_payment_description"></div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>{{ translate('Transaction ID') }} <span
                                                        class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control mb-3" name="trx_id"
                                                    id="trx_id" placeholder="{{ translate('Transaction ID') }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>{{ translate('Phone') }} <span
                                                        class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control mb-3" name="trx_phone"
                                                    id="trx_phone" placeholder="{{ translate('Phone') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row" id="trx_photo_div">
                                            <label class="col-md-3 col-form-label">{{ translate('Photo') }}</label>
                                            <div class="col-md-9">
                                                <div class="input-group" data-toggle="aizuploader" data-type="image">
                                                    <div class="input-group-prepend">
                                                        <div
                                                            class="input-group-text bg-soft-secondary font-weight-medium">
                                                            {{ translate('Browse') }}</div>
                                                    </div>
                                                    <div class="form-control file-amount">
                                                        {{ translate('Choose image') }}</div>
                                                    <input type="hidden" name="photo" class="selected-files">
                                                </div>
                                                <div class="file-preview box sm">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="p-2">
                            <label class="aiz-checkbox">
                                <input type="checkbox" required id="agree_checkbox">
                                <span class="aiz-square-check"></span>
                                <span>{{ translate('I agree to the') }}</span>
                            </label>
                            <a href="{{ route('terms') }}">{{ translate('terms and conditions') }}</a>,
                            <a href="{{ route('returnpolicy') }}">{{ translate('return policy') }}</a> &
                            <a href="{{ route('privacypolicy') }}">{{ translate('privacy policy') }}</a>
                        </div>

                        <div class="row align-items-center p-2">
                            <div class="col-6">
                                <a href="{{ route('home') }}" class="link link--style-3">
                                    <i class="las la-arrow-left"></i>
                                    {{ translate('Return to shop') }}
                                </a>
                            </div>
                            <div class="col-6 text-right">
                                <button onclick="return submitOrder(event)" type="button"
                                    class="btn btn-primary fw-600">{{ translate('Confirm Order') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Address Modal -->
        @if (Auth::check())
            @include('frontend.' . get_setting('homepage_select') . '.partials.address_modal')
        @endif
    @else
        <div class="row">
            <div class="col-xl-8 mx-auto">
                <div class="border bg-white p-4">
                    <!-- Empty cart -->
                    <div class="text-center p-3">
                        <i class="las la-frown la-3x opacity-60 mb-3"></i>
                        <h3 class="h4 fw-700">{{ translate('Your Cart is empty') }}</h3>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script type="text/javascript">
    // AIZ.extra.plusMinus();
</script>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        var onlinePaymentButtons = document.querySelectorAll('.online_payment');

        onlinePaymentButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var manualPaymentDescription = document.getElementById(
                    'manual_payment_description');
                if (manualPaymentDescription) {
                    manualPaymentDescription.parentElement.classList.add('d-none');
                }
            });
        });
    });


    function coupon_toggle() {
        $('#coupon_div').slideToggle();
    }

    function addi_info_toggle() {
        $('#addi_info_div').slideToggle();
    }

    function updateQuantity(key, element) {
        calculate(key, element);
        $.post('{{ route('cart.updateQuantity') }}', {
            _token: AIZ.data.csrf,
            id: key,
            quantity: element.value
        }, function(data) {
            updateNavCart(data.nav_cart_view, data.cart_count, data.subtotal);
        });
    }

    function calculate(key, element) {
        var cart_product_id = key;
        var cart_product_quantity = parseFloat(element.value);
        var cart_product_price = parseFloat($('#product_price_' + cart_product_id).val());
        var cart_product_total = (cart_product_quantity * cart_product_price).toFixed(2);
        $('#product_total_input_' + cart_product_id).val(cart_product_total);
        $.ajax({
            url: '/calculate-price/' + cart_product_total,
            type: 'GET',
            success: function(response) {
                $('#product_total_' + cart_product_id).text(response);

                calculateTotal();
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

    function removeFromCartView(e, key) {
        e.preventDefault();
        $(e.target).closest('li').remove();
        removeFromCart(key);

        calculateTotal();
    }

    function submitOrder() {
        var el = $('#submit-button');
        el.prop('disabled', true);

        if ($('#agree_checkbox').is(":checked")) {
            var minimum_order_amount_check = {{ get_setting('minimum_order_amount_check') == 1 ? 1 : 0 }};
            var minimum_order_amount =
                {{ get_setting('minimum_order_amount_check') == 1 ? get_setting('minimum_order_amount') : 0 }};

            if (minimum_order_amount_check && $('#sub_total').val() < minimum_order_amount) {
                AIZ.plugins.notify('danger',
                    '{{ translate('You order amount is less than the minimum order amount') }}');
                el.prop('disabled', false);
            } else {
                var offline_payment_active = '{{ addon_is_activated('offline_payment') }}';
                var custom_shipping_exists = @json(!empty($custom_shippings));

                if (custom_shipping_exists && !$('input[name="custom_shipping_cost"]:checked').val()) {
                    AIZ.plugins.notify('danger', '{{ translate('You need to select a shipping option') }}');
                    el.prop('disabled', false);
                    return;
                }
                if (offline_payment_active === '1' && $('.offline_payment_option').is(":checked")) {
                    var trx_id = $('#trx_id').val().trim();
                    var trx_phone = $('#trx_phone').val().trim();

                    if (trx_id === '' && trx_phone === '') {
                        AIZ.plugins.notify('danger',
                            '{{ translate('You need to input Transaction ID or Phone Number') }}');
                        el.prop('disabled', false);
                    } else {
                        $('#checkout-form').submit(); // Submit the form
                    }
                } else {
                    $('#checkout-form').submit(); // Submit the form if offline payment is not active or not checked
                }
            }
        } else {
            AIZ.plugins.notify('danger', '{{ translate('You need to agree with our policies') }}');
            el.prop('disabled', false);
        }
    }

    function addAddressToCart(input) {
        var address_id = $(input).val();

        $.ajax({
            url: '/addAddressToCart/' + address_id,
            type: 'GET',
            success: function(response) {
                if (response.status === 'success') {
                    AIZ.plugins.notify('success', '{{ translate('Address Added to cart') }}');
                    window.location.reload();
                } else {
                    AIZ.plugins.notify('danger', '{{ translate('Failed to add address to cart') }}');
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    function updateCustomShippingCost(input) {
        var custom_shipping_cost = $(input).val();

        $.ajax({
            url: '/updateCustomShippingCost/' + custom_shipping_cost,
            type: 'GET',
            success: function(response) {
                if (response.status === 'success') {
                    // AIZ.plugins.notify('success', response.message);
                    // window.location.reload();
                    $('#shipping').val(custom_shipping_cost);
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

    function toggleManualPaymentData(id, type) {
        if (typeof id != 'undefined') {
            $('#manual_payment_description').parent().removeClass('d-none');
            if (type == 'check_payment') {
                $('#trx_photo_div').removeClass('d-none');
            } else {
                $('#trx_photo_div').addClass('d-none');
            }
            $('#manual_payment_description').html($('#manual_payment_info_' + id).html());
        }
    }
</script>
