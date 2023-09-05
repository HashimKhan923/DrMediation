<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory;

    public function blogSubCat()
    {
        return $this->hasMany(AudioSubCategories::class,'audio_category_id','id');
    }
}
