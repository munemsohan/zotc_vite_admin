<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Http\Resources\SellerPosProductCollection;
use App\Models\Address;
use App\Models\Cart;
use App\Models\City;
use App\Models\State;
use App\Utility\FontUtility;
use App\Utility\SellerPosUtility;
use Session;
use Mpdf\Mpdf;

class SellerPosController extends Controller
{
    public function __construct()
    {
        // Staff Permission Check
        $this->middleware(['permission:pos_manager'])->only('admin_index');
        $this->middleware(['permission:pos_configuration'])->only('seller_pos_activation');
    }

    public function index()
    {
        $users = User::whereIn('user_type', ['customer', 'seller'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('user_type');

        $customers = $users->get('customer', collect());
        $sellers = $users->get('seller', collect());

        //send shipping type and corresponding info to the view
        return view('backend.seller_pos.index', compact('customers', 'sellers'));
    }

    public function search(Request $request)
    {
        $products = SellerPosUtility::product_search($request->only('category', 'brand', 'keyword'));

        $stocks = new SellerPosProductCollection($products);
        $stocks->appends(['keyword' =>  $request->keyword, 'category' => $request->category, 'brand' => $request->brand]);
        return $stocks;
    }

    // Add product To cart
    public function addToCart(Request $request)
    {
        $stockId    = $request->stock_id;

        $userID     = Session::get('seller_pos.user_id');
        $temUserId  = Session::get('seller_pos.temp_user_id');
        if (!$temUserId && !$userID) {
            $temUserId = bin2hex(random_bytes(10));
            Session::put('seller_pos.temp_user_id', $temUserId);
        }
        $response = SellerPosUtility::addToCart($stockId, $userID, $temUserId);

        if ($request->shipping != null) {
            Session::put('seller_pos.shipping', $request->shipping);
        }

        return array(
            'success' => $response['success'],
            'message' => $response['message'],
            'view' => view('backend.seller_pos.cart')->render()
        );
    }

    //updated the quantity for a cart item
    public function updateQuantity(Request $request)
    {
        $response = SellerPosUtility::updateCartItemQuantity($request->cartId, $request->quantity);

        return array('success' => $response['success'], 'message' => $response['message'], 'view' => view('backend.seller_pos.cart')->render());
    }

    //removes from Cart
    public function removeFromCart(Request $request)
    {
        $response = SellerPosUtility::removeFromCart($request->id);
        return array('success' => $response['success'], 'message' => $response['message'], 'view' => view('backend.seller_pos.cart')->render());
    }

    //Shipping Address for admin
    public function getShippingAddress(Request $request)
    {
        Session::forget('seller_pos.shipping_info');
        $user_id = $request->id;
        return ($user_id == '') ? view('backend.seller_pos.guest_shipping_address') : view('backend.seller_pos.shipping_address', compact('user_id'));
    }

    public function set_shipping_address(Request $request)
    {
        $data = SellerPosUtility::get_shipping_address($request);

        $shipping_info = $data;
        $request->session()->put('seller_pos.shipping_info', $shipping_info);
    }

    // Update user Cart data when user is changed 
    public function updateSessionUserCartData(Request $request)
    {
        SellerPosUtility::updateCartOnUserChange($request->only(['userId']));
        return view('backend.seller_pos.cart');
    }

    //set Discount
    public function setDiscount(Request $request)
    {
        if ($request->discount >= 0) {
            Session::put('seller_pos.discount', $request->discount);
        }
        return view('backend.seller_pos.cart');
    }

    public function setShippingByCustomer(Request $request)
    {
        $address_id = $request->address_id;
        $address = Address::find($address_id);

        $shippingType = get_business_setting('shipping_type');

        $state = null;
        $city = null;

        if ($shippingType == 'state_wise_shipping') {
            $state = State::find($address->state_id);
            Session::put('seller_pos.shipping', $state->cost ?? 0);
            Session::forget('seller_pos.shipping_type');
        } elseif ($shippingType == 'area_wise_shipping') {
            $city = City::find($address->city_id);
            Session::put('seller_pos.shipping', $city->cost ?? 0);
            Session::forget('seller_pos.shipping_type');
        }

        return view('backend.seller_pos.cart');
    }

    //set Shipping Cost
    public function setShipping(Request $request)
    {
        if ($request->shipping != null) {
            Session::put('seller_pos.shipping', $request->shipping);
        }

        if ($request->filled('shippingType')) {
            Session::put('seller_pos.shipping_type', $request->shippingType);
        } else {
            Session::forget('seller_pos.shipping_type');
        }

        return view('backend.seller_pos.cart');
    }

    //order summary
    public function get_order_summary(Request $request)
    {
        return view('backend.seller_pos.order_summary');
    }

    //order place
    public function order_store(Request $request)
    {
        // return $request->all();

        $request->merge([
            'products' => Session::get('seller_pos.products', []),
            'temp_usder_id' => Session::get('seller_pos.temp_user_id'),
            'shippingInfo' => Session::get('seller_pos.shipping_info'),
            'shippingCost' => Session::get('seller_pos.shipping', 0),
            'discount' => Session::get('seller_pos.discount', 0)
        ]);

        $response = SellerPosUtility::orderStore($request->except(['_token']));

        if ($response['success']) {
            Session::forget('seller_pos.products');
            Session::forget('seller_pos.shipping_info');
            Session::forget('seller_pos.shipping');
            Session::forget('seller_pos.discount');
            Session::forget('seller_pos.user_id');
            Session::forget('seller_pos.temp_user_id');
        }

        return $response;
    }

    public function configuration()
    {
        return view('backend.seller_pos.pos_activation');
    }

    public function invoice($id)
    {
        $order = Order::findOrFail($id);

        $print_width = get_zotc_setting('print_width');
        if ($print_width == null) {
            flash(translate('Thermal printer size is not given in POS configuration'))->warning();
            return back();
        }

        $pdf_style_data = FontUtility::get_font_family();

        $html = view('backend.seller_pos.thermal_invoice', compact('order', 'pdf_style_data'));

        $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => [$print_width, 1000]]);
        $mpdf->WriteHTML($html);
        // $mpdf->WriteHTML('<h1>Hello world!</h1>');
        $mpdf->page   = 0;
        $mpdf->state  = 0;
        unset($mpdf->pages[0]);
        // The $p needs to be passed by reference
        $p = 'P';
        // dd($mpdf->y);
        $mpdf->_setPageSize(array($print_width, $mpdf->y), $p);

        $mpdf->addPage();
        $mpdf->WriteHTML($html);

        $mpdf->Output('order-' . $order->code . '.pdf', 'I');
    }

