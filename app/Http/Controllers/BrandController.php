<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\BrandTranslation;
use App\Models\Product;
use App\Models\Upload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function __construct()
    {
        // Staff Permission Check
        $this->middleware(['permission:view_all_brands'])->only('index');
        $this->middleware(['permission:add_brand'])->only('create');
        $this->middleware(['permission:edit_brand'])->only('edit');
        $this->middleware(['permission:delete_brand'])->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_search = null;
        $brands = Brand::orderBy('name', 'asc');
        if ($request->has('search')) {
            $sort_search = $request->search;
            $brands = $brands->where('name', 'like', '%' . $sort_search . '%');
        }
        $brands = $brands->paginate(15);
        return view('backend.product.brands.index', compact('brands', 'sort_search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $brand = new Brand;

        // Set brand details
        $brand->name = $request->name;
        $brand->meta_title = $request->meta_title;
        $brand->meta_description = $request->meta_description;

        // Handle slug
        $brand->slug = $request->slug
            ? str_replace(' ', '-', $request->slug)
            : preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)) . '-' . Str::random(5);

        // Process the logo image
        if ($request->logo) {
            $imageUpload = Upload::find($request->logo);

            if (!$imageUpload) {
                return response()->json(['message' => 'Logo image not found'], 404);
            }

            $originalImagePath = $imageUpload->file_name;

            // Process the logo image (200x200 dimensions)
            $processedLogoPath = processImage($originalImagePath, 120, 80);

            if ($processedLogoPath) {
                $imageUpload->file_name = $processedLogoPath;
                $imageUpload->thumbnail = $processedLogoPath;
                $imageUpload->save();

                $brand->logo =  $imageUpload->id;
            }

            // Delete original image file if it is not a WebP
            deleteImageIfNotWebp($originalImagePath);
        }

        // Save the brand
        $brand->save();

        // Insert brand translation
        $brand_translation = BrandTranslation::firstOrNew([
            'lang' => env('DEFAULT_LANGUAGE'),
            'brand_id' => $brand->id,
        ]);
        $brand_translation->name = $request->name;
        $brand_translation->save();

        // Flash success message and redirect
        flash(translate('Brand has been inserted successfully'))->success();
        return redirect()->route('brands.index');
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
        $lang   = $request->lang;
        $brand  = Brand::findOrFail($id);
        return view('backend.product.brands.edit', compact('brand', 'lang'));
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
        $brand = Brand::findOrFail($id);
        if ($request->lang == env("DEFAULT_LANGUAGE")) {
            $brand->name = $request->name;
        }
        $brand->meta_title = $request->meta_title;
        $brand->meta_description = $request->meta_description;
        if ($request->slug != null) {
            $brand->slug = strtolower($request->slug);
        } else {
            $brand->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)) . '-' . Str::random(5);
        }

        // Process the logo image
        if ($request->logo) {
            $imageUpload = Upload::find($request->logo);

            if (!$imageUpload) {
                return response()->json(['message' => 'Logo image not found'], 404);
            }

            $originalImagePath = $imageUpload->file_name;

            // Process the logo image (200x200 dimensions)
            $processedLogoPath = processImage($originalImagePath, 120, 80);

            if ($processedLogoPath) {
                $imageUpload->file_name = $processedLogoPath;
                $imageUpload->thumbnail = $processedLogoPath;
                $imageUpload->save();

                $brand->logo =  $imageUpload->id;
            }

            // Delete original image file if it is not a WebP
            deleteImageIfNotWebp($originalImagePath);
        }

        $brand->save();

        $brand_translation = BrandTranslation::firstOrNew(['lang' => $request->lang, 'brand_id' => $brand->id]);
        $brand_translation->name = $request->name;
        $brand_translation->save();

        flash(translate('Brand has been updated successfully'))->success();
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
        $brand = Brand::findOrFail($id);
        Product::where('brand_id', $brand->id)->update(['brand_id' => null]);
        foreach ($brand->brand_translations as $key => $brand_translation) {
            $brand_translation->delete();
        }
        Brand::destroy($id);

        flash(translate('Brand has been deleted successfully'))->success();
        return redirect()->route('brands.index');
    }

    private function processImage($randomFilename, $imagePath, $desiredWidth, $desiredHeight)
    {
        $slug = get_zotc_setting('img_slug') ?: 'all';

        if ($imagePath) {
            $imageContent = file_get_contents(public_path($imagePath));
            $imageContent = preg_replace('/\x{00}*\x{00}IHDR\x{00}*\x{00}(?=\x{00}*\xff)/', '', $imageContent);  // Attempt to strip out the ICC profile data from binary content

            $image = @imagecreatefromstring($imageContent);

            if ($image) {
                $originalWidth = imagesx($image);
                $originalHeight = imagesy($image);

                // Check if the image is already a WebP with the desired size
                $isWebp = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION)) === 'webp';

                if (!($isWebp && $originalWidth == $desiredWidth && $originalHeight == $desiredHeight)) {
                    $uploadedPath = "uploads/{$slug}/{$randomFilename}.webp";
                    resizeAndSaveWebpImage($image, $uploadedPath, $desiredWidth, $desiredHeight);

                    return $uploadedPath;
                }

                return $imagePath;
            }
        }

        return null;
    }
}
