<?php

namespace App\Utility;

use App\Models\ProductStock;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Country;
use App\Models\SellerPendingBalance;
use App\Models\State;
use App\Models\City;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Session;
use Mail;
use App\Mail\InvoiceEmailManager;
use App\Models\User;

class SellerPosUtility
{
    public static function product_search($request_data): object
    {
        // Base query with necessary joins
        $product_query = ProductStock::query()
            ->join('products', 'product_stocks.product_id', '=', 'products.id')
            ->where([
                ['products.auction_product', 0],
                ['products.wholesale_product', 0],
                ['products.published', 1],
                ['products.approved', 1]
            ])
            ->select(
                'products.*',
                'product_stocks.id as stock_id',
                'product_stocks.variant',
                'product_stocks.price as stock_price',
                'product_stocks.qty as stock_qty',
                'product_stocks.image as stock_image'
            );

        // Filter by user type (Seller or Admin)
        if (auth()->user()->user_type === 'seller') {
            $product_query->where(function ($query) {
                $query->where('products.user_id', auth()->id());

                if (get_business_setting('reseller_system_activation')) {
                    $query->orWhere('products.added_by', 'admin');
                }
            });
        }

        // Apply filters dynamically using `when()`
        $product_query->when(!empty($request_data['category']), function ($query) use ($request_data) {
            $arr = explode('-', $request_data['category']);
            if ($arr[0] === 'category') {
                $category_ids = CategoryUtility::children_ids($arr[1]);
                $category_ids[] = $arr[1];
                $query->whereIn('products.category_id', $category_ids);
            }
        });

        $product_query->when(
            !empty($request_data['brand']),
            fn($query) =>
            $query->where('products.brand_id', $request_data['brand'])
        );

        // Keyword search (Product Name or Barcode)
        $product_query->when(!empty($request_data['keyword']), function ($query) use ($request_data) {
            $query->where(function ($q) use ($request_data) {
                $q->where('products.name', 'like', "%{$request_data['keyword']}%")
                    ->orWhere('products.barcode', $request_data['keyword']);
            });
        });

        return $product_query->orderByDesc('products.created_at')->paginate(16);
    }

    public static function get_shipping_address($request): array
    {
        $data = [
            'name' => $request->name ?? '',
            'email' => $request->email ?? '',
            'address' => $request->address ?? '',
            'country' => '',
            'state' => '',
            'city' => '',
            'postal_code' => $request->postal_code ?? '',
            'phone' => $request->phone ?? ''
        ];

        if ($request->address_id != null) {
            $address = Address::findOrFail($request->address_id);
            $data['name'] = $address->user->name;
            $data['email'] = $address->user->email;
            $data['address'] = $address->address;
            $data['country'] = $address->country->name;
            $data['state'] = $address->state->name;
            $data['city'] = $address->city->name;
            $data['postal_code'] = $address->postal_code;
            $data['phone'] = $address->phone;
        } else {
            if ($request->country_id) {
                $data['country'] = Country::find($request->country_id)->name ?? '';
            }
            if ($request->state_id) {
                $data['state'] = State::find($request->state_id)->name ?? '';
            }
            if ($request->city_id) {
                $data['city'] = City::find($request->city_id)->name ?? '';
            }
        }

        return $data;
    }
    public static function addToCart($stockId, $userID, $temUserId)
    {
        $productStock = ProductStock::find($stockId);
        $product = $productStock->product;
        $quantity = $product->min_qty;

        if ($productStock->qty < $product->min_qty && $product->digital == 0) {
            return array(
                'success' => 0,
                'message' => translate("This product doesn't have enough stock for minimum purchase quantity ") . $product->min_qty
            );
        }

        $cartItem = [
            'variation' => $productStock->variant,
            'user_id' => $userID,
            'temp_user_id' => $temUserId,
            'product_id' => $product->id,
            'quantity' => $quantity,
            'actual_price' => $productStock->price,
            'price' => 0,
            'tax' => 0,
            'total' => 0
        ];

        if ($product->dropshop_price) {
            $dropshopPriceArray = explode(',', $product->dropshop_price);
            $firstPriceSegment = $dropshopPriceArray[0] ?? '';
            $priceParts = explode('-', $firstPriceSegment);
            $cartItem['price'] = end($priceParts);
        } else {
            $cartItem['price'] = CartUtility::get_price($product, $productStock, 1);
        }

        $cartItem['tax'] = CartUtility::tax_calculation($product, $cartItem['price']);
        $cartItem['total'] = $cartItem['price'] * $cartItem['quantity'];

        $existingCart = Session::get('seller_pos.products', []);
        $found = false;

        foreach ($existingCart as &$item) {
            if ($item['product_id'] == $cartItem['product_id'] && $item['variation'] == $cartItem['variation']) {
                $item['quantity'] += $cartItem['quantity'];
                if ($product->dropshop_price) {
                    $dropshopPriceArray = explode(',', $product->dropshop_price);
                    $firstPriceSegment = $dropshopPriceArray[0] ?? '';
                    $priceParts = explode('-', $firstPriceSegment);
                    $item['price'] = end($priceParts);
                } else {
                    $item['price'] = CartUtility::get_price($product, $productStock, $item['quantity']);
                }
                $item['tax'] = CartUtility::tax_calculation($product, $item['price']);
                $item['total'] = $item['price'] * $item['quantity'];
                $found = true;
                break;
            }
        }

        if (!$found) {
            $existingCart[] = $cartItem;
        }

        Session::put('seller_pos.products', $existingCart);

        return array('success' => 1, 'message' => 'Added to cart successfully');
    }

