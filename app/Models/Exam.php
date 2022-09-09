<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Exam extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title','tags','number_of_questions','category_id','date'
    ];

    public function Category()
    {
        return $this->belongsTo(Category::class);
    }

    public function Attributes()
    {
        return $this->hasMany(ExamAttribute::class);
    }

    public function Questions()
    {
        return $this->hasMany(Question::class);
    }

    // Accessors
    public function levels(): Attribute
    {
        $Attributes = $this->Attributes;
        $level_name = [];

        foreach($Attributes as $attribute){
            if(!in_array($attribute->Level->name, $level_name))
            array_push($level_name,$attribute->Level->name);
        }

        return Attribute::make(
            get: fn ($value) => $Attributes->count() > 0 ? implode(', ',$level_name) : '-'
        );
    }

}
