<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{
    protected $fillable = [
        'question_id',
        'description',
        'alternative',
        'valid'
    ];

    public function Question()
    {
        return $this->belongsTo(Question::class);
    }


}
