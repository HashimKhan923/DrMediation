<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    public function videoSubCat()
    {
        return $this->hasMany(VideoSubCategories::class,'video_id','id');
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
