<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

    public function options()
    {
        return $this->hasMany(Option::class,'question_id','id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }
    

    use HasFactory;
}
