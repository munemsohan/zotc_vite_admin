<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class LandingPageProduct extends Model
{
    protected $fillable = ['landing_page_id', 'product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
