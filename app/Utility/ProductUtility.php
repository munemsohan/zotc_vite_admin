<?php

namespace App\Utility;

use App\Models\Addon;
use App\Models\Color;

class ProductUtility
{
    public static function get_attribute_options($collection)
    {
        $options = array();
        // $colors_active = 0;

        if (
            isset($collection['colors_active']) &&
            $collection['colors_active'] &&
            isset($collection['colors']) &&
            is_array($collection['colors']) &&
            count($collection['colors']) > 0
        ) {
            // $colors_active = 1;
            $options[] = $collection['colors'];
        }

        if (isset($collection['choice_no']) && $collection['choice_no']) {
            foreach ($collection['choice_no'] as $key => $no) {
                $name = 'choice_options_' . $no;

                // Initialize $data as an empty array
                $data = array();

                // Check if the key exists in the request and is an array
                if (isset(request()[$name]) && is_array(request()[$name])) {
                    foreach (request()[$name] as $eachValue) {
                        $data[] = $eachValue; // Use shorthand to push elements to $data
                    }
                }

                // Add $data to $options
                $options[] = $data;
            }
        }

        return $options;
    }

    public static function get_combination_string($combination, $collection)
    {
        $str = '';
        foreach ($combination as $key => $item) {
            if ($key > 0) {
                $str .= '-' . str_replace(' ', '', $item);
            } else {
                if (isset($collection['colors_active']) && $collection['colors_active'] && $collection['colors'] && count($collection['colors']) > 0) {
                    $color_name = Color::where('code', $item)->first()->name;
                    $str .= $color_name;
                } else {
                    $str .= str_replace(' ', '', $item);
                }
            }
        }
        return $str;
    }
}
