<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FlashDealApiProductCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($data) {
            return [
                'id' => $data->product_id,
                'name' => $data->product->name,
                'image' => uploaded_asset($data->product->thumbnail_img),
                'original_price' => format_price($data->product->unit_price),
                'discount' => $data->product->discount,
                'discount_type' => $data->product->discount_type,
                'price' => home_discounted_base_price($data->product),
                'links' => route('products.show', $data->product_id),
            ];
        });
    }
}
