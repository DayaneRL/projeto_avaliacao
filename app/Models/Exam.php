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
        'title','tags','number_of_questions','category_id','date','user_id', 'user_header_id'
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
    public function tagsList(): Attribute
    {
        $tags = explode(',', $this->tags);
        $listTagNames = [];
        foreach($tags as $tag){
            if(Tag::find($tag)){
                array_push($listTagNames, Tag::find($tag)->description);
            }
        }
        return Attribute::make(
            get: fn ($value) => count($listTagNames)>0 ? implode(",", $listTagNames) : $listTagNames
        );
    }

    public function tagsListTable(): Attribute
    {
        $tags = explode(',', $this->tags);
        return Attribute::make(
            get: fn ($value) => count($tags)>2 ? Tag::find($tags[0])->description.', '.Tag::find($tags[1])->description.', ...' : ($tags[0]?Tag::find($tags[0])->description:'-')
        );
    }

    public function examDate(): Attribute
    {
        $date = new \DateTime($this->date);
        return Attribute::make(
            get: fn ($value) => $date->format('d/m/Y')
        );
    }

    public function createdAtFormatted(): Attribute
    {
        $date = new \DateTime($this->created_at);
        return Attribute::make(
            get: fn ($value) => $date->format('d/m/Y')
        );
    }

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
