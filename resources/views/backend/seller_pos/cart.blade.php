<div class="aiz-pos-cart-list mb-4 mt-3 c-scrollbar-light">
    @php
        $subtotal = 0;
        $tax = 0;
        $profit = 0;
        $carts = Session::get('seller_pos.products');

        $shippingType = get_business_setting('shipping_type');

        if ($shippingType == 'flat_rate') {
            $shippingCost = get_business_setting('flat_rate_shipping_cost');
            Session::put('seller_pos.shipping', $shippingCost);
        } elseif ($shippingType == 'custom_shipping') {
            $shippingInfo = get_business_setting('custom_shipping_info');
        }
    @endphp
    @if (count($carts) > 0)
        <ul class="list-group list-group-flush">
            @forelse ($carts as $key => $cartItem)
                @php
                    $product = \App\Models\Product::find($cartItem['product_id']);

                    $stock = $product->stocks->where('variant', $cartItem['variation'])->first();

                    if ($product->dropshop_price) {
                        $dropshopPriceArray = explode(',', $product->dropshop_price);
                        $firstPriceSegment = $dropshopPriceArray[0] ?? '';
                        $priceParts = explode('-', $firstPriceSegment);
                        $actual_price = end($priceParts);
                    } else {
                        $actual_price = $stock->price;
                    }

                    $subtotal += $cartItem['price'] * $cartItem['quantity'];
                    $tax += cart_product_tax($cartItem, $product, false) * $cartItem['quantity'];
                    $profit += ($cartItem['price'] - $actual_price) * $cartItem['quantity'];
                    $cartID = $key;
                @endphp
                <li class="list-group-item py-0 pl-2">
                    <div class="row gutters-5 align-items-center">
                        <div class="col-auto w-60px">
                            <div class="row no-gutters align-items-center flex-column aiz-plus-minus">
                                <button class="btn col-auto btn-icon btn-sm fs-15" type="button" data-type="plus"
                                    data-field="qty-{{ $cartID }}">
                                    <i class="las la-plus"></i>
                                </button>
                                <input type="text" name="qty-{{ $cartID }}" id="qty-{{ $cartID }}"
                                    class="col border-0 text-center flex-grow-1 fs-16 input-number" placeholder="1"
                                    value="{{ $cartItem['quantity'] }}" min="{{ $product->min_qty }}"
                                    max="{{ $stock->qty }}"
                                    onchange="updateQuantity({{ $cartID }}, this.value)">
                                <button class="btn col-auto btn-icon btn-sm fs-15" type="button" data-type="minus"
                                    data-field="qty-{{ $cartID }}">
                                    <i class="las la-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-truncate-2">{{ $product->name }}</div>
                            <span
                                class="span badge badge-inline fs-12 badge-soft-secondary">{{ $cartItem['variation'] }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="fs-12 opacity-60">
                                <input class="rounded text-center" data-cartid="{{ $cartID }}"
                                    data-actual-price="{{ $actual_price }}"
                                    onchange="updateProductPrice({{ $actual_price }})" type="number"
                                    value="{{ $cartItem['price'] }}" style="width: 50px" min="{{ $actual_price }}"> x
                                {{ $cartItem['quantity'] }}
                            </div>
                            <div class="fs-15 fw-600">{{ single_price($cartItem['price'] * $cartItem['quantity']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-circle btn-icon btn-sm btn-soft-danger ml-2 mr-0"
                                onclick="removeFromCart({{ $cartID }})">
                                <i class="las la-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                </li>
            @empty
                <li class="list-group-item">
                    <div class="text-center">
                        <i class="las la-frown la-3x opacity-50"></i>
                        <p>{{ translate('No Product Added') }}</p>
                    </div>
                </li>
            @endforelse
        </ul>
    @else
        <div class="text-center">
            <i class="las la-frown la-3x opacity-50"></i>
            <p>{{ translate('No Product Added') }}</p>
        </div>
    @endif
</div>
<div>
    <div class="d-flex justify-content-between fw-600 mb-2 bg-success text-white p-1">
        <span>{{ translate('Your Profit') }}</span>
        <input class="d-none" type="number" name="profit" id="profit" value="{{ $profit }}">
        <span>{{ single_price($profit) }}</span>
    </div>

    <div class="d-flex justify-content-between fw-600 mb-2 opacity-70">
        <span>{{ translate('Sub Total') }}</span>
        <span>{{ single_price($subtotal) }}</span>
    </div>
    <div class="d-flex justify-content-between fw-600 mb-2 opacity-70">
        <span>{{ translate('Tax') }}</span>
        <span>{{ single_price($tax) }}</span>
    </div>
    <div class="d-flex justify-content-between fw-600 mb-2 opacity-70">
        <span>{{ translate('Shipping') }}
            @if ($shippingType == 'custom_shipping')
                @foreach (json_decode($shippingInfo) as $key => $value)
                    <input name="shipping-option" class="mx-2 shipping-option" type="radio"
                        data-custom-shipping="{{ $key }}" value="{{ $value }}"
                        onchange="setShippingCost(this)"
                        {{ Session::get('seller_pos.shipping_type') == $key ? 'checked' : '' }}>
                    {{ $key . '(' . $value . ')' }}
                @endforeach
            @endif
        </span>
        <span>{{ single_price(Session::get('seller_pos.shipping', 0)) }}</span>
    </div>
    <div class="d-flex justify-content-between fw-600 mb-2 opacity-70">
        <span>{{ translate('Discount') }}</span>
        <span>{{ single_price(Session::get('seller_pos.discount', 0)) }}</span>
    </div>
    <div class="d-flex justify-content-between fw-600 fs-18 border-top pt-2">
        <span>{{ translate('Total') }}</span>
        <span>{{ single_price($subtotal + $tax + Session::get('seller_pos.shipping', 0) - Session::get('seller_pos.discount', 0)) }}</span>
    </div>
</div>
<script>
    function updateProductPrice(minPrice) {
        var cartID = event.target.getAttribute('data-cartid');
        var newPrice = event.target.value;

        if (newPrice < minPrice) {
            AIZ.plugins.notify('danger', '{{ translate('Price cannot be less than the actual price.') }}');
            event.target.value = minPrice;
            event.target.dispatchEvent(new Event('change'));
            return;
        }

        $.post('{{ route('seller_pos.updateProductPrice') }}', {
            _token: AIZ.data.csrf,
            cartId: cartID,
            price: newPrice
        }, function(data) {
            if (data.success == 1) {
                updateCart(data.view);
            } else {
                AIZ.plugins.notify('danger', data.message);
            }
        });
    }

    function setShippingCost(element) {
        var shippingCost = element.value;
        var shippingType = element.getAttribute('data-custom-shipping') || 'flat_rate';

        $.post('{{ route('seller_pos.setShipping') }}', {
            _token: AIZ.data.csrf,
            shipping: shippingCost,
            shippingType: shippingType
        }, function(data) {
            updateCart(data);
        });
    }
</script>
