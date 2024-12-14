<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\ProductCollection;
use App\Models\FlashDeal;
use App\Models\Product;

class FlashDealApiCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($data) {
            return [
                'id' => $data->id,
                // 'title' => $data->title, // Uncomment if needed later
                'date' => (int) $data->end_date, // Ensuring date is cast to an integer
                // 'banner' => uploaded_asset($data->banner), // Uncomment if needed later
                'products' => new FlashDealApiProductCollection($data->flash_deal_products()->take(10)->get()), // Fetching limited products
            ];
        });
    }

    public function with($request)
    {
        return [
            'success' => true,
            'status' => 200
        ];
    }
}