    public static function updateCartItemQuantity($cartID, $quantity)
    {
        $carts = Session::get('seller_pos.products', []);

        if (!isset($carts[$cartID])) {
            return [
                'success' => 0,
                'message' => translate("Product not found in cart.")
            ];
        }

        $cartItem = &$carts[$cartID]; // Use reference to modify directly

        $product = Product::find($cartItem['product_id']);
        if (!$product) {
            return [
                'success' => 0,
                'message' => translate("Product does not exist.")
            ];
        }

        $productStock = ProductStock::where('product_id', $product->id)
            ->where('variant', $cartItem['variation'])
            ->first();

        if (!$productStock || $productStock->qty < $quantity) {
            return [
                'success' => 0,
                'message' => translate("This product doesn't have more stock.")
            ];
        }

        // Just update quantity and total price, keeping existing price
        $cartItem['quantity'] = $quantity;
        $cartItem['total'] = $cartItem['price'] * $cartItem['quantity']; // Keep the same price

        // Update session
        Session::put('seller_pos.products', $carts);

        return [
            'success' => 1,
            'message' => translate("Updated the item successfully.")
        ];
    }


    public static function updateCartItemPrice($cartID, $price)
    {
        $carts = Session::get('seller_pos.products', []);
        if (isset($carts[$cartID])) {
            $carts[$cartID]['price'] = $price;
            $carts[$cartID]['total'] = $carts[$cartID]['price'] * $carts[$cartID]['quantity'];
            Session::put('seller_pos.products', $carts);
            return [
                'success' => 1,
                'message' => translate("Updated the price successfully.")
            ];
        }
        return [
            'success' => 0,
            'message' => translate("Product not found in cart.")
        ];
    }

    public static function removeFromCart($cartID)
    {
        $carts = Session::get('seller_pos.products', []);
        if (isset($carts[$cartID])) {
            unset($carts[$cartID]);
            Session::put('seller_pos.products', $carts);
            return [
                'success' => 1,
                'message' => translate("Removed the item successfully.")
            ];
        }
        return [
            'success' => 0,
            'message' => translate("Product not found in cart.")
        ];
    }

    public static function updateCartOnUserChange($data)
    {
        $userID             = $data['userId'];
        $sessionUserId      = Session::has('pos.user_id') ? Session::get('pos.user_id') : null;
        $sessionTemUserId   = Session::has('pos.temp_user_id') ? Session::get('pos.temp_user_id') : null;
        $carts              = get_pos_user_cart();

        // If user is selected but user not in session or Session user is not this user, set it to session
        if ($userID) {
            if ($carts) {
                self::updatePosUserCartData($carts, $userID, null);
            }

            if (!$sessionUserId || ($sessionUserId != $userID)) {
                Session::put('pos.user_id', $userID);
            }
            Session::forget('pos.temp_user_id');
        }

        // If user is not selected, and if session has not Temp user ID, get it or set it
        if (!$userID) {
            if (!$sessionTemUserId) {
                $sessionTemUserId = bin2hex(random_bytes(10));
                Session::put('pos.temp_user_id', $sessionTemUserId);
            }
            if ($carts) {
                self::updatePosUserCartData($carts, null, $sessionTemUserId);
            }
            Session::forget('pos.user_id');
        }
    }

