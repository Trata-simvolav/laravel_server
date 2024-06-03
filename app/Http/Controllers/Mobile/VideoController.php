<?php

namespace App\Http\Controllers\Mobile\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use App\Models\Api\V1\Video;
use App\Models\Api\V1\Action;

class VideoController extends Controller
{
    public function show($user_id)
    {
        $videos = Video::where('user_id', $user_id)->get();
    
        if ($videos->isEmpty()) {
            return response()->json(['error' => 'No videos found for the given user_id'], 404);
        }
    
        $result = [];
        foreach ($videos as $video) {
            $action = $video->action;
            $json_data = $action ? $action->data : null;
            $video->json_data = $json_data;
            $result[] = $video;
        }
    
        return response()->json($result);
    }
}
