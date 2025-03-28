<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrequentlyBoughtProduct extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'product_id',
        'frequently_bought_product_id',
        'category_id',
        ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function frequently_bought_products()
    {
        return $this->belongsTo(Product::class, 'frequently_bought_product_id');
    }
}
