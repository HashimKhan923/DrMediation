<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    public function sub_cat()
    {
        return $this->hasMany(SubCategory::class, 'category_id','id');
    }

    use HasFactory;
}
