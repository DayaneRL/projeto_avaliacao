<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{

    protected $fillable = [
        'number_question',
        'text_question',
        'category_id',
        'level_id'
    ];


}
