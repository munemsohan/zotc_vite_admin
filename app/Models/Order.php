<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'delivery_status',
        'combined_order_id',
        'user_id',
        'guest_id',
        'seller_id',
        'drop_shipper',
        'city',
        'zone',
        'area',
        'assign_delivery_boy',
        'shipping_address',
        'additional_info',
        'shipping_type',
        'order_from',
        'pickup_point_id',
        'carrier_id',
        'payment_type',
        'manual_payment',
        'manual_payment_data',
        'payment_status',
        'payment_details',
        'grand_total',
        'partial_payments',
        'coupon_discount',
        'code',
        'tracking_code',
        'date',
        'viewed',
        'delivery_viewed',
        'cancel_request',
        'cancel_request_at',
        'payment_status_viewed',
        'commission_calculated',
        'delivery_history_date',
        'notified',
        'editing',
        'edited',
        'fraud_status',
        'track_url',
        'status_history'
    ];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function refund_requests()
    {
        return $this->hasMany(RefundRequest::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shop()
    {
        return $this->hasOne(Shop::class, 'user_id', 'seller_id');
    }

    public function pickup_point()
    {
        return $this->belongsTo(PickupPoint::class);
    }

    public function carrier()
    {
        return $this->belongsTo(Carrier::class);
    }

    public function affiliate_log()
    {
        return $this->hasMany(AffiliateLog::class);
    }

    public function club_point()
    {
        return $this->hasMany(ClubPoint::class);
    }

    public function delivery_boy()
    {
        return $this->belongsTo(User::class, 'assign_delivery_boy', 'id');
    }

    public function proxy_cart_reference_id()
    {
        return $this->hasMany(ProxyPayment::class)->select('reference_id');
    }

    public function commissionHistory()
    {
        return $this->hasOne(CommissionHistory::class);
    }

    public function partialPayments()
    {
        return $this->hasMany(OrderPartialPayment::class);
    }

    public function editingUser()
    {
        return $this->belongsTo(User::class, 'editing');
    }

    public function editedUser()
    {
        return $this->belongsTo(User::class, 'edited');
    }
}
