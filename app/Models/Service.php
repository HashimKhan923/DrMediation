<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public function advisor()
    {
        return $this->belongsTo(User::class,'advisor_id','id');
    } 

    use HasFactory;
}
