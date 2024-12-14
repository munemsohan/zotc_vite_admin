<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use App\Models\CartSetting;
use App\Models\City;
use App\Models\State;
use Auth;
use App\Utility\CartUtility;
use Session;
use Cookie;
use Illuminate\Support\Facades\Artisan;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user) {
            $user_id = $user->id;

            // Merge carts of temporary user with authenticated user's cart
            if ($request->session()->has('temp_user_id')) {
                $temp_user_id = $request->session()->get('temp_user_id');
                Cart::where('temp_user_id', $temp_user_id)
                    ->update([
                        'user_id' => $user_id,
                        'temp_user_id' => null
                    ]);
                $request->session()->forget('temp_user_id');
            }

            // Retrieve carts and user address
            $carts = Cart::where('user_id', $user_id)->get();
            $address = Address::where('user_id', $user_id)->first();

            // Redirect if cart is empty
            if ($carts->isEmpty()) {
                flash(translate('Cart is Empty'))->error();
                return redirect(url('/'));
            }

            // Assign user's address to carts if not already set
            if ($carts->first()->address_id == 0 && $address) {
                foreach ($carts as $cartItem) {
                    $cartItem->address_id = $address->id;
                    $cartItem->save();
                }
            }
        } else {
            // Handle temporary user carts
            $temp_user_id = $request->session()->get('temp_user_id');
            $carts = $temp_user_id ? Cart::where('temp_user_id', $temp_user_id)->get() : collect();
        }

        // Initialize variables for totals
        $total = 0;
        $tax = 0;
        $shipping = 0;
        $subtotal = 0;

        // Calculate totals for each cart item
        foreach ($carts as $key => $cartItem) {
            $product = Product::find($cartItem->product_id);

            // Calculate tax and subtotal
            $tax += cart_product_tax($cartItem, $product, false) * $cartItem->quantity;
            $subtotal += cart_product_price($cartItem, $product, false, false) * $cartItem->quantity;

            // Determine shipping type and cost
            if (get_setting('shipping_type') == 'custom_shipping') {
                $cartItem->shipping_type = 'custom';
            } else if (get_setting('shipping_type') != 'carrier_wise_shipping' || $request['shipping_type_' . $product->user_id] == 'pickup_point') {
                if ($request['shipping_type_' . $product->user_id] == 'pickup_point') {
                    $cartItem->shipping_type = 'pickup_point';
                    $cartItem->pickup_point = $request['pickup_point_id_' . $product->user_id];
                } else {
                    $cartItem->shipping_type = 'home_delivery';
                }
                $cartItem->shipping_cost = 0;
                if ($cartItem->shipping_type == 'home_delivery') {
                    $cartItem->shipping_cost = getShippingCost($carts, $key);
                }
            } else {
                $cartItem->shipping_type = 'carrier';
                $cartItem->carrier_id = $request['carrier_id_' . $product->user_id];
                $cartItem->shipping_cost = getShippingCost($carts, $key, $cartItem->carrier_id);
            }

            // Update shipping total and save cart item
            $shipping += $cartItem->shipping_cost;
            $cartItem->save();
        }

        // Return view with carts data
        return view('frontend.view_cart', compact('carts'));
    }

    public function showCartModal(Request $request)
    {
        $product = Product::find($request->id);
        return view('frontend.' . get_setting('homepage_select') . '.partials.addToCart', compact('product'));
    }

    public function showCartModalAuction(Request $request)
    {
        $product = Product::find($request->id);
        return view('auction.frontend.addToCartAuction', compact('product'));
    }

    public function addToCart(Request $request)
    {
        if (auth()->user() != null) {
            $user_id = Auth::user()->id;
            $data['user_id'] = $user_id;
            $carts = Cart::where('user_id', $user_id)->get();
        } else {
            if ($request->session()->get('temp_user_id')) {
                $temp_user_id = $request->session()->get('temp_user_id');
            } else {
                $temp_user_id = bin2hex(random_bytes(10));
                $request->session()->put('temp_user_id', $temp_user_id);
            }
            $data['temp_user_id'] = $temp_user_id;
            $carts = Cart::where('temp_user_id', $temp_user_id)->get();
        }
        // $carts = Cart::where('user_id', auth()->user()->id)->get();

        $check_auction_in_cart = CartUtility::check_auction_in_cart($carts);
        $product = Product::find($request->id);
        $carts = array();

        if ($check_auction_in_cart && $product->auction_product == 0) {
            return array(
                'status' => 0,
                'cart_count' => count($carts),
                'modal_view' => view('frontend.' . get_setting('homepage_select') . '.partials.removeAuctionProductFromCart')->render(),
                'nav_cart_view' => view('frontend.' . get_setting('homepage_select') . '.partials.cart')->render(),
            );
        }

        $quantity = $request['quantity'];

        if ($quantity < $product->min_qty) {
            return array(
                'status' => 0,
                'cart_count' => count($carts),
                'modal_view' => view('frontend.' . get_setting('homepage_select') . '.partials.minQtyNotSatisfied', ['min_qty' => $product->min_qty])->render(),
                'nav_cart_view' => view('frontend.' . get_setting('homepage_select') . '.partials.cart')->render(),
            );
        }

        //check the color enabled or disabled for the product
        $str = CartUtility::create_cart_variant($product, $request->all());
        $product_stock = $product->stocks->where('variant', $str)->first();

        if (auth()->user() != null) {
            $user_id = Auth::user()->id;
            $cart = Cart::firstOrNew([
                'variation' => $str,
                'user_id' => $user_id,
                'product_id' => $request['id']
            ]);
        } else {
            $temp_user_id = $request->session()->get('temp_user_id');
            $cart = Cart::firstOrNew([
                'variation' => $str,
                'temp_user_id' => $temp_user_id,
                'product_id' => $request['id']
            ]);
        }
        // $cart = Cart::firstOrNew([
        //     'variation' => $str,
        //     'user_id' => auth()->user()->id,
        //     'product_id' => $request['id']
        // ]);

        if ($cart->exists && $product->digital == 0) {
            if ($product->auction_product == 1 && ($cart->product_id == $product->id)) {
                return array(
                    'status' => 0,
                    'cart_count' => count($carts),
                    'modal_view' => view('frontend.' . get_setting('homepage_select') . '.partials.auctionProductAlredayAddedCart')->render(),
                    'nav_cart_view' => view('frontend.' . get_setting('homepage_select') . '.partials.cart')->render(),
                );
            }
            if ($product_stock->qty < $cart->quantity + $request['quantity']) {
                return array(
                    'status' => 0,
                    'cart_count' => count($carts),
                    'modal_view' => view('frontend.' . get_setting('homepage_select') . '.partials.outOfStockCart')->render(),
                    'nav_cart_view' => view('frontend.' . get_setting('homepage_select') . '.partials.cart')->render(),
                );
            }
            $quantity = $cart->quantity + $request['quantity'];
        }

        $price = CartUtility::get_price($product, $product_stock, $request->quantity);
        $tax = CartUtility::tax_calculation($product, $price);

        CartUtility::save_cart_data($cart, $product, $price, $tax, $quantity);

        if (auth()->user() != null) {
            $user_id = Auth::user()->id;
            $carts = Cart::where('user_id', $user_id)->get();
        } else {
            $temp_user_id = $request->session()->get('temp_user_id');
            $carts = Cart::where('temp_user_id', $temp_user_id)->get();
        }
        // $carts = Cart::where('user_id', auth()->user()->id)->get();

        $subtotal = 0;

        foreach ($carts as $key => $cartItem) {
            $product = get_single_product($cartItem['product_id']);
            $product_stock = $product->stocks
                ->where('variant', $cartItem['variation'])
                ->first();
            $subtotal += cart_product_price($cartItem, $product, false) * $cartItem['quantity'];
            $product_name_with_choice = $product->getTranslation('name');
            if ($cartItem['variation'] != null) {
                $product_name_with_choice =
                    $product->getTranslation('name') . ' - ' . $cartItem['variation'];
            }
        }

        return array(
            'status' => 1,
            'cart_count' => count($carts),
            'subtotal' => single_price($subtotal),
            'modal_view' => view('frontend.' . get_setting('homepage_select') . '.partials.addedToCart', compact('product', 'cart'))->render(),
            'nav_cart_view' => view('frontend.' . get_setting('homepage_select') . '.partials.cart')->render(),
        );
    }

    public function productAddtocart(Request $request)
    {
        if (auth()->user() != null) {
            $user_id = Auth::user()->id;
            $data['user_id'] = $user_id;
            $carts = Cart::where('user_id', $user_id)->get();
        } else {
            if ($request->session()->get('temp_user_id')) {
                $temp_user_id = $request->session()->get('temp_user_id');
            } else {
                $temp_user_id = bin2hex(random_bytes(10));
                $request->session()->put('temp_user_id', $temp_user_id);
            }
            $data['temp_user_id'] = $temp_user_id;
            $carts = Cart::where('temp_user_id', $temp_user_id)->get();
        }
        // $carts = Cart::where('user_id', auth()->user()->id)->get();

        $check_auction_in_cart = CartUtility::check_auction_in_cart($carts);
        $product = Product::find($request->product_id);
        $carts = array();

        if ($check_auction_in_cart && $product->auction_product == 0) {
            return array(
                'status' => 0,
                'cart_count' => count($carts),
                'modal_view' => view('frontend.' . get_setting('homepage_select') . '.partials.removeAuctionProductFromCart')->render(),
                'nav_cart_view' => view('frontend.' . get_setting('homepage_select') . '.partials.cart')->render(),
            );
        }

        $quantity = $product->min_qty;

        if ($quantity < $product->min_qty) {
            return array(
                'status' => 0,
                'cart_count' => count($carts),
                'modal_view' => view('frontend.' . get_setting('homepage_select') . '.partials.minQtyNotSatisfied', ['min_qty' => $product->min_qty])->render(),
                'nav_cart_view' => view('frontend.' . get_setting('homepage_select') . '.partials.cart')->render(),
            );
        }

        //check the color enabled or disabled for the product
        $str = CartUtility::create_cart_variant($product, $request->all());
        $product_stock = $product->stocks->where('variant', $str)->first();

        if (auth()->user() != null) {
            $user_id = Auth::user()->id;
            Cart::where('user_id', $user_id)->delete();

            $cart = Cart::firstOrNew([
                'variation' => $str,
                'user_id' => $user_id,
                'product_id' => $request->product_id
            ]);
        } else {
            $user_id = $request->session()->get('temp_user_id');
            Cart::where('temp_user_id', $user_id)->delete();

            $cart = Cart::firstOrNew([
                'variation' => $str,
                'temp_user_id' => $user_id,
                'product_id' => $request->product_id
            ]);
        }

        // if ($cart->exists && $product->digital == 0) {
        //     if ($product->auction_product == 1 && ($cart->product_id == $product->id)) {
        //         return array(
        //             'status' => 0,
        //             'cart_count' => count($carts),
        //             'modal_view' => view('frontend.' . get_setting('homepage_select') . '.partials.auctionProductAlredayAddedCart')->render(),
        //             'nav_cart_view' => view('frontend.' . get_setting('homepage_select') . '.partials.cart')->render(),
        //         );
        //     }
        //     if ($product_stock->qty < $cart->quantity + $product->min_qty) {
        //         return array(
        //             'status' => 0,
        //             'cart_count' => count($carts),
        //             'modal_view' => view('frontend.' . get_setting('homepage_select') . '.partials.outOfStockCart')->render(),
        //             'nav_cart_view' => view('frontend.' . get_setting('homepage_select') . '.partials.cart')->render(),
        //         );
        //     }
        //     $quantity = $cart->quantity + $product->min_qty;
        // }

        $quantity = $product->min_qty;

        $price = CartUtility::get_price($product, $product_stock, $request->quantity);
        $tax = CartUtility::tax_calculation($product, $price);

        CartUtility::save_cart_data($cart, $product, $price, $tax, $quantity);

        if (auth()->user() != null) {
            $user_id = Auth::user()->id;
            $carts = Cart::where('user_id', $user_id)->get();
        } else {
            $temp_user_id = $request->session()->get('temp_user_id');
            $carts = Cart::where('temp_user_id', $temp_user_id)->get();
        }
        // $carts = Cart::where('user_id', auth()->user()->id)->get();

        $subtotal = 0;

        foreach ($carts as $key => $cartItem) {
            $product = get_single_product($cartItem['product_id']);
            $product_stock = $product->stocks
                ->where('variant', $cartItem['variation'])
                ->first();
            $subtotal += cart_product_price($cartItem, $product, false) * $cartItem['quantity'];
            $product_name_with_choice = $product->getTranslation('name');
            if ($cartItem['variation'] != null) {
                $product_name_with_choice =
                    $product->getTranslation('name') . ' - ' . $cartItem['variation'];
            }
        }

        return array(
            'status' => 1,
            'cart_count' => count($carts),
            'subtotal' => single_price($subtotal),
            'nav_cart_view' => view('frontend.' . get_setting('homepage_select') . '.partials.cart')->render(),
        );
    }

    //removes from Cart
    public function removeFromCart(Request $request)
    {
        Cart::destroy($request->id);
        if (auth()->user() != null) {
            $user_id = Auth::user()->id;
            $carts = Cart::where('user_id', $user_id)->get();
        } else {
            $temp_user_id = $request->session()->get('temp_user_id');
            $carts = Cart::where('temp_user_id', $temp_user_id)->get();
        }

        $subtotal = 0;

        foreach ($carts as $key => $cartItem) {
            $product = get_single_product($cartItem['product_id']);
            $product_stock = $product->stocks
                ->where('variant', $cartItem['variation'])
                ->first();
            $subtotal += cart_product_price($cartItem, $product, false) * $cartItem['quantity'];
            $product_name_with_choice = $product->getTranslation('name');
            if ($cartItem['variation'] != null) {
                $product_name_with_choice =
                    $product->getTranslation('name') . ' - ' . $cartItem['variation'];
            }
        }

        return array(
            'status' => 1,
            'cart_count' => count($carts),
            'subtotal' => single_price($subtotal),
            'nav_cart_view' => view('frontend.' . get_setting('homepage_select') . '.partials.cart')->render(),
        );
    }

    //updated the quantity for a cart item
    public function updateQuantity(Request $request)
    {
        $cartItem = Cart::findOrFail($request->id);

        if ($cartItem['id'] == $request->id) {
            $product = Product::find($cartItem['product_id']);
            $product_stock = $product->stocks->where('variant', $cartItem['variation'])->first();
            $quantity = $product_stock->qty;
            $price = $product_stock->price;

            //discount calculation
            $discount_applicable = false;

            if ($product->discount_start_date == null) {
                $discount_applicable = true;
            } elseif (
                strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
                strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date
            ) {
                $discount_applicable = true;
            }

            if ($discount_applicable) {
                if ($product->discount_type == 'percent') {
                    $price -= ($price * $product->discount) / 100;
                } elseif ($product->discount_type == 'amount') {
                    $price -= $product->discount;
                }
            }

            if ($quantity >= $request->quantity) {
                if ($request->quantity >= $product->min_qty) {
                    $cartItem['quantity'] = $request->quantity;
                }
            }

            if ($product->wholesale_product) {
                $wholesalePrice = $product_stock->wholesalePrices->where('min_qty', '<=', $request->quantity)->where('max_qty', '>=', $request->quantity)->first();
                if ($wholesalePrice) {
                    $price = $wholesalePrice->price;
                }
            }

            $cartItem['price'] = $price;
            $cartItem->save();
        }

        if (auth()->user() != null) {
            $user_id = Auth::user()->id;
            $carts = Cart::where('user_id', $user_id)->get();
        } else {
            $temp_user_id = $request->session()->get('temp_user_id');
            $carts = Cart::where('temp_user_id', $temp_user_id)->get();
        }

        $subtotal = 0;

        foreach ($carts as $key => $cartItem) {
            $product = get_single_product($cartItem['product_id']);
            $product_stock = $product->stocks
                ->where('variant', $cartItem['variation'])
                ->first();
            $subtotal += cart_product_price($cartItem, $product, false) * $cartItem['quantity'];
            $product_name_with_choice = $product->getTranslation('name');
            if ($cartItem['variation'] != null) {
                $product_name_with_choice =
                    $product->getTranslation('name') . ' - ' . $cartItem['variation'];
            }
        }

        return array(
            'cart_count' => count($carts),
            'subtotal' => single_price($subtotal),
            'nav_cart_view' => view('frontend.' . get_setting('homepage_select') . '.partials.cart')->render(),
        );
    }

    public function cartSettings()
    {
        $cartSettings = CartSetting::all();
        return view('backend.cart.settings', compact('cartSettings'));
    }

    public function cartSettingsUpdate(Request $request)
    {
        $type = $request->type;
        $value = $request->value;

        $cart_settings = CartSetting::where('type', $type)->first();

        if ($cart_settings) {
            $cart_settings->value = $value;
            $cart_settings->save();
        } else {
            $cart_settings = new CartSetting();
            $cart_settings->type = $type;
            $cart_settings->value = $value;
            $cart_settings->save();
        }

        return true;
    }

    public function calculatePrice($price)
    {
        $cart_product_total = $price;
        $single_price = single_price((int) $cart_product_total);
        return response()->json($single_price);
    }

    public function addAddressToCart(Request $request, $address_id)
    {
        if (auth()->check()) {
            $user_id = auth()->user()->id;
            $carts = Cart::where('user_id', $user_id)->get();
        } else {
            $temp_user_id = $request->session()->get('temp_user_id');
            $carts = Cart::where('temp_user_id', $temp_user_id)->get();
        }

        foreach ($carts as $cartItem) {
            $cartItem->address_id = $address_id;
            $cartItem->save();
        }


        return response()->json([
            'status' => 'success',
            'message' => 'Address added to cart items successfully',
        ]);
    }

    public function updateCustomShippingCost(Request $request, $cost)
    {
        if (auth()->check()) {
            $user_id = auth()->user()->id;
            $carts = Cart::where('user_id', $user_id)->get();
        } else {
            $temp_user_id = $request->session()->get('temp_user_id');
            $carts = Cart::where('temp_user_id', $temp_user_id)->get();
        }

        foreach ($carts as $cartItem) {
            $cartItem->shipping_cost = (float)((float)$cost / count($carts));
            $cartItem->save();
        }

        return response()->json([
            'status' => 'success',
            'shipping_cost' => single_price($cost),
            'message' => 'Shipping Cost Added',
        ]);
    }

    public function updateStateShippingCost(Request $request, $state_id)
    {

        $state = State::find($state_id);
        if ($state) {
            $cost = $state->cost;
        } else {
            $cost = 0;
        }

        if (auth()->check()) {
            $user_id = auth()->user()->id;
            $carts = Cart::where('user_id', $user_id)->get();
        } else {
            $temp_user_id = $request->session()->get('temp_user_id');
            $carts = Cart::where('temp_user_id', $temp_user_id)->get();
        }

        foreach ($carts as $cartItem) {
            $cartItem->shipping_cost = (float)((float)$cost / count($carts));
            $cartItem->save();
        }

        return response()->json([
            'status' => 'success',
            'cost' => $cost,
            'shipping_cost' => single_price($cost),
            'message' => 'Shipping Cost Added',
        ]);
    }


    public function updateCityShippingCost(Request $request, $city_id)
    {
        $city = City::find($city_id);
        if ($city) {
            $cost = $city->cost;
        } else {
            $cost = 0;
        }

        if (auth()->check()) {
            $user_id = auth()->user()->id;
            $carts = Cart::where('user_id', $user_id)->get();
        } else {
            $temp_user_id = $request->session()->get('temp_user_id');
            $carts = Cart::where('temp_user_id', $temp_user_id)->get();
        }

        foreach ($carts as $cartItem) {
            $cartItem->shipping_cost = (float)((float)$cost / count($carts));
            $cartItem->save();
        }

        return response()->json([
            'status' => 'success',
            'cost' => $cost,
            'shipping_cost' => single_price($cost),
            'message' => 'Shipping Cost Added',
        ]);
    }
}
