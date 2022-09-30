<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionsPrivate extends Model
{
    protected $fillable = [
        'description',
        'image',
        'user_id',
        'exam_question_id',
    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function ExamQuestion()
    {
        return $this->belongsTo(ExamQuestion::class);
    }

}
