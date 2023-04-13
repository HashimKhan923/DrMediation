<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoSubCategories extends Model
{
    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class,'subcategory_id','id');
    } 
    use HasFactory;
}
