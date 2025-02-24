<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Http\Resources\PosProductCollection;
use App\Models\Address;
use App\Models\Cart;
use App\Models\City;
use App\Models\State;
use App\Utility\FontUtility;
use App\Utility\PosUtility;
use Session;
use Mpdf\Mpdf;

class PosController extends Controller
{
    public function __construct()
    {
        // Staff Permission Check
        $this->middleware(['permission:pos_manager'])->only('admin_index');
        $this->middleware(['permission:pos_configuration'])->only('pos_activation');
    }

    public function index()
    {
        $customers = User::where('user_type', 'customer')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('backend.pos.index', compact('customers'));
    }

    public function search(Request $request)
    {
        $products = PosUtility::product_search($request->only('category', 'brand', 'keyword'));

        $stocks = new PosProductCollection($products);
        $stocks->appends(['keyword' =>  $request->keyword, 'category' => $request->category, 'brand' => $request->brand]);
        return $stocks;
    }

    // Add product To cart
    public function addToCart(Request $request)
    {
        $stockId    = $request->stock_id;
        $sellerId   = $request->sellerId;

        $userID     = Session::get('pos.user_id');
        $temUserId  = Session::get('pos.temp_user_id');
        if (!$temUserId && !$userID) {
            $temUserId = bin2hex(random_bytes(10));
            Session::put('pos.temp_user_id', $temUserId);
        }
        $response = PosUtility::addToCart($stockId, $userID, $temUserId, $sellerId);

        if ($request->shipping != null) {
            Session::put('pos.shipping', $request->shipping);
        }

        return array(
            'success' => $response['success'],
            'message' => $response['message'],
            'view' => view('backend.pos.cart')->render()
        );
    }

    //updated the quantity for a cart item
    public function updateQuantity(Request $request)
    {
        $cart = Cart::find($request->cartId);
        $response = PosUtility::updateCartItemQuantity($cart, $request->only(['cartId', 'quantity']));

        return array('success' => $response['success'], 'message' => $response['message'], 'view' => view('backend.pos.cart')->render());
    }

    //removes from Cart
    public function removeFromCart(Request $request)
    {
        Cart::where('id', $request->id)->delete();
        return view('backend.pos.cart');
    }

    //Shipping Address for admin
    public function getShippingAddress(Request $request)
    {
        Session::forget('pos.shipping_info');
        $user_id = $request->id;
        return ($user_id == '') ? view('backend.pos.guest_shipping_address') : view('backend.pos.shipping_address', compact('user_id'));
    }

    public function set_shipping_address(Request $request)
    {
        $data = PosUtility::get_shipping_address($request);

        $shipping_info = $data;
        $request->session()->put('pos.shipping_info', $shipping_info);
    }

    // Update user Cart data when user is changed 
    public function updateSessionUserCartData(Request $request)
    {
        PosUtility::updateCartOnUserChange($request->only(['userId']));
        return view('backend.pos.cart');
    }

    //set Discount
    public function setDiscount(Request $request)
    {
        if ($request->discount >= 0) {
            Session::put('pos.discount', $request->discount);
        }
        return view('backend.pos.cart');
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
            Session::put('pos.shipping', $state->cost ?? 0);
        } elseif ($shippingType == 'area_wise_shipping') {
            $city = City::find($address->city_id);
            Session::put('pos.shipping', $city->cost ?? 0);
        }

        return view('backend.pos.cart');
    }

    //set Shipping Cost
    public function setShipping(Request $request)
    {
        if ($request->shipping != null) {
            Session::put('pos.shipping', $request->shipping);
        }

        return view('backend.pos.cart');
    }

    //order summary
    public function get_order_summary(Request $request)
    {
        return view('backend.pos.order_summary');
    }

    //order place
    public function order_store(Request $request)
    {
        $request->merge(['temp_usder_id' => Session::get('pos.temp_user_id'), 'shippingInfo' => Session::get('pos.shipping_info'), 'shippingCost' => Session::get('pos.shipping', 0), 'discount' => Session::get('pos.discount')]);
        $response = PosUtility::orderStore($request->except(['_token']));

        if ($response['success']) {
            Session::forget('pos.shipping_info');
            Session::forget('pos.shipping');
            Session::forget('pos.discount');
            Session::forget('pos.user_id');
            Session::forget('pos.temp_user_id');
        }

        return $response;
    }

    public function configuration()
    {
        return view('backend.pos.pos_activation');
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

        $html = view('backend.pos.thermal_invoice', compact('order', 'pdf_style_data'));

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
}
