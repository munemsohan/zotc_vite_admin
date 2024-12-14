<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Resources\V2\FlashDealApiCollection;
use App\Http\Resources\V2\FlashDealCollection;
use App\Http\Resources\V2\HomeCategoryCollection;
use App\Models\Category;
use App\Models\FlashDeal;
use App\Models\HomeCategory;
use App\Models\LandingPage;
use App\Models\Slider;
use App\Models\Upload;

class HomeController extends Controller
{
    public function headerMenus()
    {
        return new HomeCategoryCollection(HomeCategory::all());
    }

    public function navbar()
    {
        // $helpline = get_setting('helpline_number');
        $header_logo = uploaded_asset(get_setting('header_logo'));

        $website_name = get_setting('website_name');
        $category_names = Category::select('name')->get()->pluck('name'); // Get an array of category names

        // Decode JSON settings
        $header_menu_labels = json_decode(get_setting('header_menu_labels'), true);
        $header_menu_links = json_decode(get_setting('header_menu_links'), true);

        // Create an array to hold the menu items as objects
        $header_menu = [];
        if (is_array($header_menu_labels) && is_array($header_menu_links)) {
            foreach ($header_menu_labels as $index => $label) {
                // Ensure both arrays have the same number of items to avoid undefined index errors
                if (isset($header_menu_links[$index])) {
                    $header_menu[] = [
                        'label' => $label,
                        'link' => $header_menu_links[$index],
                    ];
                }
            }
        }

        // Create an array to hold the data
        $data = [
            // 'helpline' => $helpline,
            'header_logo' => $header_logo,
            'website_name' => $website_name,
            'category_names' => $category_names,
            'header_menu' => $header_menu, // Array of objects for menu items
        ];

        // Return the data as JSON
        return response()->json($data);
    }

    public function homepage()
    {
        // Fetch the main sliders with slug, name, and their nested child categories
        $categories = Category::without('category_translations')
            ->select('id', 'slug', 'name') // Fetch main category fields
            ->where('parent_id', 0) // Only main categories (parent categories)
            ->orderBy('order_level')
            ->with('childCategories') // Recursively fetch child categories
            ->get();

        $sliders = get_only_slider_images();

        $scrolling_text = base64_decode(get_setting('scrolling_text'));

        $flash_deals = FlashDeal::without('flash_deal_translations')
            ->select('id', 'end_date')
            ->with('flash_deal_products')
            ->where('status', 1)
            ->where('start_date', '<=', strtotime(date('d-m-Y')))
            ->where('end_date', '>=', strtotime(date('d-m-Y')))
            ->get();

        $flash_deals = new FlashDealApiCollection($flash_deals);

        $homeBanner1Images = get_setting('home_banner1_images');
        $banner1Images = json_decode($homeBanner1Images, true);

        $homeBanner1Links = get_setting('home_banner1_links');
        $banner1Links = json_decode($homeBanner1Links, true);

        $banners = [];

        foreach ($banner1Images as $key => $value) {
            // Ensure there is a corresponding link for each image
            $banners[] = [
                'url' => isset($banner1Links[$key]) ? $banner1Links[$key] : '',
                'image' => uploaded_asset($value)
            ];
        }

        $data = [
            'categories' => $categories,
            'sliders' => $sliders,
            'scrolling_text' => $scrolling_text,
            'flash_deals' => $flash_deals,
            'banners' => $banners
        ];

        // Return the data as JSON
        return response()->json($data);
    }

    public function landing($slug){
        $landing = LandingPage::with('landingPageProducts', 'landingPageAspects')->where('slug', $slug)->first();

        $data = [
            'landing' => $landing
        ];

        // Return the data as JSON
        return response()->json($data);
    }
}
