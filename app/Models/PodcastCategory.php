<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PodcastCategory extends Model
{
    use HasFactory;

    public function podcastSubCat()
    {
        return $this->hasMany(PodcastSubCategories::class,'podcast_category_id','id');
    }
}
