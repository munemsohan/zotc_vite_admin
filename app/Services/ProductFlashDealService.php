<?php

namespace App\Services;

use App\Models\FlashDeal;
use App\Models\FlashDealProduct;
use App\Models\Product;

class ProductFlashDealService
{
    public function store(array $data, Product $product)
    {
        $collection = collect($data);

        $flashDealId = $collection->get('flash_deal_id');

        if ($flashDealId) {
            $flashDealProduct = FlashDealProduct::firstOrNew([
                'flash_deal_id' => $flashDealId,
                'product_id' => $product->id
            ]);

            $flashDealProduct->save();

            $flashDeal = FlashDeal::firstWhere('id', $flashDealId);

            $product->discount = $collection['flash_discount'];
            $product->discount_type = $collection['flash_discount_type'];
            $product->discount_start_date = $flashDeal->start_date;
            $product->discount_end_date = $flashDeal->end_date;
            $product->save();
        } else {
            FlashDealProduct::where([
                'product_id' => $product->id
            ])->delete();
        }
    }
}
