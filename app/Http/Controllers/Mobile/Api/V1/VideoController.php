<?php

namespace App\Http\Controllers\Mobile\Api\V1;

use App\Models\Api\V1\Video;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class VideoController extends Controller
{
    public function getVideo($id)
    {
        // Находим видео по его идентификатору
        $video = Video::findOrFail($id);

        // Получаем путь к файлу видео
        $videoPath = Storage::disk('public')->path($video->path);

        // Проверяем, существует ли файл
        if (!Storage::disk('public')->exists($video->path)) {
            // Если файл не существует, возвращаем ошибку 404
            return response()->json(['error' => 'Video not found'], 404);
        }

        // Создаем объект BinaryFileResponse с указанием пути к файлу
        $response = new BinaryFileResponse($videoPath);

        // Устанавливаем заголовки
        $response->headers->set('Content-Type', 'video/mp4'); // чтоб смотреть
        // $response->headers->set('Content-Type', 'application/octet-stream'); // чтоб скачать видео
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE,
            basename($videoPath)
        );

        // Возвращаем ответ
        return $response;
    }
}
