<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{

    use HasFactory;
    protected $fillable = [
        'name',
    ];

    public function Question()
    {
        return $this->hasOne(Question::class);
    }

}
