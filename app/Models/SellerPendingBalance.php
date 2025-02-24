<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerPendingBalance extends Model
{
    protected $fillable = [
        'order_id',
        'amount'
    ];

    public function order()
    {
        return $this->belongsTo(related: Order::class);
    }
}
