<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Upload;
use App\Models\ZotcSetting;
use Response;
use Auth;
use Storage;
use Image;
use enshrined\svgSanitize\Sanitizer;
use Illuminate\Support\Facades\URL;
use Log;
use Str;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;

class AizUploadController extends Controller
{
    public function index(Request $request)
    {
        $all_uploads = (auth()->user()->user_type == 'seller') ? Upload::where('user_id', auth()->user()->id) : Upload::query();
        $search = null;
        $sort_by = null;

        if ($request->search != null) {
            $search = $request->search;
            $all_uploads->where('file_original_name', 'like', '%' . $request->search . '%');
        }

        $sort_by = $request->sort;
        switch ($request->sort) {
            case 'newest':
                $all_uploads->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $all_uploads->orderBy('created_at', 'asc');
                break;
            case 'smallest':
                $all_uploads->orderBy('file_size', 'asc');
                break;
            case 'largest':
                $all_uploads->orderBy('file_size', 'desc');
                break;
            default:
                $all_uploads->orderBy('created_at', 'desc');
                break;
        }

        $all_uploads = $all_uploads->paginate(60)->appends(request()->query());


        return (auth()->user()->user_type == 'seller')
            ? view('seller.uploads.index', compact('all_uploads', 'search', 'sort_by'))
            : view('backend.uploaded_files.index', compact('all_uploads', 'search', 'sort_by'));
    }

    public function create()
    {
        return (auth()->user()->user_type == 'seller')
            ? view('seller.uploads.create')
            : view('backend.uploaded_files.create');
    }


    public function show_uploader(Request $request)
    {
        return view('uploader.aiz-uploader');
    }

    public function upload(Request $request)
    {
        // Define file types and their categories
        $type = [
            "jpg" => "image",
            "jpeg" => "image",
            "png" => "image",
            "svg" => "image",
            "webp" => "image",
            "gif" => "image",
            "mp4" => "video",
            "mpg" => "video",
            "mpeg" => "video",
            "webm" => "video",
            "ogg" => "video",
            "avi" => "video",
            "mov" => "video",
            "flv" => "video",
            "swf" => "video",
            "mkv" => "video",
            "wmv" => "video",
            "wma" => "audio",
            "aac" => "audio",
            "wav" => "audio",
            "mp3" => "audio",
            "zip" => "archive",
            "rar" => "archive",
            "7z" => "archive",
            "doc" => "document",
            "txt" => "document",
            "docx" => "document",
            "pdf" => "document",
            "csv" => "document",
            "xml" => "document",
            "ods" => "document",
            "xlr" => "document",
            "xls" => "document",
            "xlsx" => "document",
        ];

        if ($request->hasFile('aiz_file')) {
            $file = $request->file('aiz_file');
            $extension = strtolower($file->getClientOriginalExtension());

            // Prevent archive uploads in demo mode
            if (env('DEMO_MODE') === 'On' && isset($type[$extension]) && $type[$extension] === 'archive') {
                return '{}';
            }

            if (isset($type[$extension])) {
                $fileOriginalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                
                // Generate the path using the original filename
                $slug = get_zotc_setting('img_slug') ?: 'all';
                $path = public_path("uploads/{$slug}");
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }

                $uploadedPath = "uploads/{$slug}/{$fileOriginalName}.{$extension}";

                // Get file size and MIME type
                $size = $file->getSize();
                $fileMime = $file->getMimeType();

                // Move the file to the uploads directory
                $file->move($path, "{$fileOriginalName}.{$extension}");

                if (env('FILESYSTEM_DRIVER') !== 'local') {
                    Storage::disk(env('FILESYSTEM_DRIVER'))->put(
                        $uploadedPath,
                        file_get_contents(public_path($uploadedPath)),
                        ['visibility' => 'public', 'ContentType' => $extension === 'svg' ? 'image/svg+xml' : $fileMime]
                    );

                    unlink(public_path($uploadedPath));
                }

                $upload = new Upload;
                $upload->file_original_name = $fileOriginalName;
                $upload->extension = $extension;
                $upload->file_name = $uploadedPath;
                $upload->user_id = Auth::user()->id;
                $upload->type = $type[$extension];
                $upload->file_size = $size;
                $upload->save();

                return '{}';
            }
        }

