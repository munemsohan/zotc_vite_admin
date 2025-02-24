<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PosProductCollection extends ResourceCollection
{
    protected $seller_id;

    public function __construct($resource, $seller_id = null)
    {
        parent::__construct($resource);
        $this->seller_id = $seller_id;
    }

    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($data) {
                // Default price calculation
                $price = home_discounted_base_price_by_stock_id($data->stock_id);
                $base_price = home_base_price_by_stock_id($data->stock_id);

                return [
                    'id' => $data->id,
                    'stock_id' => $data->stock_id,
                    'name' => $data->name,
                    'thumbnail_image' => $data->stock_image ? uploaded_asset($data->stock_image) : uploaded_thumbnail($data->thumbnail_img),
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
