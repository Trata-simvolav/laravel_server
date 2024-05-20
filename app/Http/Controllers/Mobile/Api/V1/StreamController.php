<?php

namespace App\Http\Controllers\Mobile\Api\V1;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Http\Controllers\Controller;

use App\Models\Api\V1\Video;


class StreamController extends Controller
{
    public function startStream(Request $request)
    {
        $filename = $request->input('filename');
        $videoPath = storage_path('app/public/videos/' . $filename);

        // $vlcPath = 'E:\VLC\vlc.exe'; // Укажите путь к исполняемому файлу VLC на вашей системе
        // $rtspId = rand(1000000, 999999999);
        // $rtspUrl = 'rtsp://til-project.com/stream' . $rtspId; // Замените на фактический URL RTSP потока
        // $outputDir = storage_path('app/public/stream'); // Каталог для хранения HLS сегментов и плейлиста

        if (!file_exists($videoPath)) {
            return response()->json(['message' => 'File not found'], 404);
        }

        $process = new Process(['bash', storage_path('app/public/scripts/start_vlc_stream.sh'), $videoPath]);
        $process->start();

        return response()->json(['message' => 'Stream started']);
    }
}
