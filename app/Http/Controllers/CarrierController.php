<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarrierRequest;
use App\Models\Carrier;
use App\Models\CarrierRange;
use App\Models\CarrierRangePrice;
use App\Models\Order;
use App\Models\Zone;
use Illuminate\Http\Request;

class CarrierController extends Controller
{
    public function __construct()
    {
        // Staff Permission Check
        $this->middleware(['permission:manage_carriers'])->only('index', 'create', 'edit', 'destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carriers = Carrier::paginate(15);
        return view('backend.setup_configurations.carriers.index', compact('carriers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $zones = Zone::get();
        return view('backend.setup_configurations.carriers.create', compact('zones'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CarrierRequest $request)
    {
        $free_shipping                  = isset($request->shipping_type) ? 1 : 0;

        $carrier                        = new Carrier;
        $carrier->name                  = $request->carrier_name;
        $carrier->transit_time          = $request->transit_time;
        $carrier->logo                  = $request->logo;
        $carrier->sandbox               = isset($request->sandbox) ? 1 : 0;
        $carrier->client_id             = $request->client_id;
        $carrier->client_secret         = $request->client_secret;
        $carrier->client_email          = $request->client_email;
        $carrier->client_password       = $request->client_password;
        $carrier->free_shipping         = $free_shipping;
        $carrier->save();

        // if not free shipping, then add the carrier ranges and prices
        // if ($free_shipping == 0) {
        //     for ($i = 0; $i < count($request->delimiter1); $i++) {

        //         // Add Carrier ranges
        //         $carrier_range                  = new CarrierRange;
        //         $carrier_range->carrier_id      = $carrier->id;
        //         $carrier_range->billing_type    = $request->billing_type;
        //         $carrier_range->delimiter1      = $request->delimiter1[$i];
        //         $carrier_range->delimiter2      = $request->delimiter2[$i];
        //         $carrier_range->save();

        //         // // Add carrier range prices
        //         // foreach ($request->zones as $zone) {
        //         //     $carrier_range_price =  new CarrierRangePrice;
        //         //     $carrier_range_price->carrier_id = $carrier->id;
        //         //     $carrier_range_price->carrier_range_id = $carrier_range->id;
        //         //     $carrier_range_price->zone_id = $zone;
        //         //     $carrier_range_price->price = $request->carrier_price[$zone][$i];
        //         //     $carrier_range_price->save();
        //         // }
        //     }
        // }
        flash(translate('New carrier has been added successfully'))->success();
        return 1;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $carrier = Carrier::findOrFail($id);
        $zones = Zone::get();
        return view('backend.setup_configurations.carriers.edit', compact('zones', 'carrier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CarrierRequest $request, $id)
    {
        $carrier                = Carrier::findOrfail($id);
        $carrier->name          = $request->carrier_name;
        $carrier->transit_time  = $request->transit_time;
        $carrier->logo          = $request->logo;
        $carrier->sandbox       = isset($request->sandbox) ? 1 : 0;

        foreach ($request->api_info as $key => $value) {
            $apiInfo[$key] = $value;
        }
        $carrier->api_info = json_encode($apiInfo);
        $free_shipping          = isset($request->shipping_type) ? 1 : 0;
        $carrier->free_shipping = $free_shipping;
        $carrier->save();

        $carrier->carrier_ranges()->delete();
        $carrier->carrier_range_prices()->delete();

        // if not free shipping, then add the carrier ranges and prices
        // if ($free_shipping == 0) {
        //     for ($i = 0; $i < count($request->delimiter1); $i++) {

        //         // Add Carrier ranges
        //         $carrier_range                  = new CarrierRange;
        //         $carrier_range->carrier_id      = $carrier->id;
        //         $carrier_range->billing_type    = $request->billing_type;
        //         $carrier_range->delimiter1      = $request->delimiter1[$i];
        //         $carrier_range->delimiter2      = $request->delimiter2[$i];
        //         $carrier_range->save();

        //         // Add carrier range prices
        //         // foreach ($request->zones as $zone) {
        //         //     $carrier_range_price =  new CarrierRangePrice;
        //         //     $carrier_range_price->carrier_id = $carrier->id;
        //         //     $carrier_range_price->carrier_range_id = $carrier_range->id;
        //         //     $carrier_range_price->zone_id = $zone;
        //         //     $carrier_range_price->price = $request->carrier_price[$zone][$i];
        //         //     $carrier_range_price->save();
        //         // }
        //     }
        // }
        flash(translate('New carrier has been added successfully'))->success();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $carrier = Carrier::findOrFail($id);

        $carrier->carrier_ranges()->delete();
        $carrier->carrier_range_prices()->delete();

        Carrier::destroy($id);

        flash(translate('Carrier has been deleted successfully'))->success();
        return redirect()->route('carriers.index');
    }

    // Carrier status Update
    public function updateStatus(Request $request)
    {
        $carrier = Carrier::findOrFail($request->id);
        $carrier->status = $request->status;
        if ($carrier->save()) {
            return 1;
        }
        return 0;
    }

    public function pathaoStatusUpdateByWebHook(Request $request)
    {
        // Set the secret value directly
        $pathaoSecret = 'f3992ecc-59da-4cbe-a049-a13da2018d51';

        // Retrieve the secret from the database (or settings) using get_zotc_setting
        $webhookId = get_zotc_setting('webhook_id');

        // Validate if the signature matches the stored secret
        $signature = $request->header('X-PATHAO-Signature');
        if ($signature !== $webhookId) {
            // Return 401 if the signature does not match
            return response('Unauthorized', 401)
                ->header('X-Pathao-Merchant-Webhook-Integration-Secret', $pathaoSecret);
        }

        // Validate event type
        if ($request->event == 'webhook_integration') {
            // Return success response for webhook_integration event
            return response('Webhook integration successful', 202)
                ->header('X-Pathao-Merchant-Webhook-Integration-Secret', $pathaoSecret);
        }

        // Handle other events, assuming status update is needed based on the event
        if ($request->has('consignment_id') && $request->has('event')) {
            // Extract status from the event name if needed (e.g., 'order.delivered')
            $event = explode('.', $request->event);
            $status = $event[1] ?? null;

            // Proceed to update the order if a valid consignment_id and status are found
            if ($status && $request->has('consignment_id')) {
                // Update the order status using consignment_id
                Order::where('tracking_code', $request->consignment_id)
                    ->update(['delivery_status' => $status]);
            }

            // Return success response for other events
            return response('Webhook integration successful', 202)
                ->header('X-Pathao-Merchant-Webhook-Integration-Secret', $pathaoSecret);
        }

        // Return 401 if the event is not valid or missing required data
        return response('Webhook integration not successful', 401)
            ->header('X-Pathao-Merchant-Webhook-Integration-Secret', $pathaoSecret);
    }


    public function steadfastStatusUpdateByWebHook(Request $request)
    {
        Order::where('tracking_code', $request->consignment_id)
            ->update(['delivery_status' => $request->status]);
    }
}
