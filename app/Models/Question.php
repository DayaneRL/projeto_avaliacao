<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    protected $fillable = [
        'description',
        'image'
    ];

    public function Exam()
    {
        return $this->belongsTo(Exam::class);
    }

}
