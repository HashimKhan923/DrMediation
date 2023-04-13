<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Podcast extends Model
{
    
    public function podcastSubCat()
    {
        return $this->hasMany(PodcastSubCategories::class,'podcast_id','id');
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    } 
    
    use HasFactory;
}
