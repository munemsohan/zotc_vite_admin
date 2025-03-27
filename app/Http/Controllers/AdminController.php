<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\BusinessSetting;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Color;
use App\Models\Order;
use App\Models\OtpConfiguration;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\Shop;
use App\Models\Upload;
use App\Models\User;
use App\Models\ZotcSetting;
use Artisan;
use Cache;
use Carbon\Carbon;
use CoreComponentRepository;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Writer\Ods\Settings;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_dashboard(Request $request)
    {
        CoreComponentRepository::initializeCache();
        $root_categories = Category::where('level', 0)->get();

        $data['cached_graph_data'] = Cache::remember('cached_graph_data', 86400, function () use ($root_categories) {
            $num_of_sale_data = null;
            $qty_data = null;
            foreach ($root_categories as $key => $category) {
                $category_ids = \App\Utility\CategoryUtility::children_ids($category->id);
                $category_ids[] = $category->id;

                $products = Product::with('stocks')->whereIn('category_id', $category_ids)->get();
                $qty = 0;
                $sale = 0;
                foreach ($products as $key => $product) {
                    $sale += $product->num_of_sale;
                    foreach ($product->stocks as $key => $stock) {
                        $qty += $stock->qty;
                    }
                }
                $qty_data .= $qty . ',';
                $num_of_sale_data .= $sale . ',';
            }
            $item['num_of_sale_data'] = $num_of_sale_data;
            $item['qty_data'] = $qty_data;

            return $item;
        });

        $data['root_categories'] = $root_categories;

        $data['total_customers'] = User::where('user_type', 'customer')->where('email_verified_at', '!=', null)->count();
        $data['top_customers'] = User::select('users.id', 'users.name', 'users.avatar_original', DB::raw('SUM(grand_total) as total'))
            ->join('orders', 'orders.user_id', '=', 'users.id')
            ->groupBy('orders.user_id')
            ->where('users.user_type', 'customer')
            ->orderBy('total', 'desc')
            ->limit(6)
            ->get();
        $data['total_products'] = Product::where('approved', 1)->where('published', 1)->count();
        $data['total_inhouse_products'] = Product::where('approved', 1)->where('published', 1)->where('added_by', 'admin')->count();
        $data['total_sellers_products'] = Product::where('approved', 1)->where('published', 1)->where('added_by', '!=', 'admin')->count();
        $data['total_categories'] = Category::count();


        $data['top_categories'] = Product::select('categories.name', 'categories.id', DB::raw('SUM(grand_total) as total'))
            ->leftJoin('order_details', 'order_details.product_id', '=', 'products.id')
            ->leftJoin('orders', 'orders.id', '=', 'order_details.order_id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->where('orders.delivery_status', 'delivered')
            ->groupBy('categories.id')
            ->orderBy('total', 'desc')
            ->limit(3)
            ->get();
        $data['total_brands'] = Brand::count();
        $data['top_brands'] = Product::select('brands.name', 'brands.id', DB::raw('SUM(grand_total) as total'))
            ->leftJoin('order_details', 'order_details.product_id', '=', 'products.id')
            ->leftJoin('orders', 'orders.id', '=', 'order_details.order_id')
            ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
            ->where('orders.delivery_status', 'delivered')
            ->groupBy('brands.id')
            ->orderBy('total', 'desc')
            ->limit(3)
            ->get();
        $data['total_sale'] = Order::where('delivery_status', 'delivered')->sum('grand_total');
        $data['sale_this_month'] = Order::whereMonth('created_at', Carbon::now()->month)->sum('grand_total');
        $data['admin_sale_this_month'] = Order::select(DB::raw('COALESCE(users.user_type, "admin") as user_type'), DB::raw('COALESCE(SUM(grand_total), 0) as total_sale'))
            ->leftJoin('users', 'orders.seller_id', '=', 'users.id')
            ->whereRaw('users.user_type = "admin"')
            ->whereMonth('orders.created_at', Carbon::now()->month)
            ->first();
        $data['seller_sale_this_month'] = Order::select(DB::raw('COALESCE(users.user_type, "seller") as user_type'), DB::raw('COALESCE(SUM(grand_total), 0) as total_sale'))
            ->leftJoin('users', 'orders.seller_id', '=', 'users.id')
            ->whereRaw('users.user_type = "seller"')
            ->whereMonth('orders.created_at', Carbon::now()->month)
            ->first();
        $sales_stat = Order::select('orders.user_id', 'users.name', 'users.user_type', 'users.avatar_original', DB::raw('SUM(grand_total) as total'), DB::raw('DATE_FORMAT(orders.created_at, "%M") AS month'))
            ->leftJoin('users', 'orders.seller_id', '=', 'users.id')
            ->whereRaw('users.user_type = "admin"')
            ->whereYear('orders.created_at', '=', Date("Y"))
            // ->orWhereRaw('users.user_type = "seller"')
            // ->groupBy('users.user_type')
            ->groupBy('month')
            ->orderBy(DB::raw('MONTH(orders.created_at)'), 'asc')
            ->get();
        $new_stat = array();
        foreach ($sales_stat as $row) {
            $new_stat[$row->month][] = $row;
        }
        $data['sales_stat'] = $new_stat;
        // dd($sales_stat);
        // "SELECT users.user_type, SUM(grand_total) FROM `orders` LEFT JOIN users ON orders.seller_id = users.id WHERE users.user_type = 'admin' OR users.user_type = 'seller' GROUP BY users.user_type, MONTH(orders.created_at)";
        $data['total_sellers'] = User::where('user_type', 'seller')->count();
        $data['status_wise_sellers'] = Shop::select('verification_status', DB::raw('COUNT(*) as total'))
            ->groupBy('verification_status')
            ->get();
        $data['top_sellers'] = Order::select('orders.seller_id', 'users.name', 'users.user_type', 'users.avatar_original', DB::raw('SUM(grand_total) as total'))
            ->leftJoin('users', 'orders.seller_id', '=', 'users.id')
            ->whereRaw('users.user_type = "seller"')
            ->groupBy('users.id')
            ->orderBy('total', 'desc')
            ->limit(6)
            ->get();


        // Fetch all counts grouped by delivery_status
        $ordersCount = Order::select('delivery_status', DB::raw('count(*) as total'))
            ->groupBy('delivery_status')
            ->get()
            ->keyBy('delivery_status')
            ->toArray();

        // Initialize the counters
        $data['total_order'] = array_sum(array_column($ordersCount, 'total'));
        $data['total_confirmed_order'] = $ordersCount['confirmed']['total'] ?? 0;
        $data['total_picked_up_order'] = $ordersCount['picked_up']['total'] ?? 0;
        $data['total_shipped_order'] = $ordersCount['shipped']['total'] ?? 0;
        $data['total_placed_order'] = array_sum(array_column($ordersCount, 'total')) - ($ordersCount['cancelled']['total'] ?? 0);
        $data['total_pending_order'] = $ordersCount['pending']['total'] ?? 0;
        $data['total_on_hold_order'] = $ordersCount['on_hold']['total'] ?? 0;
        $data['total_approved_order'] = $ordersCount['approved']['total'] ?? 0;
        $data['total_processing_order'] = $ordersCount['processing']['total'] ?? 0;
        $data['total_in_transit_order'] = $ordersCount['in_transit']['total'] ?? 0;
        $data['total_delivered_order'] = $ordersCount['delivered']['total'] ?? 0;
        $data['total_on_the_way_order'] = $ordersCount['on_the_way']['total'] ?? 0;
        $data['total_cancelled_order'] = $ordersCount['cancelled']['total'] ?? 0;

        $firstDayOfMonth = now()->startOfMonth();
        $lastDayOfMonth = now()->endOfMonth();

        $data['monthlyOrderCount'] = Order::whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])->count();
        $data['monthlySalesTotal'] = Order::whereBetween('created_at', [$firstDayOfMonth, $lastDayOfMonth])->sum('grand_total');

        $firstDayOfYear = now()->startOfYear();
        $lastDayOfYear = now()->endOfYear();

        $data['yearlyOrderCount'] = Order::whereBetween('created_at', [$firstDayOfYear, $lastDayOfYear])->count();
        $data['yearlySalesTotal'] = Order::whereBetween('created_at', [$firstDayOfYear, $lastDayOfYear])->sum('grand_total');

        $admin_id = User::select('id')->where('user_type', 'admin')->first()->id;
        $data['total_inhouse_sale'] = Order::where("seller_id", $admin_id)->sum('grand_total');
        $data['payment_type_wise_inhouse_sale'] = Order::select(DB::raw('case 
                                                    when payment_type in ("wallet") then "wallet"
                                                    when payment_type NOT in ("cash_on_delivery") then "others"
                                                    else cast(payment_type as char)
                                                    end as payment_type, SUM(grand_total)  as total_amount'),)
            ->where("user_id", '!=', null)
            ->where("seller_id", $admin_id)
            ->groupBy(DB::raw('1'))
            ->get();
        $data['inhouse_product_rating'] = Product::where('added_by', 'admin')->where('rating', '!=', 0)->avg('rating');
        $data['total_inhouse_order'] = Order::where("seller_id", $admin_id)->count();

        $domain = ZotcSetting::where('type', 'domains')->first();

        if ($domain) {
            $data['domains'] = json_decode($domain->value);
        }

        $sitesConnection = DB::connection('dynamic_db');
        $sitesConnection->getPdo()->exec("USE zotc_nazmart");

        $data['plans'] = $sitesConnection->table('price_plans')->get();

        return view('backend.dashboard', $data);
    }


    public function connect_custom_domain(Request $request)
    {
        $request->validate([
            'custom_domain' => 'required|regex:/^([a-zA-Z0-9-]+\.)+[a-zA-Z0-9]{2,}$/',
        ]);

        $domains = json_decode(get_zotc_setting('domains'));
        $free_domain = $domains->free_domain;
        $custom_domain = $request->custom_domain;

        try {
            $url = 'https://' . get_zotc_setting('central_domain') . '/active_connect_custom_domain';

            // Data to be sent in the POST request
            $postData = [
                'free_domain' => $free_domain,
                'custom_domain' => $custom_domain,
            ];

            // Send the POST request with the CSRF token
            $response = Http::post($url, $postData);

            // Check if the request was successful
            if ($response->successful()) {
                flash('Domain connected successfully.')->success();
                return redirect()->route('admin.dashboard');
            } else {
                flash('Domain connection failed')->error();
                return redirect()->route('admin.dashboard');
            }
        } catch (\Exception $e) {
            flash('Domain connection failed: ' . $e->getMessage())->error();
            return redirect()->route('admin.dashboard');
        }
    }

    public function planExtend(Request $request)
    {
        $request->validate([
            'payment_method' => 'required',
            'count' => 'required',
        ]);

        $payment_method = $request->payment_method;
        $count = $request->count;

        // Retrieve and process the plan settings
        $planSettings = ZotcSetting::where('type', 'plan')->value('value');
        $planSettingsArray = explode(',', $planSettings);
        $planId = $planSettingsArray[0];

        // Establish a connection to the dynamic database
        $sitesConnection = DB::connection('dynamic_db');
        $sitesConnection->getPdo()->exec("USE zotc_nazmart");

        // Retrieve the current plan details
        $currentPlan = $sitesConnection->table('price_plans')->where('id', $planId)->first();

        $domains = json_decode(get_zotc_setting('domains'));
        $free_domain = $domains->free_domain;

        $bdt_amount = (int)($currentPlan->price_bdt * $count);
        $usd_amount = (int)($currentPlan->price * $count);

        $token = Str::random(6);
        $sitesConnection->table('gateway_transactions')->insert([
            'user_id' => Auth::id(),
            'tran_id' => $token,
            'free_domain' => $free_domain,
            'db_name' => env('DB_DATABASE'),
            'plan_id'  => $planId,
            'count'  => $count,
            'amount' => $bdt_amount,
        ]);

        $success_url = route('plan.extend.success');
        $notify_url = 'https://zo.tc/notifywithpayment?purpose=plan_extend';
        $cancel_url = route('admin.dashboard');

        if ($payment_method == 'bkash') {
            executeBkashApiRequest($token, $bdt_amount, $success_url, $notify_url, $cancel_url);
        } else if ($payment_method == 'visa') {
            executeVisaApiRequest($token, $bdt_amount, $success_url, $notify_url, $cancel_url);
        } else if ($payment_method == 'paddle') {
            executePaddleApiRequest($token, $usd_amount, $success_url, $notify_url, $cancel_url);
        }
    }

    public function upgradePlan($payment_method, $plan_id)
    {
        $planSettings = ZotcSetting::where('type', 'plan')->first();

        $planSettings = explode(',', $planSettings->value);

        // Ensure proper formatting of date strings
        $startDateString = trim($planSettings[4], '" ');
        $endDateString = trim($planSettings[5], '" ');

        $startDate = Carbon::parse($startDateString);
        $endDate = Carbon::parse($endDateString);

        $today = Carbon::now();

        $sitesConnection = DB::connection('dynamic_db');
        $sitesConnection->getPdo()->exec("USE zotc_nazmart");

        $previous_plan = $sitesConnection->table('price_plans')->where('id', $planSettings[0])->first();
        $current_plan = $sitesConnection->table('price_plans')->where('id', $plan_id)->first();

        // if ($endDate->isPast()) {
        $bdt_amount = (float)$current_plan->price_bdt;
        $usd_amount = (float)$current_plan->price;
        // } else {
        //     // Calculate remaining days
        //     $remainingDays = $today->diffInDays($endDate);
        //     $remainingAmount = 0;


        //     if ($previous_plan->type == 1 && $previous_plan->price_bdt == 0) {
        //         $remainingAmount = 0;
        //     } elseif ($previous_plan->type == 0) {

        //         $remainingAmount = (float)$previous_plan->price_bdt / 30 * $remainingDays;
        //         dd($previous_plan->price_bdt);
        //     } elseif ($previous_plan->type == 1) {
        //         $remainingAmount = (float)$previous_plan->price_bdt / 365 * $remainingDays;
        //     }

        //     $bdt_amount = (float)$current_plan->price_bdt - $remainingAmount;
        // }

        $domains = json_decode(get_zotc_setting('domains'));
        $free_domain = $domains->free_domain;

        $token = Str::random(6);
        $sitesConnection->table('gateway_transactions')->insert([
            'user_id' => Auth::id(),
            'tran_id' => $token,
            'free_domain' => $free_domain,
            'db_name' => env('DB_DATABASE'),
            'plan_id'  => $plan_id,
            'amount' => $bdt_amount,
        ]);

        $success_url = route('plan.buy.success');
        $notify_url = 'https://zo.tc/notifywithpayment?purpose=plan_buy';
        $cancel_url = route('admin.dashboard');

        if ($payment_method == 'bkash') {
            executeBkashApiRequest($token, $bdt_amount, $success_url, $notify_url, $cancel_url);
        } else if ($payment_method == 'visa') {
            executeVisaApiRequest($token, $bdt_amount, $success_url, $notify_url, $cancel_url);
        } else if ($payment_method == 'paddle') {
            executePaddleApiRequest($token, $usd_amount, $success_url, $notify_url, $cancel_url);
        }
    }

    public function convertToPercentage()
    {
        $sitesConnection = DB::connection('dynamic_db');
        $sitesConnection->getPdo()->exec("USE zotc_nazmart");

        $plan = $sitesConnection->table('price_plans')->find(11);

        if ($plan && $plan->active_days) {
            $expiryDate = date('Y-m-d', strtotime('+' . $plan->active_days));
        } else {
            $expiryDate = Carbon::now()->addMonths(6)->format('Y-m-d H:i:s');
        }

        $plan_details = $plan ? implode(',', [
            $plan->id ?? 'N/A',
            $plan->title ?? 'N/A',
            $plan->price ?? 'N/A',
            $plan->price_bdt ?? 'N/A',
            Carbon::now()->format('Y-m-d'),
            $expiryDate,
            $plan->order_limit ?? 'N/A'
        ]) : '';

        $businessSetting = ZotcSetting::where('type', 'plan')->first();
        $businessSetting->value = $plan_details;
        $businessSetting->save();
    }

    public function buyLifeTimePlan($plan_type, $payment_method)
    {
        $validPlans = [
            'full_website' => 10000,
            'fraud_checker' => 2000, //previouly 5000
            'courier' => 2000
        ];

        if (!array_key_exists($plan_type, $validPlans)) {
            // Handle invalid plan type case
            return response()->json(['error' => 'Invalid plan type'], 400);
        }

        $bdt_amount = $validPlans[$plan_type];
        $usd_amount = $bdt_amount / 100;
        $token = Str::random(6);

        $domains = json_decode(get_zotc_setting('domains'));
        $free_domain = $domains->free_domain;

        DB::connection('dynamic_db')->statement("USE zotc_nazmart");

        DB::connection('dynamic_db')->table('gateway_transactions')->insert([
            'user_id' => Auth::id(),
            'tran_id' => $token,
            'note' => $plan_type,
            'free_domain' => $free_domain,
            'db_name' => env('DB_DATABASE'),
            'amount' => $bdt_amount,
        ]);

        $success_url = route('lifetime.plan.buy.success');
        $notify_url = 'https://zo.tc/notifywithpayment?purpose=lifetime_package_buy';
        $cancel_url = route('admin.dashboard');

        switch ($payment_method) {
            case 'bkash':
                executeBkashApiRequest($token, $bdt_amount, $success_url, $notify_url, $cancel_url);
                break;
            case 'visa':
                executeVisaApiRequest($token, $bdt_amount, $success_url, $notify_url, $cancel_url);
                break;
            case 'paddle':
                executePaddleApiRequest($token, $usd_amount, $success_url, $notify_url, $cancel_url);
                break;
            default:
                // Handle invalid payment method case
                return response()->json(['error' => 'Invalid payment method'], 400);
        }
    }


    public function buySms(Request $request)
    {
        $request->validate([
            'sms_payment_method' => 'required',
            'amount' => 'required',
        ]);

        $payment_method = $request->sms_payment_method;

        $amount = $request->amount;
        $bdt_amount = $amount;
        $usd_amount = $amount / 100;

        $currency = ZotcSetting::where('type', 'currency')->first();
        if ($currency->value == 'USD') {
            $usd_amount = $amount;
            $bdt_amount = $amount * 100;
        }

        $token = Str::random(6);
        $sitesConnection = DB::connection('dynamic_db');
        $sitesConnection->getPdo()->exec("USE zotc_nazmart");
        $sitesConnection->table('gateway_transactions')->insert([
            'user_id' => Auth::id(),
            'tran_id' => $token,
            'amount' => $bdt_amount,
            'db_name' => env('DB_DATABASE')
        ]);

        $success_url = route('sms.buy.success');
        $notify_url = 'https://zo.tc/notifywithpayment?purpose=sms_buy';
        $cancel_url = route('admin.dashboard');

        if ($payment_method == 'bkash') {
            executeBkashApiRequest($token, $bdt_amount, $success_url, $notify_url, $cancel_url);
        } else if ($payment_method == 'visa') {
            executeVisaApiRequest($token, $bdt_amount, $success_url, $notify_url, $cancel_url);
        } else if ($payment_method == 'paddle') {
            executePaddleApiRequest($token, $usd_amount, $success_url, $notify_url, $cancel_url);
        }
    }

    public function buyBalance(Request $request)
    {
        $request->validate([
            'payment_method' => 'required',
            'amount' => 'required',
        ]);

        $amount = $request->amount;
        $bdt_amount = $amount;
        $usd_amount = $amount / 100;

        $payment_method = $request->payment_method;

        $currency = ZotcSetting::where('type', 'currency')->first();

        if ($currency->value == 'USD') {
            $usd_amount = $amount;
            $bdt_amount = $amount * 100;
        }

        $token = Str::random(6);
        $sitesConnection = DB::connection('dynamic_db');
        $sitesConnection->getPdo()->exec("USE zotc_nazmart");
        $sitesConnection->table('gateway_transactions')->insert([
            'user_id' => Auth::id(),
            'tran_id' => $token,
            'amount' => $amount,
            'db_name' => env('DB_DATABASE')
        ]);

        $success_url = route('balance.buy.success');
        $notify_url = 'https://zo.tc/notifywithpayment?purpose=balance_buy';
        $cancel_url = route('admin.dashboard');

        if ($payment_method == 'bkash') {
            executeBkashApiRequest($token, $bdt_amount, $success_url, $notify_url, $cancel_url);
        } else if ($payment_method == 'visa') {
            executeVisaApiRequest($token, $bdt_amount, $success_url, $notify_url, $cancel_url);
        } else if ($payment_method == 'paddle') {
            executePaddleApiRequest($token, $usd_amount, $success_url, $notify_url, $cancel_url);
        }
    }

    public function top_category_products_section(Request $request)
    {
        $top_categories_products = DB::table(DB::raw('(SELECT products.id product_id, products.name product_name, products.slug product_slug, products.auction_product, products.category_id,
                                                        `products`.`thumbnail_img` as `product_thumbnail_img`, od.sales, od.total, od.created_at order_detail_created, 
                                                        categories.name AS category_name,
                                                        `categories`.`cover_image`,
                                                        ROW_NUMBER() OVER (PARTITION BY products.category_id ORDER BY od.sales DESC) rn 
                                                from products 
                                                INNER JOIN (
                                                SELECT product_id, SUM(quantity) sales, SUM(price + tax) AS total, created_at
                                                FROM order_details
                                                WHERE ' . ($request->interval_type == 'all' ?: 'created_at >= DATE_SUB(NOW(), INTERVAL 1 ' . $request->interval_type . ')') . '
                                                AND order_details.delivery_status = "delivered"
                                                GROUP BY product_id
                                                )  od ON od.product_id = products.id
                                                LEFT JOIN categories ON products.category_id = categories.id
                                                ) t'))
            ->select(DB::raw('category_id, category_name, cover_image, product_id, product_name, product_slug, auction_product, product_thumbnail_img, sales, total, order_detail_created'))
            ->where('rn', '<=', 3)
            ->orderBy('sales', 'desc')
            ->get();

        $category_array = [];
        $new_array = array();
        foreach ($top_categories_products as $key => $row) {
            $row->product_thumbnail_img = Upload::where('id', $row->product_thumbnail_img)->first();
            $category_array[] = $row->category_id;
            $new_array[$row->category_id][] = $row;
        }
        $top_categories2 = array_unique($category_array);
        $top_categories_products = $new_array;

        return view('backend.dashboard.top_category_products_section', compact('top_categories2', 'top_categories_products'))->render();
    }

    public function inhouse_top_categories(Request $request)
    {
        $inhouse_top_category_query = Order::query();
        $inhouse_top_category_query->select('categories.id', 'categories.name', 'categories.cover_image', DB::raw('SUM(order_details.price + order_details.tax) as total'))
            ->leftJoin('order_details', 'orders.id', '=', 'order_details.order_id')
            ->leftJoin('products', 'order_details.product_id', '=', 'products.id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->where('orders.delivery_status', '=', 'delivered')
            ->whereRaw('products.added_by = "admin"');
        if ($request->interval_type != 'all') {
            $inhouse_top_category_query->where('orders.created_at', '>=', DB::raw('DATE_SUB(NOW(), INTERVAL 1 ' . $request->interval_type . ')'));
        }
        $inhouse_top_categories = $inhouse_top_category_query->groupBy('categories.name')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        return view('backend.dashboard.inhouse_top_categories', compact('inhouse_top_categories'))->render();
    }

    public function inhouse_top_brands(Request $request)
    {
        $inhouse_top_brand_query = Order::query();
        $inhouse_top_brand_query->select('brands.id', 'brands.name', 'brands.logo', DB::raw('SUM(order_details.price + order_details.tax) as total'))
            ->leftJoin('order_details', 'orders.id', '=', 'order_details.order_id')
            ->leftJoin('products', 'order_details.product_id', '=', 'products.id')
            ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
            ->where('orders.delivery_status', '=', 'delivered')
            ->where('products.brand_id', '!=', null)
            ->whereRaw('products.added_by = "admin"');
        if ($request->interval_type != 'all') {
            $inhouse_top_brand_query->where('orders.created_at', '>=', DB::raw('DATE_SUB(NOW(), INTERVAL 1 ' . $request->interval_type . ')'));
        }
        $inhouse_top_brands = $inhouse_top_brand_query->groupBy('brands.name')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        return view('backend.dashboard.inhouse_top_brands', compact('inhouse_top_brands'))->render();
    }

    public function top_sellers_products_section(Request $request)
    {
        // $top_sellers_products = DB::table(DB::raw('(SELECT products.id product_id, products.name product_name, products.user_id,
        //                                                 `products`.`thumbnail_img` as `product_thumbnail_img`, od.sales, od.total, shops.name AS shop_name,
        //                                                 `shops`.`logo`,
        //                                                 ROW_NUMBER() OVER (PARTITION BY products.user_id ORDER BY od.sales DESC) rn 
        //                                     from products 
        //                                     INNER JOIN (
        //                                         SELECT product_id, SUM(quantity) sales, SUM(price + tax) AS total, created_at
        //                                         FROM order_details
        //                                         WHERE ' . ($request->interval_type == 'all' ?: 'created_at >= DATE_SUB(NOW(), INTERVAL 1 ' . $request->interval_type . ')') . '
        //                                         AND order_details.delivery_status = "delivered"
        //                                         GROUP BY product_id
        //                                     )  od ON od.product_id = products.id
        //                                     LEFT JOIN shops ON products.user_id = shops.user_id
        //                                 ) t'))
        //     ->select(DB::raw('user_id, shop_name, logo, product_id, product_name, product_thumbnail_img, sales, total'))
        //     ->where('rn', '<=', 3)
        //     ->where('shop_name', '!=', null)
        //     ->orderBy('total', 'desc')
        //     ->get();

        $new_top_sellers_query = Order::query();
        $new_top_sellers_query = Order::select('shops.user_id AS shop_id', 'shops.name AS shop_name', 'shops.logo', DB::raw('SUM(grand_total) AS sale'))
            ->join('shops', 'orders.seller_id', '=', 'shops.user_id')
            ->whereIn("seller_id", function ($query) {
                $query->select('id')
                    ->from('users')
                    ->where('user_type', 'seller');
            })
            ->where('orders.delivery_status', 'delivered')
            ->groupBy('orders.seller_id')
            ->orderBy('sale', 'desc');
        if ($request->interval_type != 'all') {
            $new_top_sellers_query->where('orders.created_at', '>=', DB::raw('DATE_SUB(NOW(), INTERVAL 1 ' . $request->interval_type . ')'));
        }

        $new_top_sellers = $new_top_sellers_query->get();

        foreach ($new_top_sellers as $key => $row) {
            $products_query = Product::query();
            $products_query->select('products.id AS product_id', 'products.name', 'products.slug AS product_slug', 'products.auction_product', 'products.thumbnail_img', DB::raw('SUM(quantity) AS total_quantity, SUM(price * quantity) AS sale'))
                ->join('order_details', 'order_details.product_id', '=', 'products.id')
                ->where("seller_id", $row->shop_id)
                ->where('order_details.delivery_status', 'delivered')
                ->where('products.approved', 1)
                ->where('products.published', 1);
            if ($request->interval_type != 'all') {
                $products_query->where('order_details.created_at', '>=', DB::raw('DATE_SUB(NOW(), INTERVAL 1 ' . $request->interval_type . ')'));
            }
            $products_query->groupBy('product_id')
                ->orderBy('sale', 'desc')
                ->limit(3);
            $row->products = $products_query->get();
            // $row->product_thumbnail_img = Upload::where('id', $row->product_thumbnail_img)->first();
            // $seller_array[] = $row->user_id;
            // $new_top_sellers_products_array[$row->user_id][] = $row;
            // echo '<pre>';print_r($new_top_sellers);
        }
        // dd($new_top_sellers);
        // $top_sellers2 = array_unique($seller_array);
        // $top_sellers_products = $new_top_sellers_products_array;

        // return view('backend.dashboard.top_sellers_products_section', compact('top_sellers2', 'top_sellers_products'))->render();
        return view('backend.dashboard.top_sellers_products_section', compact('new_top_sellers'))->render();
    }

    public function top_brands_products_section(Request $request)
    {
        $top_brands_products = DB::table(DB::raw('(SELECT products.id product_id, products.name product_name, products.slug product_slug, products.auction_product, products.brand_id,
                                                        `products`.`thumbnail_img` as `product_thumbnail_img`, od.sales, od.total, brands.name AS brand_name,
                                                        `brands`.`logo`,
                                                        ROW_NUMBER() OVER (PARTITION BY products.brand_id ORDER BY od.sales DESC) rn 
                                            from products 
                                            INNER JOIN (
                                                SELECT product_id, SUM(quantity) sales, SUM(price + tax) AS total, created_at
                                                FROM order_details
                                                WHERE ' . ($request->interval_type == 'all' ?: 'created_at >= DATE_SUB(NOW(), INTERVAL 1 ' . $request->interval_type . ')') . '
                                                AND order_details.delivery_status = "delivered"
                                                GROUP BY product_id
                                            )  od ON od.product_id = products.id
                                            LEFT JOIN brands ON products.brand_id = brands.id
                                        ) t'))
            ->select(DB::raw('brand_id, brand_name, logo, product_id, product_name, product_slug, auction_product, product_thumbnail_img, sales, total'))
            ->where('rn', '<=', 3)
            ->orderBy('total', 'desc')
            ->where('brand_name', '!=', null)
            ->get();

        $brand_array = [];
        $new_array = [];
        foreach ($top_brands_products as $key => $row) {
            $row->product_thumbnail_img = Upload::where('id', $row->product_thumbnail_img)->first();
            $brand_array[] = $row->brand_id;
            $new_array[$row->brand_id][] = $row;
        }

        $top_brands2 = array_unique($brand_array);
        $top_brands_products = $new_array;

        return view('backend.dashboard.top_brands_products_section', compact('top_brands2', 'top_brands_products'))->render();
    }

    function clearCache(Request $request)
    {
        Artisan::call('optimize:clear');
        flash(translate('Cache cleared successfully'))->success();
        return back();
    }

    public function clearDomainCache()
    {
        // Retrieve the main domain
        $domain = get_domain();

        // Cache keys to clear
        $cacheKeys = [
            '_active_countries',
            '_system_default_currency',
            '_business_settings',
            '_zotc_settings',
            '_addons',
            '_all_languages',
            '_best_selers',
            '_newest_products',
        ];

        // Clear cache for the main domain
        foreach ($cacheKeys as $key) {
            Cache::forget($domain . $key);
        }

        // Attempt to send a clear-cache request for the main domain
        $this->sendClearCacheRequest($domain . '/clear-cache');
        flash($domain . ' caches cleared successfully')->success();

        // Handle custom domains
        $settings = ZotcSetting::where('type', 'domains')->first();
        if ($settings) {
            $domains = json_decode($settings->value);

            if (!empty($domains->custom_domain)) {
                foreach ($domains->custom_domain as $customDomain) {

                    foreach ($cacheKeys as $key) {
                        Cache::forget($customDomain . $key);
                    }

                    // Attempt to send a clear-cache request for each custom domain
                    $this->sendClearCacheRequest($customDomain . '/clear-cache');
                    flash($customDomain . ' caches cleared successfully')->success();
                }
            }
        }

        // Redirect back to the previous page
        return back();
    }

    private function sendClearCacheRequest($url)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
        ]);

        curl_exec($curl);

        curl_close($curl);
    }

    function switchShop($shop)
    {
        $subdomain = $shop;
        $all_shops = getAllShops();

        $selectedShop = collect($all_shops)->first(function ($tenant) use ($subdomain) {
            return $tenant->id === $subdomain;
        });

        if ($selectedShop) {
            $ownerEmail = Auth::user()->email;

            $sitesConnection = DB::connection('dynamic_db');
            $sitesConnection->getPdo()->exec("USE zotc_nazmart");

            $userApiKey = $sitesConnection->table('users')
                ->where('email', $ownerEmail)
                ->value('api_key');

            $central_domain = get_zotc_setting('central_domain');

            echo "<form id='switchShopForm' action='https://{$subdomain}.{$central_domain}/admin/shop/switch' method='POST' style='display:none;'>";
            echo "<input type='hidden' name='api_key' value='{$userApiKey}'/>";
            echo "</form>";
            echo "<script>document.getElementById('switchShopForm').submit();</script>";
        } else {
            flash(translate('Shop Not Found'))->error();
            return back();
        }
    }

    function mainAdminLogin()
    {
        $ownerEmail = Auth::user()->email;

        if ($ownerEmail) {
            echo "<form id='switchShopForm' action='https://" . get_zotc_setting('central_domain') . "/switchedfromshop' method='POST' style='display:none;'>";
            echo "<input type='hidden' name='email' value='{$ownerEmail}'/>";
            echo "</form>";
            echo "<script>document.getElementById('switchShopForm').submit();</script>";
        } else {
            return redirect('user-home')->with(['msg' => 'Shop not found for this user', 'type' => 'danger']);
        }
    }

    public function getSwitched(Request $request)
    {
        $apiKey = $request->api_key;

        $shopOwner = User::where('user_type', 'admin')->first();

        $sitesConnection = DB::connection('dynamic_db');
        $sitesConnection->getPdo()->exec("USE zotc_nazmart");

        $userApiKey = $sitesConnection->table('users')
            ->where('email', $shopOwner->email)
            ->value('api_key');

        if ($userApiKey == $apiKey) {

            Auth::login($shopOwner);

            if (Auth::check()) {
                Artisan::call('optimize:clear');
                flash(translate('Shop switched successfully'))->success();
                return redirect('admin');
            } else {
                $responseData = [
                    'message' => 'Shop switched not success',
                ];
            }

            return response()->json($responseData);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function apiAdminLogin(Request $request)
    {
        // Validate request data
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8',
        ]);

        // Prepare credentials
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        // Attempt authentication
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid login credentials.',
            ], 401);
        }

        $user = Auth::user();

        // Handle admin users
        if ($user->user_type === 'admin') {
            return redirect('admin');
        } else {
            Auth::logout();
            return response()->json([
                'success' => false,
                'message' => 'Access Denied! Admins only',
            ], 401);
        }
    }

    public function shopbase_import()
    {
        // Fetch shopbase data
        $shopbase_json = file_get_contents('https://i.zo.tc/shopbase/product_details_4.json');
        $shopbase_data = json_decode($shopbase_json, true);

        if (!$shopbase_data || !is_array($shopbase_data)) {
            echo "Invalid shopbase data.";
            return;
        }

        $importedCount = 0;
        $failedCount = 0;

        foreach ($shopbase_data as $productData) {
            try {
                // Validate and process category
                $categoryName = $productData['Category'] ?? null;

                if (!$categoryName) {
                    echo "Missing category for product: " . json_encode($productData) . "\n";
                    $failedCount++;
                    continue;
                }

                $category = Category::firstOrCreate(
                    ['slug' => Str::slug($categoryName)],
                    ['name' => $categoryName]
                );

                // Create product
                $product = new Product();
                $product->name = $productData['Name'] ?? 'Unnamed Product';
                $product->user_id = 1;
                $product->category_id = $category->id;

                // Generate unique slug
                $baseSlug = Str::slug($product->name);
                $slug = $baseSlug;
                $counter = 1;

                while (Product::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $counter++;
                }
                $product->slug = $slug;

                // Process images
                $imageName = $productData['ImageName'] ?? null;
                $imageUploadPath = $imageName ? "https://i.zo.tc/shopbase/{$imageName}" : null;

                if ($imageUploadPath) {
                    $imagePath = processImage($imageUploadPath, 500);
                    $thumbnailPath = processImage($imageUploadPath, 200, 200);

                    if ($imagePath && $thumbnailPath) {
                        $imageUpload = Upload::create([
                            'file_name' => $imagePath,
                            'thumbnail' => $thumbnailPath
                        ]);

                        $product->photos = $imageUpload->id;
                        $product->thumbnail_img = $imageUpload->id;
                    }
                } else {
                    echo "Image not found for product: " . json_encode($productData) . "\n";
                }

                // Set product details
                $product->description = $productData['Description'] ?? '';
                $product->purchase_price = $productData['Buying_Price'] ?? 0;
                $product->unit_price = $productData['Selling_Price'] ?? 0;
                $product->current_stock = 10;
                $product->unit = 'pc';

                $product->published = 1;
                $product->approved = 1;

                // Process attributes and choice options
                $attributes = $productData['Variant'] ?? '';
                $attributes = str_replace(' ', '', preg_replace('/\x{A0}/u', '', trim($attributes)));
                $attributeValues = explode(',', $attributes);
                $choiceOptions = [];
                $productAttributes = [];
                $attributeId = 1;

                if (!empty($attributeValues)) {
                    $productAttributes[] = (string)$attributeId;

                    $choiceValues = [];
                    foreach ($attributeValues as $value) {
                        $attributeValue = AttributeValue::firstOrCreate(
                            ['value' => $value, 'attribute_id' => $attributeId]
                        );
                        $choiceValues[] = $attributeValue->value;
                    }

                    $product->variant_product = 1;
                    $choiceOptions[] = [
                        'attribute_id' => (string)$attributeId,
                        'values' => $choiceValues
                    ];
                }

                $product->attributes = json_encode($productAttributes);
                $product->choice_options = json_encode($choiceOptions);
                $product->save();

                if (!empty($attributeValues)) {
                    foreach ($attributeValues as $value) {
                        ProductStock::create([
                            'product_id' => $product->id,
                            'variant' => $value,
                            'sku' => Str::random(10),
                            'price' => $product->unit_price,
                            'qty' => 10
                        ]);
                    }
                } else {
                    ProductStock::create([
                        'product_id' => $product->id,
                        'variant' => '',
                        'sku' => Str::random(10),
                        'price' => $product->unit_price,
                        'qty' => 10
                    ]);
                }

                $importedCount++;
            } catch (\Exception $e) {
                dd($productData);
                echo "Error importing product: " . $e->getMessage() . "\n";
                $failedCount++;
            }
        }

        echo "Products Imported: {$importedCount}\n";
        echo "Products Failed: {$failedCount}\n";
    }

    public function mohasagor_import()
    {
        // Fetch mohasagor data
        $mohasagorJson = file_get_contents('https://i.zo.tc/mohasagor/all_products.json');
        $mohasagorData = json_decode($mohasagorJson, true);

        if (!$mohasagorData || !is_array($mohasagorData)) {
            echo "Invalid mohasagor data.";
            return;
        }

        $importedCount = 0;
        $failedCount = 0;

        foreach ($mohasagorData as $productData) {
            // try {
            // Validate category
            $categoryName = $productData['category'] ?? null;
            if (!$categoryName) {
                $this->logError($productData, "Missing category");
                $failedCount++;
                continue;
            }

            $category = Category::firstOrCreate(
                ['slug' => Str::slug($categoryName)],
                ['name' => $categoryName]
            );

            // Create and set up product
            $product = $this->createProduct($productData, $category->id);

            // Process product images
            if (!empty($productData['product_images'])) {
                $image_ids = '';
                foreach ($productData['product_images'] as $image) {
                    if (!empty($image['product_image'])) {
                        $imagePath = processImage(Str::random(10), "https://i.zo.tc/mohasagor/{$image['product_image']}", 500);
                        if ($imagePath) {
                            $imageUpload = Upload::create([
                                'file_name' => $imagePath,
                                'thumbnail' => $imagePath
                            ]);
                            $image_ids .= $imageUpload->id . ',';
                        }
                    }
                }
                $product->photos = rtrim($image_ids, ',');
            }

            // Process thumbnail image
            $thumbnailImg = $productData['thumbnail_img'] ?? null;
            if ($thumbnailImg) {
                $thumbnailPath = $this->processThumbnail(Str::random(10), "https://i.zo.tc/mohasagor/{$thumbnailImg}", null, 200, 200);
                if ($thumbnailPath) {
                    $thumbnailUpload = Upload::create([
                        'file_name' => $thumbnailPath,
                        'thumbnail' => $thumbnailPath
                    ]);
                    $product->thumbnail_img = $thumbnailUpload->id;
                }
            }

            // Save product
            $product->save();

            // Handle variants or default stock
            $this->processProductVariants($product, $productData['product_variants'] ?? []);

            $importedCount++;
            // } catch (\Exception $e) {
            //     $this->logError($productData, $e->getMessage());
            //     $failedCount++;
            // }

            // if ($importedCount >= 10) {
            //     break;
            // }
        }

        echo "Products Imported: {$importedCount}\n";
        echo "Products Failed: {$failedCount}\n";
    }

    private function createProduct(array $productData, int $categoryId): Product
    {
        $product = new Product();

        // Decode and set the product name
        $decodedName = isset($productData['name']) ? $this->decodeUnicodeString($productData['name']) : 'Unnamed Product';
        $product->name = $decodedName;

        $product->user_id = 1;
        $product->category_id = $categoryId;

        // Generate slug if not provided
        $decodedSlug = isset($productData['slug'])
            ? $this->decodeUnicodeString($productData['slug'])
            : Str::slug($decodedName);

        // Append a 6-digit random string
        $randomString = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6);
        $product->slug = $decodedSlug . '-' . $randomString;

        // Description and pricing details
        $decodedDescription = isset($productData['details']) ? $this->decodeUnicodeString($productData['details']) : '';
        $product->description = $decodedDescription;
        $product->purchase_price = (float)($productData['price'] ?? 0);
        $product->unit_price = (float)($productData['sale_price'] ?? 0);

        // Default stock, unit, and status
        $product->current_stock = $productData['current_stock'] ?? 10;
        $product->unit = $productData['unit'] ?? 'pc';
        $product->attributes = json_encode([]);
        $product->colors = json_encode([]);
        $product->choice_options = json_encode([]);
        $product->variant_product = 1;
        $product->published = $productData['published'] ?? 1;
        $product->approved = $productData['approved'] ?? 1;

        return $product;
    }


    /**
     * Decodes a Unicode-encoded string to its readable form.
     *
     * @param string $string
     * @return string
     */
    private function decodeUnicodeString($string): string
    {
        $decodedString = json_decode('"' . $string . '"');

        $pattern = '[^a-zA-Z\u0980-\u09FF\s.,!?;:\'\"()]+';

        $cleanedString = mb_ereg_replace($pattern, '', $decodedString);

        return $cleanedString;
    }


    private function processProductVariants($product, $variants)
    {
        if (!empty($variants)) {
            $attributeIds = [];
            $choiceOptions = [];
            $colorHexes = [];

            foreach ($variants as $variant) {
                if ($variant['attribute'] === 'Color') {
                    // Check if the color exists in the colors table
                    $existingColor = Color::where('name', $variant['variant'])->first();

                    if ($existingColor) {
                        // Use the existing color code
                        $colorHex = $existingColor->code;
                    } else {
                        // Generate a random hex code
                        $colorHex = $this->convertColorToHex($variant['variant']);

                        // Save the new color in the colors table
                        Color::create([
                            'name' => $variant['variant'],
                            'code' => $colorHex,
                        ]);
                    }

                    // Avoid duplicate hex entries
                    if (!in_array($colorHex, $colorHexes)) {
                        $colorHexes[] = $colorHex;
                    }

                    // Create product stock entry for each non-color variant
                    ProductStock::create([
                        'product_id' => $product->id,
                        'variant' => $variant['variant'],
                        'sku' => Str::random(10),
                        'price' => $product->unit_price,
                        'qty' => 10,
                    ]);
                } else {
                    // Handle Size or other attributes
                    $attribute = Attribute::firstOrCreate(['name' => $variant['attribute']]);
                    $attributeValue = AttributeValue::firstOrCreate([
                        'attribute_id' => $attribute->id,
                        'value' => $variant['variant'],
                    ]);

                    // Save attribute ID for non-color attributes
                    $attributeIdString = (string)$attribute->id; // Convert to string
                    if (!in_array($attributeIdString, $attributeIds)) {
                        $attributeIds[] = $attributeIdString;
                    }

                    // Prepare choice options
                    if (!isset($choiceOptions[$attribute->id])) {
                        $choiceOptions[$attribute->id] = [
                            'attribute_id' => $attribute->id,
                            'values' => [],
                        ];
                    }
                    if (!in_array($attributeValue->value, $choiceOptions[$attribute->id]['values'])) {
                        $choiceOptions[$attribute->id]['values'][] = $attributeValue->value;
                    }

                    // Create product stock entry for each non-color variant
                    ProductStock::create([
                        'product_id' => $product->id,
                        'variant' => $attributeValue->value,
                        'sku' => Str::random(10),
                        'price' => $product->unit_price,
                        'qty' => 10,
                    ]);
                }
            }

            // Save colors, attributes, and choice options
            $product->colors = json_encode($colorHexes); // Save color hex codes
            $product->attributes = json_encode($attributeIds); // Save attribute IDs as strings
            $product->choice_options = json_encode(array_values($choiceOptions)); // Save choice options

            $product->variant_product = 1; // Mark product as having variants
            $product->save();
        } else {
            // Create default stock if no variants are present
            ProductStock::create([
                'product_id' => $product->id,
                'variant' => '',
                'sku' => Str::random(10),
                'price' => $product->unit_price,
                'qty' => 10,
            ]);
        }
    }


    private function getColorHexCodes($colorNames)
    {
        $hexCodes = [];
        foreach ($colorNames as $color) {
            $hexCodes[] = $this->convertColorToHex($color);
        }
        return $hexCodes;
    }

    private function convertColorToHex($color)
    {
        $colors = [
            'White' => '#ffffff',
            'Black' => '#000000',
            'Red' => '#ff0000',
            'Green' => '#00ff00',
            'Blue' => '#0000ff',
            'Yellow' => '#ffff00',
            'Purple' => '#800080',
            'Orange' => '#ffa500',
            'Pink' => '#ffc0cb',
            'Brown' => '#a52a2a',
            'Gray' => '#808080',
            'Cyan' => '#00ffff',
            'Magenta' => '#ff00ff',
            'Lime' => '#00ff00',
            'Maroon' => '#800000',
            'Olive' => '#808000',
            'Navy' => '#000080',
            'Teal' => '#008080',
            'Silver' => '#c0c0c0',
            'Gold' => '#ffd700',
            'Beige' => '#f5f5dc',
            'Coral' => '#ff7f50',
            'Ivory' => '#fffff0',
            'Turquoise' => '#40e0d0',
            'Violet' => '#ee82ee',
        ];

        return $colors[$color] ?? '#000000';
    }

    private function logError($productData, $message)
    {
        echo "Error importing product (ID: " . ($productData['slug'] ?? 'Unknown') . "): {$message}\n";
    }

    public function mohasagor_update()
    {
        $products = Product::all();

        $updatedProductsCount = 0;

        foreach ($products as $product) {
            try {
                $unit_price = $product->unit_price;
                $purchase_price = $product->purchase_price;

                // Swap the prices
                $product->unit_price = $purchase_price;
                $product->purchase_price = $unit_price;
                $product->save();

                $updatedProductsCount++; // Increment product update count

                foreach ($product->stocks as $stock) {
                    try {
                        $stock->price = $product->unit_price;
                        $stock->save();
                    } catch (\Exception $e) {
                        // Log stock update failure
                        // \Log::error("Failed to update stock for product ID {$product->id}: {$e->getMessage()}");
                    }
                }
            } catch (\Exception $e) {
                // Log product update failure
                // \Log::error("Failed to update product ID {$product->id}: {$e->getMessage()}");
            }
        }

        return response()->json([
            'success' => true,
            'message' => "Update completed.",
            'updated_products' => $updatedProductsCount
        ]);
    }

    public function fraudChecker(Request $request)
    {
        return view('backend.fraud_checker.index');
    }

    public function fraudCheckerCheck(Request $request)
    {
        $request->validate([
            'phone' => 'required|string'
        ]);

        $phone = $request->phone;

        $domain = ZotcSetting::where('type', 'domains')->first();
        $domains = json_decode($domain->value);
        $freeDomain = $domains->free_domain;

        // Fetch OrderGuard and Steadfast Data
        $orderguardData = $this->fetchApiData('https://www.root6.xyz/wp-content/plugins/orderguard2/orderguard.php', [
            'apiKey' => '5467yujhgfred54erwsd',
            'number' => $phone,
            'shop_url' => $freeDomain
        ]);

        $steadfastData = $this->fetchApiData("https://ipinfo.zotc.pw/steadfast-com/api.php", [
            'key'    => '3456yjhgfde456',
            'mobile' => $phone,
            'shop_url' => $freeDomain
        ]);

        //update fraud checker
        ZotcSetting::updateOrCreate(
            ['type' => 'fraud_checker_count'],
            ['value' => (int)get_zotc_setting('fraud_checker_count') + 1]
        );

        // Return View with Data
        return view('backend.fraud_checker.fraud_checker', [
            'orderguardData' => $orderguardData['success'] ?? '',
            'steadfastData' => $steadfastData['data'] ?? []
        ]);
    }

    public function getFraudComments(Request $request)
    {
        $request->validate([
            'phone' => 'required|string'
        ]);

        $phone = $request->phone;

        // Fetch Steadfast Data
        $steadfastData = $this->fetchApiData("https://ipinfo.zotc.pw/steadfast-com/api.php", [
            'key'    => '3456yjhgfde456',
            'mobile' => $phone
        ]);

        // Render the view and return it as a string
        $view = view('partials.fraud_checker.comments', [
            'steadfastData' => $steadfastData['data'] ?? []
        ])->render();

        // Return the view content and the count of data in JSON response
        return response()->json([
            'html' => $view,
            'count' => count($steadfastData['data'] ?? [])
        ]);
    }

    private function fetchApiData(string $url, array $params): array
    {
        try {
            $response = Http::timeout(10)->get($url, $params);

            // Return the data if the response is successful, otherwise return an empty array
            return $response->successful() ? $response->json() : [];
        } catch (\Exception $e) {
            return [];
        }
    }
}
