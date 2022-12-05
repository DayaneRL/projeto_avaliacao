<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class QuestionTag extends Model
{
    use HasFactory;
    protected $table = 'question_tags';
    protected $fillable = [
        'question_id','tag_id'
    ];

    public function Tag()
    {
        return $this->belongsTo(Tag::class);
    }

    public function Question()
    {
        return $this->belongsTo(Question::class);
    }



}
