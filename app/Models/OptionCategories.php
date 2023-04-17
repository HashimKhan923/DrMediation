<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionCategories extends Model
{
    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class,'subcategory_id','id');
    }

    use HasFactory;
}
