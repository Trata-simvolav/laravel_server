<?php

namespace App\Models\Api\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Words extends Model
{
    use HasFactory;

    protected $table = 'words';

    protected $fillable = [
        'original_word',
        'original_index',
        'translate_word',
        'translate_index',
        'think_orig_lang',
        'think_tran_lang',
    ];

    
}
