<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\CategoryTranslation;
use App\Models\Upload;
use App\Utility\CategoryUtility;
use Illuminate\Support\Str;
use Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function __construct()
    {
        // Staff Permission Check
        $this->middleware(['permission:view_product_categories'])->only('index');
        $this->middleware(['permission:add_product_category'])->only('create');
        $this->middleware(['permission:edit_product_category'])->only('edit');
        $this->middleware(['permission:delete_product_category'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_search = null;
        $categories = Category::orderBy('order_level', 'desc');
        if ($request->has('search')) {
            $sort_search = $request->search;
            $categories = $categories->where('name', 'like', '%' . $sort_search . '%');
        }
        $categories = $categories->paginate(15);
        return view('backend.product.categories.index', compact('categories', 'sort_search'));
    }

    public function create()
    {
        $categories = Category::where('parent_id', 0)
            ->where('digital', 0)
            ->with('childrenCategories')
            ->get();

        return view('backend.product.categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $category = new Category;

        // Set category name and default order level
        $category->name = $request->name;
        $category->order_level = $request->order_level ?? 0;

        // Set the 'digital' field
        $category->digital = $request->digital;

        // Process the banner/cover image
        if ($request->banner) {
            $imageUpload = Upload::find($request->banner);

            if (!$imageUpload) {
                return response()->json(['message' => 'Banner image not found'], 404);
            }

            $originalImagePath = $imageUpload->file_name;
            $fileOriginalName = $imageUpload->file_original_name;

            // Process the image for both banner (200x200) and cover (360x360)
            $processedBannerPath = processImage($originalImagePath, 200, 200);

            // Save the processed images as new uploads
            if ($processedBannerPath) {
                $imageUpload->file_name = $processedBannerPath;
                $imageUpload->thumbnail = $processedBannerPath;
                $imageUpload->save();

                $category->banner = $imageUpload->id;
            }

            $processedCoverPath = processImage($originalImagePath, 360, 360);
            if ($processedCoverPath) {
                $coverUpload = $this->insert_upload($processedCoverPath, $fileOriginalName, 360, 360);
                $category->cover_image = $coverUpload->id;
            }

            // Set other fields
            $processedIconPath = processImage($originalImagePath, 32, 32);
            if ($processedIconPath) {
                $iconUpload = $this->insert_upload($processedIconPath, $fileOriginalName, 32, 32);
                $category->icon = $iconUpload->id;
            }

            // Delete original image file if it is not a WebP
            deleteImageIfNotWebp($originalImagePath);
        }

        $category->meta_title = $request->meta_title;
        $category->meta_description = $request->meta_description;

        // Set parent category and level
        if ($request->parent_id != "0") {
            $category->parent_id = $request->parent_id;

            $parent = Category::find($request->parent_id);
            if (!$parent) {
                return response()->json(['message' => 'Parent category not found'], 404);
            }

            $category->level = $parent->level + 1;
        } else {
            $category->parent_id = 0;
            $category->level = 0;
        }

        // Handle slug
        $category->slug = $request->slug
            ? preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug))
            : preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)) . '-' . Str::random(5);

        // Set commission rate if provided
        if ($request->commision_rate != null) {
            $category->commision_rate = $request->commision_rate;
        }

        // Save the category
        $category->save();

        // Sync filtering attributes
        if ($request->filtering_attributes) {
            $category->attributes()->sync($request->filtering_attributes);
        }

        // Insert category translation
        $category_translation = CategoryTranslation::firstOrNew([
            'lang' => env('DEFAULT_LANGUAGE'),
            'category_id' => $category->id,
        ]);
        $category_translation->name = $request->name;
        $category_translation->save();

        // Flash success message and redirect
        flash(translate('Category has been inserted successfully'))->success();
        return redirect()->route('categories.index');
    }

    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $lang = $request->lang;
        $category = Category::findOrFail($id);
        $categories = Category::where('parent_id', 0)
            ->where('digital', $category->digital)
            ->with('childrenCategories')
            ->whereNotIn('id', CategoryUtility::children_ids($category->id, true))->where('id', '!=', $category->id)
            ->orderBy('name', 'asc')
            ->get();

        return view('backend.product.categories.edit', compact('category', 'categories', 'lang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Retrieve the category or fail
        $category = Category::findOrFail($id);

        // Update category name for the default language
        if ($request->lang == env("DEFAULT_LANGUAGE")) {
            $category->name = $request->name;
        }

        // Update order level if provided
        if (!is_null($request->order_level)) {
            $category->order_level = $request->order_level;
        }

        // Update 'digital' field
        $category->digital = $request->digital;

        // Process the banner/cover image
        if ($request->banner) {
            $imageUpload = Upload::find($request->banner);

            if (!$imageUpload) {
                return response()->json(['message' => 'Banner image not found'], 404);
            }

            $originalImagePath = $imageUpload->file_name;
            $fileOriginalName = $imageUpload->file_original_name;

            // Process the image for both banner (200x200) and cover (360x360)
            $processedBannerPath = processImage($originalImagePath, 200, 200);

            // Save the processed images as new uploads
            if ($processedBannerPath) {
                $imageUpload->file_name = $processedBannerPath;
                $imageUpload->thumbnail = $processedBannerPath;
                $imageUpload->save();

                $category->banner = $imageUpload->id;
            }

            $processedCoverPath = processImage($originalImagePath, 360, 360);
            if ($processedCoverPath) {
                $coverUpload = $this->insert_upload($processedCoverPath, $fileOriginalName, 360, 360);
                $category->cover_image = $coverUpload->id;
            }

            // Set other fields
            $processedIconPath = processImage($originalImagePath, 32, 32);
            if ($processedIconPath) {
                $iconUpload = $this->insert_upload($processedIconPath, $fileOriginalName, 32, 32);
                $category->icon = $iconUpload->id;
            }

            // Delete original image file if it is not a WebP
            deleteImageIfNotWebp($originalImagePath);
        }

        // Update meta fields
        $category->meta_title = $request->meta_title;
        $category->meta_description = $request->meta_description;

        // Parent category and level logic
        $previous_level = $category->level;

        if ($request->parent_id != "0") {
            $parent = Category::find($request->parent_id);

            if (!$parent) {
                return response()->json(['message' => 'Parent category not found'], 404);
            }

            $category->parent_id = $request->parent_id;
            $category->level = $parent->level + 1;
        } else {
            $category->parent_id = 0;
            $category->level = 0;
        }

        // Adjust levels if the category level changes
        if ($category->level > $previous_level) {
            CategoryUtility::move_level_down($category->id);
        } elseif ($category->level < $previous_level) {
            CategoryUtility::move_level_up($category->id);
        }

        // Handle slug
        $category->slug = $request->slug
            ? strtolower($request->slug)
            : preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)) . '-' . Str::random(5);

        // Update commission rate
        if (!is_null($request->commision_rate)) {
            $category->commision_rate = $request->commision_rate;
        }

        // Save the category
        $category->save();

        // Sync filtering attributes if provided
        if ($request->filtering_attributes) {
            $category->attributes()->sync($request->filtering_attributes);
        }

        // Update category translation
        $category_translation = CategoryTranslation::firstOrNew([
            'lang' => $request->lang,
            'category_id' => $category->id,
        ]);
        $category_translation->name = $request->name;
        $category_translation->save();

        // Clear cache and flash success message
        Cache::forget('featured_categories');
        flash(translate('Category has been updated successfully'))->success();

        return back();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->attributes()->detach();

        // Category Translations Delete
        foreach ($category->category_translations as $key => $category_translation) {
            $category_translation->delete();
        }

        foreach (Product::where('category_id', $category->id)->get() as $product) {
            $product->category_id = null;
            $product->save();
        }

        CategoryUtility::delete_category($id);
        Cache::forget('featured_categories');

        flash(translate('Category has been deleted successfully'))->success();
        return redirect()->route('categories.index');
    }

    public function updateFeatured(Request $request)
    {
        $category = Category::findOrFail($request->id);
        $category->featured = $request->status;
        $category->save();
        Cache::forget('featured_categories');
        return 1;
    }

    public function categoriesByType(Request $request)
    {
        $categories = Category::where('parent_id', 0)
            ->where('digital', $request->digital)
            ->with('childrenCategories')
            ->get();

        return view('backend.product.categories.categories_option', compact('categories'));
    }

    private function insert_upload($full_path, $fileOriginalName, $witdth, $height)
    {
        $upload = new Upload;
        $upload->file_original_name = $fileOriginalName;
        $upload->extension = 'webp';
        $upload->file_name = $full_path;
        $upload->user_id = Auth::user()->id;
        $upload->type = 'image';
        $upload->file_size = $witdth * $height;
        $upload->save();

        return $upload;
    }
}
