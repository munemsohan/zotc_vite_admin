<?php

/*
|--------------------------------------------------------------------------
| POS Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\PosController;
use App\Http\Controllers\SellerPosController as AdminSellerPosController;
use App\Http\Controllers\Seller\PosController as SellerPosController;

Route::controller(PosController::class)->group(function () {});

//Admin
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin', 'check.order.limit']], function () {
    //pos
    Route::controller(PosController::class)->group(function () {
        Route::get('/pos', 'index')->name('point-of-sales.index');
        Route::get('/pos/products', 'search')->name('pos.search_product');
        Route::post('/add-to-cart-pos', 'addToCart')->name('pos.addToCart');
        Route::post('/update-quantity-cart-pos', 'updateQuantity')->name('pos.updateQuantity');
        Route::post('/remove-from-cart-pos', 'removeFromCart')->name('pos.removeFromCart');
        Route::post('/update-session-user-cart-data', 'updateSessionUserCartData')->name('pos.updateSessionUserCartData');
        Route::post('/get_shipping_address', 'getShippingAddress')->name('pos.getShippingAddress');
        Route::post('/setDiscount', 'setDiscount')->name('pos.setDiscount');
        Route::post('/setShipping', 'setShipping')->name('pos.setShipping');
        Route::post('/setShippingByCustomer', 'setShippingByCustomer')->name('pos.setShippingByCustomer');
        Route::post('/set-shipping-address', 'set_shipping_address')->name('pos.set-shipping-address');
        Route::post('/pos-order-summary', 'get_order_summary')->name('pos.getOrderSummary');
        Route::post('/pos-order', 'order_store')->name('pos.order_place');
        Route::get('/pos-activation', 'configuration')->name('poin-of-sales.activation');
        Route::get('/pos/thermal-printer/{order_id}', 'invoice')->name('admin.invoice.thermal_printer');
        Route::post('/pos/add-customer', 'addCustomer')->name('admin.pos.add_customer');
    });

    //seller pos
    Route::controller(AdminSellerPosController::class)->group(function () {
        Route::prefix('seller_pos')->group(function () {
            Route::get('/', 'index')->name('seller_pos.index');
            Route::get('/products', 'search')->name('seller_pos.search_product');
            Route::post('/add-to-cart-pos', 'addToCart')->name('seller_pos.addToCart');
            Route::post('/update-quantity-cart-pos', 'updateQuantity')->name('seller_pos.updateQuantity');
            Route::post('/remove-from-cart-pos', 'removeFromCart')->name('seller_pos.removeFromCart');
            Route::post('/update-session-user-cart-data', 'updateSessionUserCartData')->name('seller_pos.updateSessionUserCartData');
            Route::post('/get_shipping_address', 'getShippingAddress')->name('seller_pos.getShippingAddress');
            Route::post('/setDiscount', 'setDiscount')->name('seller_pos.setDiscount');
            Route::post('/setShipping', 'setShipping')->name('seller_pos.setShipping');
            Route::post('/setShippingByCustomer', 'setShippingByCustomer')->name('seller_pos.setShippingByCustomer');
            Route::post('/set-shipping-address', 'set_shipping_address')->name('seller_pos.set-shipping-address');
            Route::post('/order-summary', 'get_order_summary')->name('seller_pos.getOrderSummary');
            Route::post('/order', 'order_store')->name('seller_pos.order_place');
            Route::get('/activation', 'configuration')->name('poin-of-sales.activation');
            Route::get('/thermal-printer/{order_id}', 'invoice')->name('admin.invoice.thermal_printer');
            Route::post('/add-customer', 'addCustomer')->name('admin.seller_pos.add_customer');
            Route::post('/updateProductPrice', 'updateProductPrice')->name('seller_pos.updateProductPrice');
        });
    });
});

//Seller
Route::group(['prefix' => 'seller', 'middleware' => ['seller', 'verified', 'check.order.limit']], function () {
    Route::controller(SellerPosController::class)->group(function () {
        Route::get('/pos', 'index')->name('poin-of-sales.seller_index');
        Route::get('/pos/products', 'search')->name('pos.search_seller_product');
        Route::post('/add-to-cart-pos', 'addToCart')->name('seller.pos.addToCart');
        Route::post('/update-quantity-cart-pos', 'updateQuantity')->name('seller.pos.updateQuantity');
        Route::post('/remove-from-cart-pos', 'removeFromCart')->name('seller.pos.removeFromCart');
        Route::post('/update-session-user-cart-data', 'updateSessionUserCartData')->name('seller.pos.updateSessionUserCartData');
        Route::post('/get_shipping_address', 'getShippingAddress')->name('seller.pos.getShippingAddress');
        Route::post('/setDiscount', 'setDiscount')->name('seller.pos.setDiscount');
        Route::post('/setShipping', 'setShipping')->name('seller.pos.setShipping');
        Route::post('/set-shipping-address', 'set_shipping_address')->name('seller.pos.set-shipping-address');
        Route::post('/pos-order-summary', 'get_order_summary')->name('seller.pos.getOrderSummary');
        Route::post('/pos-order', 'order_store')->name('seller.pos.order_place');
        Route::get('/pos-configuration', 'configuration')->name('pos.configuration');
        Route::post('/pos-configuration/update', 'posConfigurationUpdate')->name('pos_configuration.update');
        Route::get('/pos/thermal-printer/{order_id}', 'invoice')->name('seller.invoice.thermal_printer');
        Route::post('/pos/add-customer', 'addCustomer')->name('seller.pos.add_customer');
    });
});
