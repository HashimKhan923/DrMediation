<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AudioCategory extends Model
{
    use HasFactory;

    public function audioSubCat()
    {
        return $this->hasMany(AudioSubCategories::class,'audio_category_id','id');
    }
}
