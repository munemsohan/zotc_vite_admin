@if (count($landingPage->landingPageProducts) > 0)
    <link rel="stylesheet" href="{{ url('public/modules/zillapage/order.css') }}">

    @php
        $order_minimum_payment_amount = get_setting('order_minimum_payment_amount');

        // if ($order_minimum_payment_amount <= $landingPage->product->unit_price) {
        // $minimum_payment = $order_minimum_payment_amount;
        // }

        // if ($landingPage->product->minimum_pay) {
        //     $minimum_payment += $landingPage->product->minimum_pay;
        // }

    @endphp

    <!-- Product Order Section -->
    <form id="order-form" action="{{ route('landing-pages.order_landing_page', $landingPage->slug) }}" method="POST">
        @csrf
        <section class="checkout-section m-5">
            <div class="checkout-right">
                <h3 class="section-title">Your order</h3>
                <ul class="order-summary">
                    <li class="order-item order-header">
                        <h4>Product</h4>
                        <h4>Subtotal</h4>
                    </li>
                    @foreach ($landingPage->landingPageProducts as $landingPageProduct)
                        <li class="order-item">
                            <div class="product-info">
                                @if ($landingPageProduct->product->thumbnail)
                                    <img src="{{ url('public/' . $landingPageProduct->product->thumbnail->file_name) }}"
                                        alt="{{ $landingPageProduct->product->name }}" class="product-image" />
                                @else
                                    <img src="{{ url('public/assets/img/placeholderx200.webp') }}"
                                        alt="{{ $landingPageProduct->product->name }}" class="product-image" />
                                @endif
                                <p>{{ $landingPageProduct->product->name }}</p>
                            </div>
                            <div class="product-price">
                                <button type="button" class="minus-box">-</button>
                                <input type="number" name="quantity[]" class="product-quantity" value="1"
                                    min="1">
                                <button type="button" class="plus-box">+</button>
                                <input type="hidden" name="product_id[]"
                                    value="{{ $landingPageProduct->product->id }}">
                                <input class="amount" type="hidden"
                                    value="{{ $landingPageProduct->product->unit_price }}">
                                <span class="price">৳ {{ $landingPageProduct->product->unit_price }}</span>
                            </div>
                        </li>
                    @endforeach
                    <li class="order-item">
                        <span>Subtotal</span>
                        <span> ৳ <span class="subtotal-price"></span></span>
                    </li>
                    <li class="order-item">
                        <span>Shipping</span>
                        <div class="shipping-options">
                            @foreach (json_decode($landingPage->shipping_info, true) as $key => $value)
                                <div class="shipping-option">
                                    <input type="radio" id="shipping-{{ $key }}" name="shipping"
                                        value="{{ $value }}" required>
                                    <label for="shipping-{{ $key }}">{{ $key }}: ৳
                                        {{ $value }}</label>
                                </div>
                            @endforeach
                        </div>
                    </li>
                    <li class="order-item order-total">
                        <span>Total</span>
                        <span> ৳ <span class="total-price"></span></span>
                    </li>
                </ul>
            </div>

            <!-- Billing details -->
            <div class="checkout-left">
                <h3 class="section-title">Billing details</h3>
                <div class="form-group">
                    <input type="text" name="name" class="form-control" placeholder="আপনার নাম লিখুন *" required>
                </div>
                <div class="form-group">
                    <input type="text" name="phone" class="form-control" placeholder="আপনার মোবাইল নাম্বার লিখুন *"
                        required>
                </div>
                <div class="form-group">
                    <textarea name="address" class="form-control" cols="30" rows="5" placeholder="আপনার সম্পূর্ণ ঠিকানা লিখুন *"
                        required></textarea>
                </div>

                <!-- Payment Section -->
                <div class="payment-section">
                    <button type="button" class="payment-button1 pay-btn" data-payment-type="full">
                        Pay Full Amount ৳ <b class="total-payment"></b>
                    </button>
                    <button type="button" class="payment-button2 pay-btn" data-payment-type="minimum">
                        Pay Minimum ৳ <b>{{ $order_minimum_payment_amount }}</b>
                    </button>
                </div>
                <div class="payment-options" id="payment-options" style="display: none;">
                    <h3>Select Payment Method</h3>
                    <div class="row mt-1" id="payment_div">
                        @if (get_setting('bkash') == 1)
                            <div class="col-6 col-md-4">
                                <label class="aiz-megabox d-block mb-3 border rounded">
                                    <input value="bkash" class="online_payment" type="radio" name="payment_option">
                                    <span class="d-block aiz-megabox-elem p-3">
                                        <img src="https://seeklogo.com/images/B/bkash-logo-FBB258B90F-seeklogo.com.png"
                                            alt="Bkash" class="img-fluid mb-2" width="100%">
                                        <span class="d-block text-center">
                                            <span class="d-block fw-bold fs-15">Bkash</span>
                                        </span>
                                    </span>
                                </label>
                            </div>
                        @endif

                        @if (get_setting('nagad') == 1)
                            <div class="col-6 col-md-4">
                                <label class="aiz-megabox d-block mb-3 border rounded">
                                    <input value="nagad" class="online_payment" type="radio" name="payment_option">
                                    <span class="d-block aiz-megabox-elem p-3">
                                        <img src="https://seeklogo.com/images/N/nagad-logo-7A70CCFEE0-seeklogo.com.png"
                                            alt="Nagad" class="img-fluid mb-2" width="100%">
                                        <span class="d-block text-center">
                                            <span class="d-block fw-bold fs-15">Nagad</span>
                                        </span>
                                    </span>
                                </label>
                            </div>
                        @endif

                        @if (get_setting('rocket') == 1)
                            <div class="col-6 col-md-4">
                                <label class="aiz-megabox d-block mb-3 border rounded">
                                    <input value="rocket" class="online_payment" type="radio"
                                        name="payment_option">
                                    <span class="d-block aiz-megabox-elem p-3">
                                        <img src="https://seeklogo.com/images/D/dutch-bangla-rocket-logo-B4D1CC458D-seeklogo.com.png"
                                            alt="Rocket" class="img-fluid mb-2" width="100%">
                                        <span class="d-block text-center">
                                            <span class="d-block fw-bold fs-15">Rocket</span>
                                        </span>
                                    </span>
                                </label>
                            </div>
                        @endif

                        @if (get_setting('cash_payment'))
                            <div class="col-6 col-md-4" id="cod_payment">
                                <label class="aiz-megabox d-block mb-3 border rounded">
                                    <input value="cash_on_delivery" class="online_payment" type="radio"
                                        name="payment_option">
                                    <span class="d-block aiz-megabox-elem p-3">
                                        <img src="{{ url('public/assets/img/cards/cod.png') }}"
                                            alt="Cash On Delivery" class="img-fluid mb-2" width="100%">
                                        <span class="d-block text-center">
                                            <span class="d-block fw-bold fs-15">Cash On Delivery</span>
                                        </span>
                                    </span>
                                </label>
                            </div>
                        @endif
                    </div>

                    <input type="hidden" id="payment_type" name="payment_type">
                    <button type="submit" class="btn btn-success">Complete Order</button>
                </div>
            </div>
        </section>
    </form>

    <script src="{{ url('public/modules/zillapage/order.js') }}"></script>
@endif
