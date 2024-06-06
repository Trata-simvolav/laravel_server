<?php

namespace App\Http\Controllers\Admin\Api\V1;

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
    

    public function store(Request $request)
    {
        $request->validate([
            'identification' => 'required|string',
            'videoname' => 'required|string',
            'discription' => 'required|string',
            'subtitle' => 'required|string'
        ]);

        $userId = null; // auth()->id()
        
        $action_id = null;
        // Action::create([
        //     'storage_type' => 'v',
        //     'data' => []
        // ]);

        $video_id = Video::create([
            'user_id' => $userId,
            'action_id' => $action_id,
            'identification' => $request['identification'],
            'videoname' => $request['videoname'],
            'discription' => $request['discription'],
            'subtitle' => $request['subtitle'],
        ]);

        return response()->json(['message' => 'Video created successfully'], 201);
    }

    public function destroy($id)
    {
        $video = Video::find($id);

        if (!$video) {
            return response()->json(['error' => 'Video not found'], 404);
        }

        $video->delete();

        return response([
            "status" => 'success'
        ]);
    }
}
