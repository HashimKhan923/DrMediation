<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    use HasFactory;

    public function day()
    {
        return $this->belongsTo(Day::class,'day_id','id');
    }

    public function booking()
    {
        return $this->hasMany(Booking::class,'slot_id');
    }
}
