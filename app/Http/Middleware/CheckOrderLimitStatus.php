<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckOrderLimitStatus
{
    public function handle(Request $request, Closure $next)
    {
        if (check_order_status()) {
            return $next($request);
        } else {
            flash(translate('Order Limit Crossed or Plan Expired'))->error();
            return redirect()->route('admin.dashboard');
        }
    }
}