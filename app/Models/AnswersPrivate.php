<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnswersPrivate extends Model
{
    protected $table = 'answers_private';
    protected $fillable = [
        'answer_id',
        'exam_question_id',
        'user_id',
        'description',
        'alternative',
        'valid'
    ];

    public function Answer()
    {
        return $this->belongsTo(Answer::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function ExamQuestion()
    {
        return $this->belongsTo(ExamQuestion::class);
    }


}
