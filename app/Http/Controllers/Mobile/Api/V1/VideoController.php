<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class VideoController extends Controller
{
    public function streamVideo($filename)
    {
        $path = storage_path('app/public/' . $filename);

        if (!Storage::exists($path)) {
            abort(404);
        }
        return '13213213213213';

        // $file = Storage::get($path);
        // $type = Storage::mimeType($path);

        // $response = new Response($file, 200);
        // $response->header('Content-Type', $type);

        // return $response;
    }
}


// <video width="640" height="360" controls>
//   <source src="{{ route('stream.video', ['filename' => 'your_video_file.mp4']) }}" type="video/mp4">
//   Your browser does not support the video tag.
// </video>
