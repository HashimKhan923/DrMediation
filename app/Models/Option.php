<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    public function OptionsSubCat()
    {
        return $this->hasMany(OptionCategories::class,'option_id','id');
    }
    use HasFactory;
}
