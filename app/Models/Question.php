<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

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

    public function Answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function descriptionRead(): Attribute
    {
        $string = $this->description;
        $string = str_replace(array("\\r\\n", "\\r", "\\n"), "\n", $string);
        return Attribute::make(
            get: fn ($value) => $string
        );
    }

    public function Category()
    {
        return $this->belongsTo(Category::class);
    }

    public function QuestionTag()
    {
        return $this->hasMany(QuestionTag::class);
    }
}