    public function addCustomer(Request $request)
    {
        // Combine phone code and number
        $fullPhone = $request->phonecode . $request->phone;

        // Validate input
        $request->validate([
            'name'       => 'required',
            'email'      => 'nullable|email|unique:users,email',
            'phonecode'  => 'required',
            'phone'      => 'required',
            'address'    => 'nullable',
            'country_id' => 'required',
            'state_id'   => 'required',
            'city_id'    => 'required',
            'postal_code' => 'nullable',
        ]);

        // Search for existing user by phone or email
        $user = User::where('phone', $fullPhone)
            ->orWhere('email', $request->email)
            ->first();

        // If user does not exist, create a new one
        if (!$user) {
            $user = User::create([
                'name'  => $request->name,
                'email' => $request->email,
                'phone' => $fullPhone,
            ]);
        }

        // Always create a new address entry
        Address::create([
            'user_id'     => $user->id,
            'address'     => $request->address,
            'country_id'  => $request->country_id,
            'state_id'    => $request->state_id,
            'city_id'     => $request->city_id,
            'postal_code' => $request->postal_code,
            'phone'       => $fullPhone,
        ]);

        // Flash success message
        flash(translate('Customer added successfully!'))->success();

        return back();
    }

    public function updateProductPrice(Request $request)
    {
        $cartID = $request->cartId;
        $price = $request->price;

        $response = SellerPosUtility::updateCartItemPrice($cartID, $price);

        return array('success' => $response['success'], 'message' => $response['message'], 'view' => view('backend.seller_pos.cart')->render());
    }
}
