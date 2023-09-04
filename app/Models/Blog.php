<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{

    public function blogCat()
    {
        return $this->hasMany(BlogCategory::class,'blog_id','id');
    }

    public function blogSubCat()
    {
        return $this->hasMany(BlogSubCategories::class,'blog_id','id');
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
