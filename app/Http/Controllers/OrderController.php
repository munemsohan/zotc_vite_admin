<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AffiliateController;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Address;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\OrderDetail;
use App\Models\CouponUsage;
use App\Models\Coupon;
use App\Models\User;
use App\Models\CombinedOrder;
use App\Models\SmsTemplate;
use Auth;
use Mail;
use App\Mail\InvoiceEmailManager;
use App\Models\Carrier;
use App\Models\Currency;
use App\Models\Language;
use App\Models\OrderPartialPayment;
use App\Models\ZotcSetting;
use App\Utility\NotificationUtility;
use CoreComponentRepository;
use App\Utility\SmsUtility;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Milon\Barcode\DNS1D;
use Picqer\Barcode\BarcodeGeneratorPNG;

class OrderController extends Controller
{
    public function __construct()
    {
        // Staff Permission Check
        $this->middleware(['permission:view_all_orders|view_inhouse_orders|view_seller_orders|view_pickup_point_orders'])->only('all_orders');
        $this->middleware(['permission:view_order_details'])->only('show');
        $this->middleware(['permission:delete_order'])->only('destroy', 'bulk_order_delete');
    }

    // All Orders
    public function all_orders(Request $request)
    {
        CoreComponentRepository::instantiateShopRepository();

        $date = $request->date;
        $sort_search = null;
        $delivery_status = null;
        $payment_status = '';

        $orders = Order::with('editingUser', 'editedUser')->orderBy('id', 'desc');

        $admin_user_id = User::where('user_type', 'admin')->first()->id;

        if (
            Route::currentRouteName() == 'inhouse_orders.index' &&
            Auth::user()->can('view_inhouse_orders')
        ) {
            $orders = $orders->where('orders.seller_id', '=', $admin_user_id);
        } else if (
            Route::currentRouteName() == 'seller_orders.index' &&
            Auth::user()->can('view_seller_orders')
        ) {
            $orders = $orders->where('orders.seller_id', '!=', $admin_user_id);
        } else if (
            Route::currentRouteName() == 'pick_up_point.index' &&
            Auth::user()->can('view_pickup_point_orders')
        ) {
            if (get_setting('vendor_system_activation') != 1) {
                $orders = $orders->where('orders.seller_id', '=', $admin_user_id);
            }
            $orders->where('shipping_type', 'pickup_point')->orderBy('code', 'desc');
            if (
                Auth::user()->user_type == 'staff' &&
                Auth::user()->staff->pick_up_point != null
            ) {
                $orders->where('shipping_type', 'pickup_point')
                    ->where('pickup_point_id', Auth::user()->staff->pick_up_point->id);
            }
        } else if (
            Route::currentRouteName() == 'all_orders.index' &&
            Auth::user()->can('view_all_orders')
        ) {
            if (get_setting('vendor_system_activation') != 1) {
                $orders = $orders->where('orders.seller_id', '=', $admin_user_id);
            }
        } else {
            abort(403);
        }

        if ($request->search) {
            $sort_search = $request->search;
            $orders = $orders->where('code', 'like', '%' . $sort_search . '%');
        }
        if ($request->payment_status != null) {
            $orders = $orders->where('payment_status', $request->payment_status);
            $payment_status = $request->payment_status;
        }
        if ($request->delivery_status != null) {
            $orders = $orders->where('delivery_status', $request->delivery_status);
            $delivery_status = $request->delivery_status;
        }
        if ($date != null) {
            $orders = $orders->where('created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])) . '  00:00:00')
                ->where('created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])) . '  23:59:59');
        }

        if (get_zotc_setting('order_delete') != 1) {
            $orders = $orders->where('delivery_status', '!=', 'deleted');
        }

        // Paginate the orders after updating
        $orders = $orders->paginate(15);

        // Update the orders
        foreach ($orders as $order) {
            if ($order->updated_at <= now()->subHour()) {
                $order->edited = $order->editing;
                $order->editing = null;
                $order->save();
            }
        }

        // Return the view with the updated data
        return view('backend.sales.index', compact('orders', 'sort_search', 'payment_status', 'delivery_status', 'date'));
    }

    public function selected_orders(Request $request)
    {
        $orderIds = explode(',', $request->orderids);
        $orders = Order::whereIn('id', $orderIds)->orderBy('id', 'desc')->get();
        $carriers = Carrier::where('status',  1)->get();

        return view('backend.sales.selected', compact('orders', 'carriers'));
    }

    public function selected_orders_print(Request $request)
    {
        // Explode the order IDs from the request parameter
        $ids = explode(',', $request->orderids);

        // Get the currency code
        $currency_code = Session::has('currency_code')
            ? Session::get('currency_code')
            : Currency::findOrFail(get_setting('system_default_currency'))->code;

        // Get the language code
        $language_code = Session::get('locale', Config::get('app.locale'));

        // Determine text direction and alignment
        if (Language::where('code', $language_code)->first()->rtl == 1) {
            $direction = 'rtl';
            $text_align = 'right';
            $not_text_align = 'left';
        } else {
            $direction = 'ltr';
            $text_align = 'left';
            $not_text_align = 'right';
        }

        // Get the font family
        $font_family = $this->getFontFamily($currency_code, $language_code);

        // dd($font_family);
        // Initialize the PDF
        $pdf = new \Mpdf\Mpdf([
            // Set margins to 0 (no margin)
            'margin_left' => 0,
            'margin_right' => 0,
            'margin_top' => 0,
            'margin_bottom' => 0,
            'margin_header' => 0,
            'margin_footer' => 0,

            // Set font options (assuming you want to use a custom font)
            'fontDir' => public_path('assets/fonts/'), // Adjust this path to where your fonts are located
            'fontdata' => [
                'hindsiliguri' => [
                    'R' => 'HindSiliguri-Regular.ttf',
                    'B' => 'HindSiliguri-Bold.ttf',
                ],
            ],
        ]);

        // Set the font you want to use
        $pdf->SetFont('hindsiliguri', '', 12);

        // Loop through each order ID and generate the invoice
        foreach ($ids as $id) {
            // Find the order
            $order = Order::findOrFail($id);

            // Generate a track URL if not already set
            if (is_null($order->track_url)) {
                $order->track_url = makeTinyUrl(url('track?order_code=' . $order->code));
                $order->save();
            }

            // Generate the barcode
            $generator = new BarcodeGeneratorPNG();
            $barcode = 'data:image/png;base64,' . base64_encode($generator->getBarcode($order->code, $generator::TYPE_CODE_128));

            // Render the invoice view to HTML
            $html = view('backend.invoices.invoice', [
                'order' => $order,
                'font_family' => $font_family,
                'direction' => $direction,
                'text_align' => $text_align,
                'not_text_align' => $not_text_align,
                'barcode' => $barcode,
            ])->render();


            // return $html;

            // Add the HTML to the PDF
            $pdf->AddPage();
            $pdf->WriteHTML($html);
        }

        // Output the PDF for download
        return $pdf->Output('invoices.pdf', 'D');
    }

    private function getFontFamily($currency_code, $language_code)
    {
        $fonts = [
            'BDT' => "hindsiliguri, sans-serif",
            'KHR' => "'Hanuman','sans-serif'",
            'AMD' => "'arnamu','sans-serif'",
            'THB' => "'Kanit','sans-serif'",
            'CNY' => "'sun-exta','gb'",
            'MMK' => 'tharlon',
            'USD' => "'Roboto','sans-serif'",
        ];

        $rtl_languages = ['sa', 'ir', 'om', 'jo'];
        $rtl_currencies = ['AED', 'EGP', 'IQD', 'ROM', 'SDG', 'ILS'];

        if (in_array($currency_code, $rtl_currencies) || in_array($language_code, $rtl_languages)) {
            return "xbriyaz";
        } elseif ($currency_code == 'THB' || $language_code == 'th') {
            return "'zawgyi-one','sans-serif'";
        } else {
            return $fonts[$currency_code] ?? "freeserif";
        }
    }


    public function show($id)
    {
        $order = Order::with('carrier')->findOrFail($id);

        $delivery_boys = null;

        if (!is_null($order->shipping_address)) {
            $order_shipping_address = json_decode($order->shipping_address);
            if (isset($order_shipping_address->city)) {
                $delivery_boys = User::where('city', $order_shipping_address->city)
                    ->where('user_type', 'delivery_boy')
                    ->get();
            }
        }

        $carriers = Carrier::where('status', 1)->get();
        $products = Product::get();
        $order->editing = Auth::id();
        $order->viewed = 1;
        $order->save();

        $user_all_orders = Order::where('user_id', $order->user_id)->get();

        return view('backend.sales.show', compact('order', 'delivery_boys', 'carriers', 'products', 'user_all_orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $user)
    {
        $carts = Cart::where('user_id', $user->id)
            ->get();

        if ($carts->isEmpty()) {
            flash(translate('Your cart is empty'))->warning();
            return redirect()->route('home');
        }

        if ($request->address_id) {
            $address = Address::where('id', $request->address_id)->first();
        } else {
            $address = Address::where('id', $carts[0]['address_id'])->first();
        }

        $shippingAddress = [];
        if ($address != null) {
            $shippingAddress['name']        = $user->name;
            $shippingAddress['email']       = $user->email;
            $shippingAddress['address']     = $address->address;
            $shippingAddress['country']     = $address->country->name;
            $shippingAddress['state']       = $address->state ? $address->state->name : '';
            $shippingAddress['city']        = $address->city ? $address->city->name : '';
            $shippingAddress['postal_code'] = $address->postal_code;
            $shippingAddress['phone']       = $address->phone;
            if ($address->latitude || $address->longitude) {
                $shippingAddress['lat_lang'] = $address->latitude . ',' . $address->longitude;
            }
        }

        $combined_order = new CombinedOrder;
        $combined_order->user_id = $user->id;
        $combined_order->shipping_address = json_encode($shippingAddress);
        $combined_order->save();

        $seller_products = array();
        foreach ($carts as $cartItem) {
            $product_ids = array();
            $product = Product::find($cartItem['product_id']);
            if (isset($seller_products[$product->user_id])) {
                $product_ids = $seller_products[$product->user_id];
            }
            array_push($product_ids, $cartItem);
            $seller_products[$product->user_id] = $product_ids;
        }

        foreach ($seller_products as $seller_product) {
            $order = new Order;
            $order->combined_order_id = $combined_order->id;
            $order->user_id = $user->id;
            $order->shipping_address = $combined_order->shipping_address;
            $order->city = $address->city ? $address->city->name : '';
            $order->additional_info = $request->additional_info;

            // $order->shipping_type = $carts[0]['shipping_type'];
            // if ($carts[0]['shipping_type'] == 'pickup_point') {
            //     $order->pickup_point_id = $cartItem['pickup_point'];
            // }
            // if ($carts[0]['shipping_type'] == 'carrier') {
            //     $order->carrier_id = $cartItem['carrier_id'];
            // }

            $order->payment_type = $request->payment_option;
            $order->delivery_viewed = '0';
            $order->payment_status_viewed = '0';
            $order->date = strtotime('now');
            $order->save();

            $id = $order->id;
            $remaining_digits = 8 - strlen($id);
            $random_number = rand(pow(10, $remaining_digits - 1), pow(10, $remaining_digits) - 1);
            $code = $random_number . $id;
            $order->code = $code;
            $order->track_url = makeTinyUrl(url('track?order_code=' . $code));
            $order->save();

            $subtotal = 0;
            $tax = 0;
            $shipping = 0;
            $coupon_discount = 0;

            //Order Details Storing
            foreach ($seller_product as $cartItem) {
                $product = Product::find($cartItem['product_id']);

                $subtotal += cart_product_price($cartItem, $product, false, false) * $cartItem['quantity'];
                $tax +=  cart_product_tax($cartItem, $product, false) * $cartItem['quantity'];
                $coupon_discount += $cartItem['discount'];

                $product_variation = $cartItem['variation'];

                $product_stock = $product->stocks->where('variant', $product_variation)->first();
                if ($product->digital != 1 && $cartItem['quantity'] > $product_stock->qty) {
                    flash(translate('The requested quantity is not available for ') . $product->getTranslation('name'))->warning();
                    $order->delete();
                    return redirect()->route('cart')->send();
                } elseif ($product->digital != 1) {
                    $product_stock->qty -= $cartItem['quantity'];
                    $product_stock->save();
                }

                $order_detail = new OrderDetail;
                $order_detail->order_id = $order->id;
                $order_detail->seller_id = $product->user_id;
                $order_detail->product_id = $product->id;
                $order_detail->variation = $product_variation;
                $order_detail->price = cart_product_price($cartItem, $product, false, false) * $cartItem['quantity'];
                $order_detail->tax = cart_product_tax($cartItem, $product, false) * $cartItem['quantity'];
                $order_detail->shipping_type = $cartItem['shipping_type'];
                $order_detail->product_referral_code = $cartItem['product_referral_code'];
                $order_detail->shipping_cost = $cartItem['shipping_cost'];

                $shipping += $order_detail->shipping_cost;
                //End of storing shipping cost

                $order_detail->quantity = $cartItem['quantity'];

                if (addon_is_activated('club_point')) {
                    $order_detail->earn_point = $product->earn_point;
                }

                $order_detail->save();

                $product->num_of_sale += $cartItem['quantity'];
                $product->save();

                $order->seller_id = $product->user_id;
                $order->shipping_type = $cartItem['shipping_type'];

                if ($cartItem['shipping_type'] == 'pickup_point') {
                    $order->pickup_point_id = $cartItem['pickup_point'];
                }
                if ($cartItem['shipping_type'] == 'carrier') {
                    $order->carrier_id = $cartItem['carrier_id'];
                }

                if ($product->added_by == 'seller' && $product->user->seller != null) {
                    $seller = $product->user->seller;
                    $seller->num_of_sale += $cartItem['quantity'];
                    $seller->save();
                }

                if (addon_is_activated('affiliate_system')) {
                    if ($order_detail->product_referral_code) {
                        $referred_by_user = User::where('referral_code', $order_detail->product_referral_code)->first();

                        $affiliateController = new AffiliateController;
                        $affiliateController->processAffiliateStats($referred_by_user->id, 0, $order_detail->quantity, 0, 0);
                    }
                }
            }

            $order->grand_total = $subtotal + $tax + $shipping;

            if ($seller_product[0]->coupon_code != null) {
                $order->coupon_discount = $coupon_discount;
                $order->grand_total -= $coupon_discount;

                $coupon_usage = new CouponUsage;
                $coupon_usage->user_id = $user->id;
                $coupon_usage->coupon_id = Coupon::where('code', $seller_product[0]->coupon_code)->first()->id;
                $coupon_usage->save();
            }

            $combined_order->grand_total += $order->grand_total;

            $order->save();
        }

        $combined_order->save();

        $plan = get_zotc_setting('plan');
        $planParts = explode(',', $plan);

        if ($planParts[0] == '11') {
            $orderTotal = (float) $combined_order->grand_total;
            $currency = get_zotc_setting('currency');
            $percent = (float) (get_zotc_setting('order_percentage') ?? 1);

            $percentageFromOrderTotal = ($orderTotal * $percent) / 100;

            // Determine the balance key based on currency
            $balanceKey = $currency === 'BDT' ? 'balance_bdt' : 'balance';

            // Calculate the new balance
            $balance = (float) get_zotc_setting($balanceKey);
            $deductedBalance = $balance - $percentageFromOrderTotal;

            $zotcSetting = ZotcSetting::where('type', $balanceKey)->first();
            $zotcSetting->value = $deductedBalance;
            $zotcSetting->save();
        }

        $to = $shippingAddress['phone'];
        $from = null;
        $template = SmsTemplate::where('identifier', 'order_placement')->first();

        $text = str_replace('[[order_code]]', $order->track_url, $template->sms_body);
        $template_id = null;

        sendSMS($to, $from, $text, $template_id);

        $request->session()->put('combined_order_id', $combined_order->id);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        if ($order != null) {
            foreach ($order->orderDetails as $key => $orderDetail) {
                try {
                    product_restock($orderDetail);
                } catch (\Exception $e) {
                }

                $orderDetail->delete();
            }
            $order->delete();
            flash(translate('Order has been deleted successfully'))->success();
        } else {
            flash(translate('Something went wrong'))->error();
        }
        return back();
    }

    public function bulk_order_delete(Request $request)
    {
        if ($request->id) {
            foreach ($request->id as $order_id) {
                $this->destroy($order_id);
            }
        }

        return 1;
    }

    public function order_details(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->save();
        return view('seller.order_details_seller', compact('order'));
    }

    public function update_delivery_status(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->delivery_viewed = '0';
        $order->delivery_status = $request->status;
        $order->save();

        if ($request->status == 'cancelled' && $order->payment_type == 'wallet') {
            $user = User::where('id', $order->user_id)->first();
            $user->balance += $order->grand_total;
            $user->save();
        }

        // If the order is cancelled and the seller commission is calculated, deduct seller earning
        if ($request->status == 'cancelled' && $order->shop->user->user_type == 'seller' && $order->payment_status == 'paid' && $order->commission_calculated == 1) {
            $sellerEarning = $order->commissionHistory->seller_earning;
            $shop = $order->shop;
            $shop->admin_to_pay -= $sellerEarning;
            $shop->save();
        }

        if (Auth::user()->user_type == 'seller') {
            foreach ($order->orderDetails->where('seller_id', Auth::user()->id) as $key => $orderDetail) {
                $orderDetail->delivery_status = $request->status;
                $orderDetail->save();

                if ($request->status == 'cancelled') {
                    product_restock($orderDetail);
                }
            }
        } else {
            foreach ($order->orderDetails as $key => $orderDetail) {

                $orderDetail->delivery_status = $request->status;
                $orderDetail->save();

                if ($request->status == 'cancelled') {
                    product_restock($orderDetail);
                }

                if (addon_is_activated('affiliate_system')) {
                    if (($request->status == 'delivered' || $request->status == 'cancelled') &&
                        $orderDetail->product_referral_code
                    ) {

                        $no_of_delivered = 0;
                        $no_of_canceled = 0;

                        if ($request->status == 'delivered') {
                            $no_of_delivered = $orderDetail->quantity;
                        }
                        if ($request->status == 'cancelled') {
                            $no_of_canceled = $orderDetail->quantity;
                        }

                        $referred_by_user = User::where('referral_code', $orderDetail->product_referral_code)->first();

                        $affiliateController = new AffiliateController;
                        $affiliateController->processAffiliateStats($referred_by_user->id, 0, 0, $no_of_delivered, $no_of_canceled);
                    }
                }
            }
        }
        if (addon_is_activated('otp_system') && SmsTemplate::where('identifier', 'delivery_status_change')->first()->status == 1) {
            try {
                SmsUtility::delivery_status_change(json_decode($order->shipping_address)->phone, $order);
            } catch (\Exception $e) {
            }
        }

        //sends Notifications to user
        NotificationUtility::sendNotification($order, $request->status);
        if (get_setting('google_firebase') == 1 && $order->user->device_token != null) {
            $request->device_token = $order->user->device_token;
            $request->title = "Order updated !";
            $status = str_replace("_", "", $order->delivery_status);
            $request->text = " Your order {$order->code} has been {$status}";

            $request->type = "order";
            $request->id = $order->id;
            $request->user_id = $order->user->id;

            NotificationUtility::sendFirebaseNotification($request);
        }


        if (addon_is_activated('delivery_boy')) {
            if (Auth::user()->user_type == 'delivery_boy') {
                $deliveryBoyController = new DeliveryBoyController;
                $deliveryBoyController->store_delivery_history($order);
            }
        }

        return 1;
    }

    public function update_carrier(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->carrier_id = $request->carrier;
        $order->save();
        return 1;
    }

    public function update_tracking_code(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->tracking_code = $request->tracking_code;
        $order->save();
        return 1;
    }

    public function update_address(Request $request)
    {
        // Retrieve the order
        $order = Order::findOrFail($request->order_id);

        // Prepare the shipping address
        $shipping_address = [
            'address' => $request->address,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        // Update and save the shipping address
        $order->shipping_address = json_encode($shipping_address);
        $order->save();

        // Return a JSON response
        return response()->json([
            'success' => true,
            'message' => 'Order address has been updated successfully.'
        ], 200);
    }

    public function update_payment_status(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->payment_status_viewed = '0';
        $order->save();

        if (Auth::user()->user_type == 'seller') {
            foreach ($order->orderDetails->where('seller_id', Auth::user()->id) as $key => $orderDetail) {
                $orderDetail->payment_status = $request->status;
                $orderDetail->save();
            }
        } else {
            foreach ($order->orderDetails as $key => $orderDetail) {
                $orderDetail->payment_status = $request->status;
                $orderDetail->save();
            }
        }

        $status = 'paid';
        foreach ($order->orderDetails as $key => $orderDetail) {
            if ($orderDetail->payment_status != 'paid') {
                $status = 'unpaid';
            }
        }
        $order->payment_status = $status;
        $order->save();

        if (
            $order->payment_status == 'paid' &&
            $order->commission_calculated == 0
        ) {
            calculateCommissionAffilationClubPoint($order);
        }

        //sends Notifications to user
        NotificationUtility::sendNotification($order, $request->status);
        if (get_setting('google_firebase') == 1 && $order->user->device_token != null) {
            $request->device_token = $order->user->device_token;
            $request->title = "Order updated !";
            $status = str_replace("_", "", $order->payment_status);
            $request->text = " Your order {$order->code} has been {$status}";

            $request->type = "order";
            $request->id = $order->id;
            $request->user_id = $order->user->id;

            NotificationUtility::sendFirebaseNotification($request);
        }


        if (addon_is_activated('otp_system') && SmsTemplate::where('identifier', 'payment_status_change')->first()->status == 1) {
            try {
                SmsUtility::payment_status_change(json_decode($order->shipping_address)->phone, $order);
            } catch (\Exception $e) {
            }
        }
        return 1;
    }

    public function assign_delivery_boy(Request $request)
    {
        if (addon_is_activated('delivery_boy')) {

            $order = Order::findOrFail($request->order_id);
            $order->assign_delivery_boy = $request->delivery_boy;
            $order->delivery_history_date = date("Y-m-d H:i:s");
            $order->save();

            $delivery_history = \App\Models\DeliveryHistory::where('order_id', $order->id)
                ->where('delivery_status', $order->delivery_status)
                ->first();

            if (empty($delivery_history)) {
                $delivery_history = new \App\Models\DeliveryHistory;

                $delivery_history->order_id = $order->id;
                $delivery_history->delivery_status = $order->delivery_status;
                $delivery_history->payment_type = $order->payment_type;
            }
            $delivery_history->delivery_boy_id = $request->delivery_boy;

            $delivery_history->save();

            if (env('MAIL_USERNAME') != null && get_setting('delivery_boy_mail_notification') == '1') {
                $array['view'] = 'emails.invoice';
                $array['subject'] = translate('You are assigned to delivery an order. Order code') . ' - ' . $order->code;
                $array['from'] = env('MAIL_FROM_ADDRESS');
                $array['order'] = $order;

                try {
                    Mail::to($order->delivery_boy->email)->queue(new InvoiceEmailManager($array));
                } catch (\Exception $e) {
                }
            }

            if (addon_is_activated('otp_system') && SmsTemplate::where('identifier', 'assign_delivery_boy')->first()->status == 1) {
                try {
                    SmsUtility::assign_delivery_boy($order->delivery_boy->phone, $order->code);
                } catch (\Exception $e) {
                }
            }
        }

        return 1;
    }

    public function pathaoCities()
    {
        DB::connection('dynamic_db')->statement("USE zotc_nazmart");

        $cities = DB::connection('dynamic_db')->table('pathao_cities')->get();

        return response()->json($cities);
    }

    public function pathaoZonesByCity(Request $request)
    {
        $city_id = $request->city_id;

        DB::connection('dynamic_db')->statement("USE zotc_nazmart");

        $cities = DB::connection('dynamic_db')->table('pathao_zones')->where('city_id', $city_id)->get();

        return response()->json($cities);
    }

    public function pathaoAreasByZone(Request $request)
    {
        $zone_id = $request->zone_id;

        DB::connection('dynamic_db')->statement("USE zotc_nazmart");

        $cities = DB::connection('dynamic_db')->table('pathao_areas')->where('zone_id', $zone_id)->get();

        return response()->json($cities);
    }

    public function redxCities()
    {
        DB::connection('dynamic_db')->statement("USE zotc_nazmart");

        $cities = DB::connection('dynamic_db')
            ->table('redx_areas')
            ->select('district_name')
            ->distinct()
            ->get();

        return response()->json($cities);
    }

    public function redxAreasByCity(Request $request)
    {
        $city = $request->city;

        DB::connection('dynamic_db')->statement("USE zotc_nazmart");

        $cities = DB::connection('dynamic_db')->table('redx_areas')->where('district_name', $city)->get();

        return response()->json($cities);
    }

    protected function normalizePhoneNumber($phone)
    {
        if (substr($phone, 0, 3) === "+88") {
            return substr($phone, 3);
        } elseif (substr($phone, 0, 2) === "88") {
            return substr($phone, 2);
        }
        return $phone;
    }

    public function courierSendRequest(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $carrier = $order->carrier_id;

        if (!$order->tracking_code && $carrier) {
            if ($carrier == 1) {
                return $this->sendViaPathao($request, $order);
            } elseif ($carrier == 2) {
                return $this->sendViaSteadfast($order);
            } elseif ($carrier == 3) {
                return $this->sendViaRedx($request, $order);
            } elseif ($carrier == 6) {
                return $this->sendViaBili($order);
            }
        }

        return response()->json(['success' => false, 'message' => 'Something went wrong, try again !']);
    }

    protected function sendViaPathao(Request $request, Order $order)
    {
        try {
            $recipient = json_decode($order->shipping_address);
            $recipient_phone = $this->normalizePhoneNumber($recipient->phone);

            $pathao = Carrier::findOrFail(1);
            $apiInfo = json_decode($pathao->api_info);

            // Check sandbox condition and whether required credentials are missing
            if (($pathao->sandbox == 0 && (!$apiInfo->client_id || !$apiInfo->client_secret || !$apiInfo->username || !$apiInfo->password))) {
                return response()->json(['success' => false, 'message' => 'Pathao Api Info not set correctly']);
            }

            // Get access token, caching for repeated use
            $accessToken = $this->getPathaoToken($pathao);

            // Determine base URL depending on sandbox mode
            $base_url = $pathao->sandbox
                ? "https://courier-api-sandbox.pathao.com/"
                : "https://api-hermes.pathao.com/";

            // Set headers for all requests
            $headers = [
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ];

            // Fetch the stores
            $response = Http::withHeaders($headers)->get($base_url . "aladdin/api/v1/stores");
            $stores = $response->json()['data']['data'] ?? null;

            if (!$stores) {
                return response()->json(['success' => false, 'message' => 'Failed to retrieve stores from Pathao']);
            }

            // Prepare order data
            $user = Auth::user();
            $recipient_address = strlen($recipient->address) < 10
                ? str_pad($recipient->address, 10, ' ', STR_PAD_RIGHT) . '...'
                : $recipient->address;

            $amountToCollect = $order->payment_status == 'paid' ? 0 : $order->grand_total;

            $requestData = [
                "store_id" => $stores[0]['store_id'],
                "merchant_order_id" => $order->code,
                // "sender_name" => $user->name,
                // "sender_phone" => $this->normalizePhoneNumber($user->phone),
                "recipient_name" => $recipient->name ?? 'N/A',
                "recipient_phone" => $recipient_phone,
                "recipient_address" => $recipient_address,
                "recipient_city" => $request->city_id,
                "recipient_zone" => $request->zone_id,
                "recipient_area" => $request->area_id,
                "delivery_type" => $request->delivery_type,
                "item_type" => 2,
                "special_instruction" => "",
                "item_quantity" => count($order->orderDetails),
                "item_weight" => 0.5,
                "amount_to_collect" => $amountToCollect,
                "item_description" => ""
            ];

            // Send the order to Pathao
            $response = Http::withHeaders($headers)->post($base_url . 'aladdin/api/v1/orders', $requestData);

            if ($response->successful()) {
                $responseData = $response->json();
                $tracking_code = $responseData['data']['consignment_id'];

                // Update order with carrier and tracking information
                $order->carrier_id = $pathao->id;
                $order->tracking_code = $tracking_code;
                $order->delivery_status = 'carrier_pending';

                // Generate tracking URL and tiny URL
                $trackingUrl = "https://merchant.pathao.com/tracking?consignment_id={$tracking_code}";
                $shortenedUrl = makeTinyUrl($trackingUrl);

                $order->track_url = $shortenedUrl;
                $order->save();

                // Send SMS if the template is active
                $sms_template = SmsTemplate::find(7);
                if ($sms_template->status == 1) {
                    sendTrackingTinyUrlBySms($recipient_phone, $sms_template, $shortenedUrl);
                }

                return response()->json(['success' => true, 'message' => 'Order successfully sent via Pathao', 'tracking_code' => $tracking_code]);
            }

            return response()->json(['success' => false, 'message' => 'Failed to send order via Pathao', 'error' => $response->body()]);
        } catch (\Exception $e) {
            // Handle exceptions with a specific error message
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }


    protected function sendViaSteadfast(Order $order)
    {
        $shippingAddress = json_decode($order->shipping_address);
        $shippingAddressPhone = $this->normalizePhoneNumber($shippingAddress->phone);

        if (strlen($shippingAddressPhone) != 11) {
            return response()->json([
                'status' => 400,
                'message' => 'Failed to send order via Steadfast. Invalid phone number.'
            ]);
        }

        $steadfast = Carrier::findOrFail(2);
        $apiInfo = json_decode($steadfast->api_info);

        $api_key = $apiInfo->api_key;
        $secret_key = $apiInfo->secret_key;

        if (!$api_key || !$secret_key) {
            return response()->json([
                'status' => 400,
                'message' => 'Steadfast API Key or Secret Key is empty'
            ]);
        }

        $api_url = "https://portal.packzy.com/api/v1/create_order";

        $amountToCollect = $order->payment_status == 'paid' ? 0 : $order->grand_total;
        $deliveryAddress = $shippingAddress->address . ', ' . $order->city;

        $headers = [
            'Api-Key' => $api_key,
            'Secret-Key' => $secret_key,
            'Content-Type' => 'application/json'
        ];

        $data = [
            'invoice' => $order->code,
            'recipient_name' => $shippingAddress->name,
            'recipient_phone' => $shippingAddressPhone,
            'recipient_address' => $deliveryAddress,
            'cod_amount' => $amountToCollect,
            'note' => 'Order'
        ];

        $response = Http::withHeaders($headers)->post($api_url, $data);

        if (!$response->successful()) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to send order via Steadfast',
                'error' => $response->body()
            ]);
        }

        $responseData = $response->json();

        if (!isset($responseData['consignment'])) {
            return response()->json([
                'status' => 500,
                'message' => $responseData
            ]);
        }

        $order->carrier_id = $steadfast->id;
        $order->tracking_code = $responseData['consignment']['consignment_id'] . '-' . $responseData['consignment']['tracking_code'];
        $order->delivery_status = 'carrier_pending';

        $tracking_code = $responseData['consignment']['tracking_code'];
        $trackingUrl = "https://merchant.pathao.com/tracking?consignment_id={$tracking_code}";

        $shortenedUrl = makeTinyUrl($trackingUrl);
        $order->track_url = $shortenedUrl;
        $order->save();

        $sms_template = SmsTemplate::find(7);
        if ($sms_template->status == 1) {
            sendTrackingTinyUrlBySms($shippingAddressPhone, $sms_template, $shortenedUrl);
        }

        return response()->json(['success' => true, 'message' => 'Successfully sent order via Steadfast', 'tracking_code' => $order->tracking_code]);
    }

    protected function sendViaRedx(Request $request, Order $order)
    {

        $redx = Carrier::find(3);
        $api_info = json_decode($redx->api_info, true);
        $jwtToken = $api_info['token'];

        $recipient = json_decode($order->shipping_address);

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://openapi.redx.com.bd/v1.0.0-beta/parcel',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode([
                "customer_name" => $recipient->name,
                "customer_phone" => $recipient->phone,
                "delivery_area" => 'Dhaka',
                "delivery_area_id" => $request->redx_area_id,
                "customer_address" => $recipient->address . ', ' . $order->city,
                "merchant_invoice_id" => $order->code,
                "cash_collection_amount" => $order->grand_total,
                "parcel_weight" => 500,
                "instruction" => "",
                "value" => 100,
                "is_closed_box" => false,
                "parcel_details_json" => []
            ]),
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $jwtToken,
                'Content-Type: application/json'
            ],
        ]);

        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($httpcode == 200) {
            $responseData = json_decode($response, true);

            if (isset($responseData['tracking_id'])) {
                $order->carrier_id = $redx->id;
                $order->tracking_code = $responseData['tracking_id'];
                $order->delivery_status = 'carrier_pending';

                $tracking_code = $responseData['tracking_id'];

                $sms_template = SmsTemplate::find(7);
                $trackingUrl = "https://merchant.pathao.com/tracking?consignment_id={{ $tracking_code }}";

                $response = makeTinyUrl($trackingUrl);
                $responseData = json_decode($response, true);
                $shortenedUrl = $responseData['shorturl'] ?? $trackingUrl;

                $order->tiny_url = $shortenedUrl;

                $order->save();

                // $sms_template = SmsTemplate::find(7);
                // if ($sms_template && $sms_template->status == 1) {
                //     sendTrackingTinyUrlBySms($order, $sms_template, $order->tiny_url);
                // }

                return response()->json(['success' => true, 'message' => 'Successfully sent order via RedX', 'tracking_code' => $order->tracking_code]);
            } else {
                return response()->json(['success' => false, 'message' => 'Failed to get tracking id from RedX']);
            }
        } else {
            $error = json_decode($response, true);
            return response()->json(['success' => false, 'message' => 'Failed to send order via RedX', 'error' => $error]);
        }
    }

    protected function sendViaBili(Order $order)
    {
        $bili = Carrier::findOrFail(6);
        $apiInfo = json_decode($bili->api_info);
        $username = $apiInfo->username;
        $password = $apiInfo->password;

        $data = [
            "merOrderRef" => "234566335",
            "pickMerchantName" => "Jahid Hasan Asif",
            "pickMerchantAddress" => "tests",
            "pickMerchantThana" => "Tejga-1208",
            "pickMerchantDistrict" => "Dhaka",
            "pickupMerchantPhone" => "01719023450",
            "productSizeWeight" => "standard",
            "productBrief" => "USB Fan",
            "packagePrice" => "3400",
            "max_weight" => "1",
            "deliveryOption" => "regular",
            "custname" => "Md. Abdul Karim",
            "custaddress" => "Road 27, Dhanmondi",
            "customerThana" => "Jatarabari-1236",
            "customerDistrict" => "Dhaka",
            "custPhone" => "01780111222"
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'AUTHTOKEN' => 'BILI-API_~PROD!^XxiT*23v1@'
        ])->withBasicAuth($username, $password)
            ->post('https://erp.bili.com.bd/OrderBookingApi', $data);

        if ($response->failed()) {
            $error = $response->body();
            // Handle error
            echo "HTTP Error: $error";
        } else {
            $responseData = $response->json();
            // Handle response data
            var_dump($responseData);
        }
    }
    public function getPathaoToken($pathao)
    {
        $client = new Client();

        if ($pathao->sandbox == 1) {
            $baseUrl = "https://courier-api-sandbox.pathao.com/";
            $requestData = [
                'client_id' => '7N1aMJQbWm',
                'client_secret' => 'wRcaibZkUdSNz2EI9ZyuXLlNrnAv0TdPUPXMnD39',
                'username' => 'test@pathao.com',
                'password' => 'lovePathao',
                'grant_type' => 'password'
            ];
        } else {
            $baseUrl = "https://api-hermes.pathao.com/";
            $apiInfo = json_decode($pathao->api_info);
            $requestData = [
                'client_id' => $apiInfo->client_id,
                'client_secret' => $apiInfo->client_secret,
                'username' => $apiInfo->username,
                'password' => $apiInfo->password,
                'grant_type' => 'password'
            ];
        }

        $endpoint = "aladdin/api/v1/issue-token";

        try {
            $response = $client->post($baseUrl . $endpoint, [
                'json' => $requestData,
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                ]
            ]);

            $responseData = json_decode($response->getBody(), true);
            $accessToken = $responseData['access_token'];

            return $accessToken;
        } catch (RequestException $e) {
            return $e->getMessage();
        }
    }

    public function saveCarrierInfo(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->city = $request->input('city', $order->city);
        $order->zone = $request->input('zone', $order->zone);
        $order->area = $request->input('area', $order->area);

        $order->save();

        return response()->json('Courier information saved successfully');
    }

    public function order_partial_payment(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $amount = $request->amount;
        $user_id = Auth::id();

        $currentTotalPaid = $order->partialPayments->sum('amount') + $amount;

        if ($currentTotalPaid <= $order->grand_total) {
            $partialPayment = new OrderPartialPayment();
            $partialPayment->order_id = $order->id;
            $partialPayment->user_id = $user_id;
            $partialPayment->amount = $amount;
            $partialPayment->save();

            $order->payment_status = ($currentTotalPaid == $order->grand_total) ? 'paid' : 'partial';
            $order->save();

            return response()->json(['success' => true, 'message' => 'Partial Payment Added !']);
        }

        $remainingAmount = $order->grand_total - $order->partialPayments->sum('amount');
        return response()->json(['success' => false, 'message' => 'Please Pay TK ' . $remainingAmount . ' or below']);
    }

    public function add_product(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity;

        $priceBeforeDiscount = $product->unit_price;

        if ($product->discount_type == 'amount') {
            $discountedPrice =  $priceBeforeDiscount - $product->discount;
        } elseif ($product->discount_type == 'percent') {
            $discount = ($priceBeforeDiscount * $product->discount) / 100;
            $discountedPrice =  $priceBeforeDiscount - $discount;
        } else {
            $discountedPrice =  $priceBeforeDiscount;
        }

        $existingOrderDetail = OrderDetail::where('order_id', $order->id)
            ->where('product_id', $product->id)
            ->first();

        if ($existingOrderDetail) {
            $existingOrderDetail->quantity += $quantity;
            $existingOrderDetail->price = $existingOrderDetail->quantity * $discountedPrice;
            $existingOrderDetail->save();
            $message = 'Product quantity updated!';
        } else {
            $orderDetails = new OrderDetail();
            $orderDetails->order_id = $order->id;
            $orderDetails->seller_id = Auth::id();
            $orderDetails->product_id = $product->id;
            $orderDetails->price = $quantity * $discountedPrice;
            $orderDetails->quantity = $quantity;
            $orderDetails->save();
            $message = 'New Product Added!';
        }

        $this->update_order_grand_total($order);

        return response()->json(['success' => true, 'message' => $message]);
    }

    public function update_order_product_quantity(Request $request)
    {
        $order_details_id = $request->order_details_id;

        $orderDetail = OrderDetail::findOrFail($order_details_id);

        $previous_quantity = $orderDetail->quantity;
        $previous_price = $orderDetail->price;
        $previous_single_price = $previous_price / $previous_quantity;

        $new_quantity = $request->quantity;
        $new_price = $previous_single_price * $new_quantity;

        $orderDetail->quantity = $new_quantity;
        $orderDetail->price = $new_price;
        $orderDetail->save();

        $order = $orderDetail->order;
        $this->update_order_grand_total($order);

        return response()->json(['success' => true, 'message' => 'Product quantity updated!']);
    }

    public function update_order_product_price(Request $request)
    {
        $price = $request->price;
        $order_details_id = $request->order_details_id;

        $orderDetail = OrderDetail::findOrFail($order_details_id);
        $orderDetail->price = $price;
        $orderDetail->save();

        $order = $orderDetail->order;
        $this->update_order_grand_total($order);

        return response()->json(['success' => true, 'message' => 'Product price updated!']);
    }

    public function delete_order_product(Request $request)
    {
        $order_details_id = $request->order_details_id;
        $orderDetail = OrderDetail::findOrFail($order_details_id);
        $order = $orderDetail->order;

        $orderDetail->delete();

        $this->update_order_grand_total($order);

        return response()->json(['success' => true, 'message' => 'Product quantity updated!']);
    }

    public function update_order_tax(Request $request)
    {
        $new_total_tax = $request->tax;
        $order_id = $request->order_id;

        $order = Order::with('orderDetails')->find($order_id);

        $tax_per_detail = $new_total_tax / $order->orderDetails->count();
        foreach ($order->orderDetails as $orderDetail) {
            $orderDetail->tax = $tax_per_detail;
            $orderDetail->save();
        }

        $this->update_order_grand_total($order);

        return response()->json(['success' => true, 'message' => 'Order tax updated successfully!']);
    }

    public function update_order_shipping(Request $request)
    {
        $new_total_shipping = $request->shipping;
        $order_id = $request->order_id;

        $order = Order::with('orderDetails')->find($order_id);

        $shipping_per_detail = $new_total_shipping / $order->orderDetails->count();
        foreach ($order->orderDetails as $orderDetail) {
            $orderDetail->shipping_cost = $shipping_per_detail;
            $orderDetail->save();
        }

        $this->update_order_grand_total($order);

        return response()->json(['success' => true, 'message' => 'Order tax updated successfully!']);
    }

    public function update_order_coupon(Request $request)
    {
        $coupon_discount = $request->coupon;
        $order_id = $request->order_id;

        $order = Order::with('orderDetails', 'partialPayments')->find($order_id);

        if (($order->grand_total - $order->partialPayments()->sum('amount')) < $coupon_discount) {
            return response()->json(['success' => false, 'message' => 'Coupon must be equal or less than total!']);
        } else {
            $order->coupon_discount = $coupon_discount;
        }

        $this->update_order_grand_total($order);

        return response()->json(['success' => true, 'message' => 'Coupon Discount updated successfully!']);
    }

    public function update_order_grand_total($order)
    {
        $order->grand_total = $order->orderDetails()->sum('price') + $order->orderDetails()->sum('tax') + $order->orderDetails()->sum('shipping_cost') - $order->coupon_discount;
        $order->save();
    }

    public function editing_save($id)
    {
        $order =  Order::findOrFail($id);
        $order->edited =  Auth::id();
        $order->editing =  null;
        $order->save();

        return redirect(route('all_orders.index'));
    }

    // public function fraudCheck($order_id)
    // {
    //     $order = Order::with('user')->findOrFail($order_id);

    //     $shippingAddress = json_decode($order->shipping_address);
    //     $user_phone = null;

    //     if (isset($shippingAddress->phone)) {
    //         $user_phone = $shippingAddress->phone;
    //     } elseif (isset($order->user->phone)) {
    //         $user_phone = $order->user->phone;
    //     } else {
    //         return null; // Return early if no phone number is found
    //     }

    //     // Normalize the phone number
    //     if (substr($user_phone, 0, 3) === '+88') {
    //         $user_phone = substr($user_phone, 3);
    //     } elseif (substr($user_phone, 0, 2) === '88') {
    //         $user_phone = substr($user_phone, 2);
    //     }

    //     // Construct the URL with the user's phone number
    //     $url = 'https://www.root6.xyz/wp-content/plugins/orderguard2/orderguard.php';
    //     $apiKey = '5467yujhgfred54erwsd'; // Ideally, this should be in a config file or .env
    //     $fraudStatus = '-';

    //     try {
    //         $response = Http::get($url, [
    //             'apiKey' => $apiKey,
    //             'number' => $user_phone
    //         ]);

    //         // Check if the request was successful
    //         if ($response->successful()) {
    //             $responseData = $response->json();

    //             if (isset($responseData['unsuccess'])) {
    //                 $fraudStatus = '-';
    //             } elseif (isset($responseData['success'])) {
    //                 $status = $responseData['success'];
    //                 $fraudStatus = $status['Total Delivered'] . '/' . $status['Total Parcels'];
    //             }
    //         }
    //     } catch (\Exception $e) {
    //         // Log the error or handle it as needed
    //         \Log::error('Fraud check error: ' . $e->getMessage());
    //     }

    //     // Save the order with updated fraud status
    //     $order->fraud_status = $fraudStatus;
    //     $order->save();

    //     return $fraudStatus;
    // }

    public function fraudCheck($order_id)
    {
        $order = Order::with('user')->findOrFail($order_id);

        $shippingAddress = json_decode($order->shipping_address);
        $user_phone = null;

        if (isset($shippingAddress->phone)) {
            $user_phone = $shippingAddress->phone;
        } elseif (isset($order->user->phone)) {
            $user_phone = $order->user->phone;
        } else {
            return null; // Return early if no phone number is found
        }

        // Normalize the phone number
        if (substr($user_phone, 0, 3) === '+88') {
            $user_phone = substr($user_phone, 3);
        } elseif (substr($user_phone, 0, 2) === '88') {
            $user_phone = substr($user_phone, 2);
        }

        // Construct the URL with the user's phone number
        $url = 'https://www.root6.xyz/wp-content/plugins/orderguard2/orderguard.php';
        $apiKey = '5467yujhgfred54erwsd';
        $fraudStatus = null;

        try {
            $response = Http::get($url, [
                'apiKey' => $apiKey,
                'number' => $user_phone
            ]);

            $responseData = json_decode($response, true);
            $fraudStatus = $this->formatFraudStatus($responseData);
            $order->fraud_status = $fraudStatus;
            $order->save();
        } catch (\Exception $e) {
            // Log the error or handle it as needed
            \Log::error('Fraud check error: ' . $e->getMessage());
        }

        return $fraudStatus;
    }

    private function formatFraudStatus($responseData)
    {
        $formattedStatus = [];
        $totalParcels = 0;
        $totalDelivered = 0;
        $totalCanceled = 0;

        // Check if the response has a 'success' key
        if (isset($responseData['success']) && is_array($responseData['success'])) {
            foreach ($responseData['success'] as $carrier => $carrierData) {
                // Dynamically extract parcel details
                $carrierParcels = $carrierData['Total Parcels'] ?? $carrierData['Total Delivery'] ?? 0;
                $carrierDelivered = $carrierData['Delivered Parcels'] ?? $carrierData['Successful Delivery'] ?? 0;
                $carrierCanceled = $carrierData['Canceled Parcels'] ?? $carrierData['Canceled Delivery'] ?? 0;

                // Update overall totals
                $totalParcels += $carrierParcels;
                $totalDelivered += $carrierDelivered;
                $totalCanceled += $carrierCanceled;

                // Format the status for the current carrier
                $formattedStatus[] = "$carrier:$carrierParcels,$carrierDelivered,$carrierCanceled";
            }
        }

        // Add the overall totals to the formatted status
        $formattedStatus[] = "Total:$totalParcels,$totalDelivered,$totalCanceled";

        // Return the status as a semicolon-separated string
        return implode(';', $formattedStatus);
    }

    public function markDelete($id)
    {
        $order = Order::findOrFail($id);
        $order->delivery_status = 'deleted';
        $order->save();
        return response()->json(['success' => true, 'message' => 'Order has been deleted successfully.']);
    }
}
