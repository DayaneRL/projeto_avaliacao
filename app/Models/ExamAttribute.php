<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamAttribute extends Model
{
    protected $table = 'exam_attributes';
    protected $fillable = [
        'number_questions',
        'level_id',
        'exam_id'
    ];

    public function Level()
    {
        return $this->belongsTo(Level::class);
    }

    public function Exam()
    {
        return $this->belongsTo(Exam::class);
    }

}
