<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoCategory extends Model
{
    use HasFactory;

    public function videoSubCat()
    {
        return $this->hasMany(VideoSubCategories::class,'video_category_id','id');
    }
}
