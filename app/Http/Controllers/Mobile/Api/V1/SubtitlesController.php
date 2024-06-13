<?php

namespace App\Http\Controllers\Mobile\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\Api\V1\Subtitle;
use App\Models\Api\V1\Language;
use App\Models\Api\V1\Words;

class SubtitlesController extends Controller
{
    public function index($ident){
        $subtitle = Subtitle::where('video_ident', $ident)->get();

        if(!$subtitle){
            return response()->json(['subtitle' => 'not have'], Response::HTTP_OK);
        }

        // $subtitle 

        return response()->json(['subtitle' => $subtitle], Response::HTTP_OK);
    }

    public function store(){}

    public function show(){}

    public function update(){}

    public function destroy(){}
}