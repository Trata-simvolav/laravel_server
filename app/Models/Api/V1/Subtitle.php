<?php

namespace App\Models\Api\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subtitle extends Model
{
    use HasFactory;

    protected $table = 'subtitles';

    protected $fillable = [
        'video_ident',
        'words',
        'original_index',
        'translate_index'
    ];

    
}
