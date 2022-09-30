<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamQuestion extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'exam_id',
        'number',
        'question_id',
        'private',
        'user_id'
    ];

    public function Exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function Question()
    {
        return $this->belongsTo(Question::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
