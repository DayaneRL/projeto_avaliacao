<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reply extends Model
{

    protected $table = 'exam_replys';

    protected $fillable = [
        'question_id',
        'text',
        'alternative',
        'valid',
        'exam_id'
    ];

    public function Exam()
    {
        return $this->belongsTo(Exam::class);
    }

}
