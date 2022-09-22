<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    protected $table = 'exam_questions';

    protected $fillable = [
        'number',
        'text',
        'category_id'
    ];


}