    public static function updatePosUserCartData($carts, $userID, $tempUsderID)
    {
        foreach ($carts as $cartItem) {
            $userCartItem = Cart::where('user_id', $userID)->where('temp_user_id', $tempUsderID)->where('product_id', $cartItem->product_id)->where('variation', $cartItem->variation)->first();
            if ($userCartItem) {
                $quantity = $userCartItem->quantity + $cartItem->quantity;
                $product_qty = $cartItem->product->stocks()->where('variant', $cartItem->$cartItem)->first();
                $quantity = $product_qty > $quantity ? $product_qty : $quantity;

                $userCartItem->update(['quantity' => $quantity]);
                $cartItem->delete();
            } else {
                $cartItem->update(['user_id' => $userID, 'temp_user_id' => $tempUsderID]);
            }
        }
    }

    public static function orderStore($data)
    {
        // If seller_id doesn't exist then return error
        if (!isset($data['seller_id'])) {
            return array('success' => 0, 'message' => translate("Please select a product."));
        }

        $shippingInfo = $data['shippingInfo'];

        // Correct this code, if user_id exists
        if (isset($data['user_id']) && is_null($shippingInfo)) {
            $address = Address::find($data['shipping_address']);
            if (is_null($address)) {
                return array('success' => 0, 'message' => translate("Please Add Shipping Information."));
            }
            $shippingInfo = [
                'name' => $address->user->name,
                'email' => $address->user->email,
                'address' => $address->address,
                'country' => $address->country->name,
                'state' => $address->state->name,
                'city' => $address->city->name,
                'postal_code' => $address->postal_code,
                'phone' => $address->phone
            ];
        }

        if (!is_null($data['user_id']) && (is_null($shippingInfo) || is_null($shippingInfo['name']) || is_null($shippingInfo['phone']) || is_null($shippingInfo['address']))) {
            return array('success' => 0, 'message' => translate("Please Add Shipping Information."));
        } else {
            $carts = Session::get('seller_pos.products', []);
            if (count($carts) > 0) {
                $order = new Order();
                $userId = $data['user_id'];
                if ($userId == null) {
                    $order->guest_id  = $carts[0]['temp_user_id'];
                } else {
                    $order->user_id = $userId;
                }
                $order->shipping_address = json_encode($shippingInfo);

                $order->payment_type    = $data['payment_type'];
                $order->delivery_viewed = '0';
                $order->payment_status_viewed = '0';
                $order->date            = strtotime('now');
                $order->payment_status  = $data['payment_type'] != 'cash_on_delivery' ? 'paid' : 'unpaid';
                $order->payment_details = $data['payment_type'];
                $order->order_from      = $data['order_from'];

                if ($data['payment_type'] == 'offline_payment') {
                    if ($data['offline_trx_id'] == null) {
                        return array('success' => 0, 'message' => translate("Transaction ID cannot be null."));
                    }
                    $offlinePaymentData = [
                        'name'   => $data['offline_payment_method'],
                        'amount' => $data['offline_payment_amount'],
                        'trx_id' => $data['offline_trx_id'],
                        'photo'  => $data['offline_payment_proof']
                    ];
                    $order->manual_payment_data = json_encode($offlinePaymentData);
                    $order->manual_payment = 1;
                }

                if ($order->save()) {
                    $id = $order->id;
                    $remaining_digits = 8 - strlen($id);
                    $random_number = rand(pow(10, $remaining_digits - 1), pow(10, $remaining_digits) - 1);
                    $order->code = $random_number . $id;
                    $order->save();

                    $subtotal = 0;
                    $tax = 0;
                    foreach ($carts as $cartItem) {
                        $product_stock = ProductStock::where('product_id', $cartItem['product_id'])
                            ->where('variant', $cartItem['variation'])
                            ->first();
                        $product = $product_stock->product;
                        $product_variation = $product_stock->variant;

                        $subtotal += $cartItem['price'] * $cartItem['quantity'];
                        $tax += $cartItem['tax'] * $cartItem['quantity'];

                        if ($product->digital == 0) {
                            if ($cartItem['quantity'] > $product_stock->qty) {
                                $order->delete();
                                return array('success' => 0, 'message' => $product->name . ' (' . $product_variation . ') ' . translate(" just stock outs."));
                            } else {
                                $product_stock->qty -= $cartItem['quantity'];
                                $product_stock->save();
                            }
                        }

                        $order_detail = new OrderDetail;
                        $order_detail->order_id = $order->id;
                        $order_detail->seller_id = $product->user_id;
                        $order_detail->product_id = $product->id;
                        $order_detail->payment_status = $data['payment_type'] != 'cash_on_delivery' ? 'paid' : 'unpaid';
                        $order_detail->variation = $product_variation;
                        $order_detail->price = $cartItem['price'] * $cartItem['quantity'];
                        $order_detail->tax = $cartItem['tax'] * $cartItem['quantity'];
                        $order_detail->quantity = $cartItem['quantity'];
                        $order_detail->shipping_type = null;

                        if ($data['shippingCost'] >= 0) {
                            $order_detail->shipping_cost = $data['shippingCost'] / count($carts);
                        } else {
                            $order_detail->shipping_cost = 0;
                        }

                        $order_detail->save();

                        $product->num_of_sale++;
                        $product->save();
                    }

                    $order->grand_total = $subtotal + $tax + $data['shippingCost'];

                    if ($data['discount']) {
                        $order->grand_total -= $data['discount'];
                        $order->coupon_discount = $data['discount'];
                    }

                    $order->seller_id = $product->user_id;
                    $order->save();

                    $array['view'] = 'emails.invoice';
                    $array['subject'] = 'Your order has been placed - ' . $order->code;
                    $array['from'] = env('MAIL_USERNAME');
                    $array['order'] = $order;

                    $admin_products = array();
                    $seller_products = array();

                    foreach ($order->orderDetails as $orderDetail) {
                        if ($orderDetail->product->added_by == 'admin') {
                            array_push($admin_products, $orderDetail->product->id);
                        } else {
                            $product_ids = array();
                            if (array_key_exists($orderDetail->product->user_id, $seller_products)) {
                                $product_ids = $seller_products[$orderDetail->product->user_id];
                            }
                            array_push($product_ids, $orderDetail->product->id);
                            $seller_products[$orderDetail->product->user_id] = $product_ids;
                        }
                    }

                    foreach ($seller_products as $key => $seller_product) {
                        try {
                            Mail::to(User::find($key)->email)->queue(new InvoiceEmailManager($array));
                        } catch (\Exception $e) {
                        }
                    }

                    if ($data['profit'] > 0) {
                        // Add new row to seller_pending_balances table
                        SellerPendingBalance::create([
                            'order_id' => $order->id,
                            'amount' => $data['profit']
                        ]);

                        $seller = User::find($data['seller_id']);

                        if ($seller) {
                            $seller->pending_balance += $data['profit'];
                            $seller->save();
                        }
                    }

                    // Sends email to customer with the invoice pdf attached
                    if (env('MAIL_USERNAME') != null) {
                        try {
                            Mail::to($shippingInfo['email'])->queue(new InvoiceEmailManager($array));
                            Mail::to(User::where('user_type', 'admin')->first()->email)->queue(new InvoiceEmailManager($array));
                        } catch (\Exception $e) {
                        }
                    }

                    if ($userId != NULL && $order->payment_status == 'paid') {
                        calculateCommissionAffilationClubPoint($order);
                    }

                    Cart::where('user_id', $order->user_id)->orWhere('temp_user_id', $order->guest_id)->delete();

                    return array('success' => 1, 'message' => translate('Order Completed Successfully.'));
                } else {
                    return array('success' => 0, 'message' => translate('Please input customer information.'));
                }
            }
            return array('success' => 0, 'message' => translate("Please select a product."));
        }
    }
}
