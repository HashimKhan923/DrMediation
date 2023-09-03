<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audio extends Model
{

    public function audioCat()
    {
        return $this->hasMany(AudioCategories::class,'audio_id','id');
    }

    public function audioSubCat()
    {
        return $this->hasMany(AudioSubCategories::class,'audio_id','id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    } 

    
        public function subcategory()
    {
        return $this->belongsTo(SubCategory::class,'subcategory_id','id');
    }
    
    use HasFactory;
}
