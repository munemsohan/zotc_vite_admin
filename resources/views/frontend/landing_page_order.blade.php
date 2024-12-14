@if (count($landingPageProduct) > 0)
    @php
        $order_minimum_payment_amount = get_setting('order_minimum_payment_amount');

        // if ($order_minimum_payment_amount <= $landingPage->product->unit_price) {
        // $minimum_payment = $order_minimum_payment_amount;
        // }

        // if ($landingPage->product->minimum_pay) {
        //     $minimum_payment += $landingPage->product->minimum_pay;
        // }

    @endphp

    <section id="order">
        <div class="container">
            <div id="placeAnOrder">
                <section id="OrderConfirmFrom" class="order_OrderConfirmFrom__eiWmc">
                    <div class="container">
                        <form id="order-form" action="{{ route('landing-pages.order_landing_page', $landingPage->slug) }}"
                            method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-5">
                                    <div id="OrderConfirmRight" class="order_OrderConfirmRight__9BH89">
                                        <h3>Your order</h3>
                                        <ul>
                                            <li>
                                                <h4>Product</h4>
                                                <h5>Subtotal</h5>
                                            </li>
                                            @foreach ($landingPage->landingPageProducts as $landingPageProduct)
                                                <li>
                                                    <div class="order_left__HNlRT order_d_flex__P2VQu">
                                                        <div id="img" class="order_img__nMxcc">
                                                            @if ($landingPageProduct->product->thumbnail)
                                                                <img src="{{ url('public/' . $landingPageProduct->product->thumbnail->file_name) }}"
                                                                    alt="{{ $landingPageProduct->product->name }}"
                                                                    style="width: 40px !important" />
                                                            @else
                                                                <img src="{{ url('public/assets/img/placeholderx200.webp') }}"
                                                                    alt="{{ $landingPageProduct->product->name }}"
                                                                    style="width: 40px !important" />
                                                            @endif
                                                        </div>
                                                        <p>{{ $landingPageProduct->product->name }}</p>
                                                    </div>
                                                    <div class="order_middle__uO4sF d-flex justify-content-between">
                                                        <input type="hidden" class="product_id" name="product_id[]"
                                                            value="{{ $landingPageProduct->product->id }}" />
                                                        <input type="hidden"
                                                            id="price_{{ $landingPageProduct->product->id }}"
                                                            name="product_price[]"
                                                            value="{{ $landingPageProduct->product->unit_price }}" />

                                                        <button type="button" class="btn btn-sm decrement-btn">
                                                            <h4 class="text-danger">-</h4>
                                                        </button>
                                                        <input class="form-control mx-1 quantity-input" type="number"
                                                            id="quantity_{{ $landingPageProduct->product->id }}"
                                                            name="quantity[]" value="1" />
                                                        <button type="button" class="btn btn-sm increment-btn">
                                                            <h4 class="text-success">+</h4>
                                                        </button>
                                                    </div>
                                                    <div class="order_right__uO4sF text-center">
                                                        <h5> ৳ {{ $landingPageProduct->product->unit_price }}</h5>
                                                    </div>
                                                </li>
                                            @endforeach
                                            <li>
                                                <h5>Subtotal</h5>
                                                <h5>৳ <span id="subtotal">0</span>
                                                </h5>
                                            </li>
                                            <li>
                                                <h5>Shipping</h5>
                                                <h5>
                                                    @php
                                                        $shipping_info = json_decode($landingPage->shipping_info, true);
                                                        $index = 0;
                                                    @endphp

                                                    @if ($shipping_info)
                                                        @foreach ($shipping_info as $key => $value)
                                                            <div id="checkbox_{{ $index }}"
                                                                class="order_checkbox__TScFd order_d_flex__P2VQu">
                                                                <input type="radio" name="shipping"
                                                                    id="shipping_{{ $index }}"
                                                                    value="{{ $value }}"
                                                                    {{ $index == 0 ? 'checked' : '' }} />
                                                                <label
                                                                    for="shipping_{{ $index }}">{{ $key }}
                                                                    : ৳ {{ $value }}</label>
                                                            </div>
                                                            @php
                                                                $index++;
                                                            @endphp
                                                        @endforeach
                                                    @else
                                                        <p>No shipping information available.</p>
                                                    @endif

                                                </h5>
                                            </li>
                                            <li>
                                                <h4>Total</h4>
                                                <h4>৳ <span id="total">0</span>
                                                </h4>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div id="OrderConfirmLeft" class="order_OrderConfirmLeft__HZHqT">
                                        <h3>Billing details</h3>
                                        <div class="order_CustomeInput__k6j_b">
                                            <input type="text" name="name" placeholder="আপনার নাম লিখুন *"
                                                required />
                                        </div>
                                        <div class="order_CustomeInput__k6j_b">
                                            <input type="number" name="phone"
                                                placeholder="আপনার মোবাইল নাম্বার লিখুন *" required />
                                        </div>
                                        <div class="order_CustomeInput__k6j_b">
                                            <input type="text" name="address"
                                                placeholder="আপনার সম্পূর্ণ ঠিকানা লিখুন *" required />
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-6">
                                                <button type="button" id="pay_full"
                                                    class="btn p-2 btn-outline-success border border-success payment-option"
                                                    value="full">
                                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                                        viewBox="0 0 24 24" height="1em" width="1em"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M4.00436 6.41662L0.761719 3.17398L2.17593 1.75977L5.41857 5.00241H20.6603C21.2126 5.00241 21.6603 5.45012 21.6603 6.00241C21.6603 6.09973 21.6461 6.19653 21.6182 6.28975L19.2182 14.2898C19.0913 14.7127 18.7019 15.0024 18.2603 15.0024H6.00436V17.0024H17.0044V19.0024H5.00436C4.45207 19.0024 4.00436 18.5547 4.00436 18.0024V6.41662ZM6.00436 7.00241V13.0024H17.5163L19.3163 7.00241H6.00436ZM5.50436 23.0024C4.67593 23.0024 4.00436 22.3308 4.00436 21.5024C4.00436 20.674 4.67593 20.0024 5.50436 20.0024C6.33279 20.0024 7.00436 20.674 7.00436 21.5024C7.00436 22.3308 6.33279 23.0024 5.50436 23.0024ZM17.5044 23.0024C16.6759 23.0024 16.0044 22.3308 16.0044 21.5024C16.0044 20.674 16.6759 20.0024 17.5044 20.0024C18.3328 20.0024 19.0044 20.674 19.0044 21.5024C19.0044 22.3308 18.3328 23.0024 17.5044 23.0024Z">
                                                        </path>
                                                    </svg> Pay Full Amount
                                                    <span id="orderTotal">0</span>
                                                    BDT
                                                </button>
                                            </div>

                                            {{-- @if ($minimum_payment > 0) --}}
                                            <div class="col-6">
                                                <button type="button" id="pay_minimum"
                                                    class="btn p-2 btn-outline-danger border border-danger payment-option"
                                                    value="minimum">
                                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                                        viewBox="0 0 24 24" height="1em" width="1em"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M4.00436 6.41662L0.761719 3.17398L2.17593 1.75977L5.41857 5.00241H20.6603C21.2126 5.00241 21.6603 5.45012 21.6603 6.00241C21.6603 6.09973 21.6461 6.19653 21.6182 6.28975L19.2182 14.2898C19.0913 14.7127 18.7019 15.0024 18.2603 15.0024H6.00436V17.0024H17.0044V19.0024H5.00436C4.45207 19.0024 4.00436 18.5547 4.00436 18.0024V6.41662ZM6.00436 7.00241V13.0024H17.5163L19.3163 7.00241H6.00436ZM5.50436 23.0024C4.67593 23.0024 4.00436 22.3308 4.00436 21.5024C4.00436 20.674 4.67593 20.0024 5.50436 20.0024C6.33279 20.0024 7.00436 20.674 7.00436 21.5024C7.00436 22.3308 6.33279 23.0024 5.50436 23.0024ZM17.5044 23.0024C16.6759 23.0024 16.0044 22.3308 16.0044 21.5024C16.0044 20.674 16.6759 20.0024 17.5044 20.0024C18.3328 20.0024 19.0044 20.674 19.0044 21.5024C19.0044 22.3308 18.3328 23.0024 17.5044 23.0024Z">
                                                        </path>
                                                    </svg> Pay Minimum
                                                    <span id="orderMinimum">0</span> BDT
                                                </button>
                                            </div>
                                            {{-- @endif --}}
                                        </div>

                                        <div class="row mt-1" id="payment_div" style="display: none">
                                            <div class="col-12">
                                                <h3 class="my-2">Payment By</h3>
                                            </div>

                                            @if (get_setting('bkash') == 1)
                                                <div class="col-6 col-md-4">
                                                    <label class="aiz-megabox d-block mb-3 border rounded">
                                                        <input value="bkash" class="online_payment" type="radio"
                                                            name="payment_option">
                                                        <span class="d-block aiz-megabox-elem p-3">
                                                            <img src="{{ url('public/assets/img/cards/bkash.png') }}"
                                                                class="img-fluid mb-2" width="100%">
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
                                                        <input value="nagad" class="online_payment" type="radio"
                                                            name="payment_option">
                                                        <span class="d-block aiz-megabox-elem p-3">
                                                            <img src="{{ url('public/assets/img/cards/nagad.png') }}"
                                                                class="img-fluid mb-2" width="100%">
                                                            <span class="d-block text-center">
                                                                <span class="d-block fw-bold fs-15">Nagad</span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                            @if (get_setting('paypal_payment') == 1)
                                                <div class="col-6 col-md-4">
                                                    <label class="aiz-megabox d-block mb-3 border rounded">
                                                        <input value="paypal" class="online_payment" type="radio"
                                                            name="payment_option">
                                                        <span class="d-block aiz-megabox-elem p-3">
                                                            <img src="{{ url('public/assets/img/cards/paypal.png') }}"
                                                                class="img-fluid mb-2" width="100%">
                                                            <span class="d-block text-center">
                                                                <span class="d-block fw-bold fs-15">Paypal</span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                            @if (get_setting('cash_payment'))
                                                <div class="col-6 col-md-4" id="cod_payment" style="display: none">
                                                    <label class="aiz-megabox d-block mb-3 border rounded">
                                                        <input value="cash_on_delivery" class="online_payment"
                                                            type="radio" name="payment_option">
                                                        <span class="d-block aiz-megabox-elem p-3">
                                                            <img src="{{ url('public/assets/img/cards/cod.png') }}"
                                                                class="img-fluid mb-2" width="100%">
                                                            <span class="d-block text-center">
                                                                <span class="d-block fw-bold fs-15">Cash On
                                                                    Delivery</span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="payment_type" name="payment_type">
                            <button class="d-none" type="submit" id="submit">Submit</button>
                        </form>
                    </div>
                </section>
            </div>
        </div>
        <!-- Confirm Modal -->
        <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmModalLabel">Confirm Order
                        </h5>
                        <button type="button" class="btn btn-sm btn-danger cancelOrder" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to confirm the order?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary cancelOrder"
                            data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="confirmSubmit">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {

            calculateTotal();

            function calculateTotal() {
                var subtotal = 0;

                $('.product_id').each(function() {
                    var product_id = $(this).val();
                    var price = parseInt($('#price_' + product_id).val());
                    var quantity = parseInt($('#quantity_' + product_id).val());

                    subtotal += price * quantity;
                });

                $('#subtotal').text(subtotal);

                var shippingCost = 0;
                if ($('input[name="shipping"]').is(':checked')) {
                    shippingCost = parseInt($('input[name="shipping"]:checked').val());

                    $('#pay_full, #pay_minimum').prop('disabled', false);
                } else {
                    $('#pay_full, #pay_minimum').prop('disabled', true);
                }

                var total = subtotal + shippingCost;

                $('#total, #orderTotal').html(total);

                var minimumTotal = 0;
                var order_minimum_payment_amount = parseInt('{{ $order_minimum_payment_amount }}');

                if (order_minimum_payment_amount > 0) {
                    minimumTotal += order_minimum_payment_amount;
                }

                var landingPageProducts = {!! json_encode($landingPage->landingPageProducts) !!};

                for (let i = 0; i < landingPageProducts.length; i++) {
                    var product_minimum_pay = parseInt(landingPageProducts[i].product.minimum_pay);

                    // var minimum_pay_with_shipping = parseInt(landingPageProducts[i].product
                    //     .minimum_pay_with_shipping);

                    var minimum_pay_each_product = parseInt(landingPageProducts[i].product
                        .minimum_pay_each_product);


                    var quantity = parseInt($('#quantity_' + landingPageProducts[i].product.id)
                        .val());

                    if (minimum_pay_each_product === 1) {
                        minimumTotal += quantity * product_minimum_pay;
                    } else {
                        minimumTotal += product_minimum_pay;
                    }
                }

                minimumTotal += shippingCost;

                $('#orderMinimum').html(minimumTotal);
            }

            $('input[name="quantity"], input[name="shipping"]').change(function() {
                calculateTotal();
            });

            $('.payment-option').click(function() {
                $('.payment-option').removeClass('active');
                $(this).addClass('active');

                var paymentType = $(this).val();
                $('#payment_type').val(paymentType);
            });

            $('#pay_full').click(function() {
                $('#cod_payment').slideDown();
                $('#payment_div').slideDown();
            });

            $('#pay_minimum').click(function() {
                $('#cod_payment').slideUp();
                $('#payment_div').slideDown();
            });

            function showModal() {
                $('#confirmModal').modal('show');
            }

            $('.online_payment').on('change click', function() {
                showModal();
            });

            $('#confirmSubmit').click(function() {
                $('#confirmModal').modal('hide');
                $('#submit').click();
            });

            $('.cancelOrder').click(function() {
                $('#confirmModal').modal('hide');
            });

            $(".increment-btn").click(function() {
                var inputField = $(this).siblings('.quantity-input');
                var currentQuantity = parseInt(inputField.val());
                inputField.val(currentQuantity + 1);

                calculateTotal();
            });

            $(".decrement-btn").click(function() {
                var inputField = $(this).siblings('.quantity-input');
                var currentQuantity = parseInt(inputField.val());
                if (currentQuantity > 1) {
                    inputField.val(currentQuantity - 1);
                }

                calculateTotal();
            });

        });
    </script>
@endif
