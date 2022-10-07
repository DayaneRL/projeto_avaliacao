<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Tag extends Model
{
    use HasFactory;
    protected $fillable = [
        'description','category_id'
    ];

    public function Category()
    {
        return $this->belongsTo(Category::class);
    }


}
