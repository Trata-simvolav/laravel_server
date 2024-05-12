<?php

namespace App\Models\Api\V1;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{

    protected $fillable = [
        'id',
        'path',
    ];

}
