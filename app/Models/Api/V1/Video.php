<?php

namespace App\Models\Api\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action_id',
        'identification',
        'videoname',
        'discription',
        'subtitle',
        'original_index',
        'translate_index',
    ];

    
}