        return '{}';
    }


    public function thumbnailUpload($request)
    {
        $type = array(
            "jpg" => "image",
            "jpeg" => "image",
            "png" => "image",
            "svg" => "image",
            "webp" => "image",
            "gif" => "image",
            "mp4" => "video",
            "mpg" => "video",
            "mpeg" => "video",
            "webm" => "video",
            "ogg" => "video",
            "avi" => "video",
            "mov" => "video",
            "flv" => "video",
            "swf" => "video",
            "mkv" => "video",
            "wmv" => "video",
            "wma" => "audio",
            "aac" => "audio",
            "wav" => "audio",
            "mp3" => "audio",
            "zip" => "archive",
            "rar" => "archive",
            "7z" => "archive",
            "doc" => "document",
            "txt" => "document",
            "docx" => "document",
            "pdf" => "document",
            "csv" => "document",
            "xml" => "document",
            "ods" => "document",
            "xlr" => "document",
            "xls" => "document",
            "xlsx" => "document"
        );

        if ($request->hasFile('aiz_file')) {
            $upload = new Upload;
            $extension = strtolower($request->file('aiz_file')->getClientOriginalExtension());

            if (
                env('DEMO_MODE') == 'On' &&
                isset($type[$extension]) &&
                $type[$extension] == 'archive'
            ) {
                return '{}';
            }

            if (isset($type[$extension])) {
                $upload->file_original_name = null;
                $arr = explode('.', $request->file('aiz_file')->getClientOriginalName());
                for ($i = 0; $i < count($arr) - 1; $i++) {
                    if ($i == 0) {
                        $upload->file_original_name .= $arr[$i];
                    } else {
                        $upload->file_original_name .= "." . $arr[$i];
                    }
                }

                // Generate a random filename with 10 characters
                $random_filename = Str::random(10);

                // Get the current host's domain and extract slug
                $currentRequest = HttpFoundationRequest::createFromGlobals();
                $domain = $currentRequest->getHost();
                $slug = str_replace('.' . env('CENTRAL_DOMAIN'), '', $domain);

                // Construct the uploaded path with the random filename and extension
                $uploaded_path = 'uploads/' . $slug . '/' . $random_filename . '.webp';

                // Store the file in the local filesystem with the constructed path
                $request->file('aiz_file')->storeAs('uploads/' . $slug, $random_filename . '.webp', 'local');

                // Retrieve file size
                $size = $request->file('aiz_file')->getSize();

                // Retrieve MIME type of the file
                $file_mime = $request->file('aiz_file')->getMimeType();

                if ($type[$extension] == 'image' && get_setting('disable_image_optimization') != 1) {
                    try {
                        // Get the file path
                        $filePath = $request->file('aiz_file')->getRealPath();

                        // Create an image resource from the file
                        $image = imagecreatefromstring(file_get_contents($filePath));

                        // Check if image creation was successful
                        if (!$image) {
                            throw new \Exception('Failed to create image from file.');
                        }

                        // Create a new image instance
                        $webpImage = imagecreatetruecolor(500, 500);

                        // Check if image instance creation was successful
                        if (!$webpImage) {
                            throw new \Exception('Failed to create new image instance.');
                        }

                        // Copy and resize the original image to the new instance
                        if (!imagecopyresampled($webpImage, $image, 0, 0, 0, 0, 500, 500, imagesx($image), imagesy($image))) {
                            throw new \Exception('Failed to copy and resize image.');
                        }

                        // Save the WebP image to the specified path
                        $uploadedPath = 'uploads/' . $slug . '.webp';
                        if (!imagewebp($webpImage, public_path($uploadedPath))) {
                            throw new \Exception('Failed to save WebP image.');
                        }

                        // Check if the saved file is in WebP format
                        $savedFileType = mime_content_type(public_path($uploadedPath));
                        if ($savedFileType !== 'image/webp') {
                            throw new \Exception('Image was not saved in WebP format.');
                        }

                        // Retrieve the file size of the converted WebP image
                        $size = filesize(public_path($uploadedPath));

                        // Ensure proper permissions for the directory
                        $fullPath = public_path('uploads') . '/' . $slug;
                        if (!chmod($fullPath, 0755)) {
                            throw new \Exception('Failed to set permissions for directory.');
                        }
                    } catch (\Exception $e) {
                        // Handle exception
                        Log::error('Image optimization failed: ' . $e->getMessage());
                        // Return an error response or handle the failure in some way
                    }
                }

                if (env('FILESYSTEM_DRIVER') != 'local') {
                    // Store file in filesystem
                    Storage::disk(env('FILESYSTEM_DRIVER'))->put(
                        $uploaded_path,
                        file_get_contents(base_path('public/') . $uploaded_path),
                        [
                            'visibility' => 'public',
                            'ContentType' =>  $extension == 'svg' ? 'image/svg+xml' : $file_mime
                        ]
                    );

                    // Delete the locally stored file
                    if ($arr[0] != 'updates') {
                        unlink(base_path('public/') . $uploaded_path);
                    }
                }

                $upload->extension = $extension;
                $upload->file_name = $uploaded_path; // Assigning the generated random filename
                $upload->user_id = Auth::user()->id;
                $upload->type = $type[$extension];
                $upload->file_size = $size;
                $upload->save();
            }

            return '{}';
        }
    }

    public function get_uploaded_files(Request $request)
    {
        $uploads = Upload::where('user_id', Auth::user()->id);
        if ($request->search != null) {
            $uploads->where('file_original_name', 'like', '%' . $request->search . '%');
        }
        if ($request->sort != null) {
            switch ($request->sort) {
                case 'newest':
                    $uploads->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $uploads->orderBy('created_at', 'asc');
                    break;
                case 'smallest':
                    $uploads->orderBy('file_size', 'asc');
                    break;
                case 'largest':
                    $uploads->orderBy('file_size', 'desc');
                    break;
                default:
                    $uploads->orderBy('created_at', 'desc');
                    break;
            }
        }
        return $uploads->paginate(60)->appends(request()->query());
    }

    public function destroy($id)
    {
        $domain = get_domain();
        $domainArray = explode('.', $domain);
        $domainName = $domainArray[0];

        $upload = Upload::findOrFail($id);

        if (auth()->user()->user_type == 'seller' && $upload->user_id != auth()->user()->id) {
            flash(translate("You don't have permission for deleting this!"))->error();
            return back();
        }

        $fileName = $upload->file_name;
        $fileNameArray = explode('/', $fileName);

        try {
            if ($domainName == $fileNameArray[1]) {
                if (env('FILESYSTEM_DRIVER') != 'local') {
                    Storage::disk(env('FILESYSTEM_DRIVER'))->delete($upload->file_name);
                    if (file_exists(public_path() . '/' . $upload->file_name)) {
                        unlink(public_path() . '/' . $upload->file_name);
                    }
                } else {
                    unlink(public_path() . '/' . $upload->file_name);
                }
            }
            $upload->delete();
            flash(translate('File deleted successfully'))->success();
        } catch (\Exception $e) {
            $upload->delete();
            flash(translate('File deleted successfully'))->success();
        }

        return back();
    }

    public function bulk_uploaded_files_delete(Request $request)
    {
        if ($request->id) {
            foreach ($request->id as $file_id) {
                $this->destroy($file_id);
            }
            return 1;
        } else {
            return 0;
        }
    }

    public function get_preview_files(Request $request)
    {
        $ids = explode(',', $request->ids);
        $files = Upload::whereIn('id', $ids)->get();
        $new_file_array = [];
        foreach ($files as $file) {
            $file['file_name'] = my_asset($file->file_name);
            if ($file->external_link) {
                $file['file_name'] = $file->external_link;
            }
            $new_file_array[] = $file;
        }
        // dd($new_file_array);
        return $new_file_array;
        // return $files;
    }

    public function all_file()
    {
        $uploads = Upload::all();
        foreach ($uploads as $upload) {
            try {
                if (env('FILESYSTEM_DRIVER') != 'local') {
                    Storage::disk(env('FILESYSTEM_DRIVER'))->delete($upload->file_name);
                    if (file_exists(public_path() . '/' . $upload->file_name)) {
                        unlink(public_path() . '/' . $upload->file_name);
                    }
                } else {
                    unlink(public_path() . '/' . $upload->file_name);
                }
                $upload->delete();
                flash(translate('File deleted successfully'))->success();
            } catch (\Exception $e) {
                $upload->delete();
                flash(translate('File deleted successfully'))->success();
            }
        }

        Upload::query()->truncate();

        return back();
    }

    //Download project attachment
    public function attachment_download($id)
    {
        $project_attachment = Upload::find($id);
        try {
            $file_path = public_path($project_attachment->file_name);
            return Response::download($file_path);
        } catch (\Exception $e) {
            flash(translate('File does not exist!'))->error();
            return back();
        }
    }
    //Download project attachment
    public function file_info(Request $request)
    {
        $file = Upload::findOrFail($request['id']);

        return (auth()->user()->user_type == 'seller')
            ? view('seller.uploads.info', compact('file'))
            : view('backend.uploaded_files.info', compact('file'));
    }
}
