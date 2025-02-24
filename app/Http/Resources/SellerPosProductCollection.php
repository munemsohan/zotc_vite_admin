<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SellerPosProductCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($data) {
                // If seller_id exists and dropshop_price is available, use dropshop price
                if ($data->dropshop_price) {
                    $dropshopPriceArray = explode(',', $data->dropshop_price);

                    // Extract the first price segment (e.g., "1-5-90")
                    $firstPriceSegment = $dropshopPriceArray[0] ?? '';

                    // Extract the last value (the price) after splitting by '-'
                    $priceParts = explode('-', $firstPriceSegment);
                    $dropshopPrice = end($priceParts);

                    // Ensure $dropshopPrice is a valid numeric value
                    if (is_numeric($dropshopPrice)) {
                        $price = $dropshopPrice;
                    }

                    $price = format_price(convert_price($price));
                    $base_price = $price;
                } else {
                    // Default price calculation
                    $price = home_discounted_base_price_by_stock_id($data->stock_id);
                    $base_price = home_base_price_by_stock_id($data->stock_id);
                }

                return [
                    'id' => $data->id,
                    'stock_id' => $data->stock_id,
                    'name' => $data->name,
                    'thumbnail_image' => $data->stock_image
                        ? uploaded_asset($data->stock_image)
                        : uploaded_thumbnail($data->thumbnail_img),
                    'price' => $price,
                    'base_price' => $base_price,
                    'qty' => $data->stock_qty,
                    'variant' => $data->variant,
                    'digital' => $data->digital,
                ];
            }),
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
            'status' => 200,
        ];
    }
}
