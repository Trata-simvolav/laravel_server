<?php

namespace App\Http\Controllers\Admin\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\Api\V1\Video;
use App\Models\Api\V1\User;
use App\Models\Api\V1\Action;

class VideoController extends Controller
{
    public function show($user_id)
    {
        $user = User::FindOrFail($user_id);    //Получение данных о пользователе
        if($user->isAdmin()){                  // проверка, админ ли пользователь
            $videos = Video::all(); // если да, то отправляем все видео
        } else {
            $videos = Video::where('user_id', $user_id)->get(); // если нет, то только видео пользователя
        }
    
        if ($videos->isEmpty()) {
            return response()->json(['error' => 'No videos found for the given user_id'], 404);
        } // проверка на пустоту
    
        $result = [];
        foreach ($videos as $video) {
            $action = $video->action;
            $json_data = $action ? $action->data : null;
            $video->json_data = $json_data;
            $result[] = $video;
        } // поле ответа

        return response()->json($result);
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'identification' => 'required|string',
            'videoname' => 'required|string',
            'discription' => 'required|string',
            'subtitle' => 'required|string'
        ]); // валидация данных

        $userId = auth()->id(); // получения id пользователя, который отправил видео
        
        $action_id = Action::create([
            'storage_type' => 'v',
            'data' => '[]'
        ]); // создание записи для активностей на видео

        $video_id = Video::create([
            'user_id' => $userId,
            'action_id' => $action_id->id, //
            'identification' => $request['identification'],
            'videoname' => $request['videoname'],
            'discription' => $request['discription'],
            'subtitle' => $request['subtitle'],
        ]); // создание записи о видео в БД

        return response()->json(['message' => 'Video created successfully'], 201); // поле ответа
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
