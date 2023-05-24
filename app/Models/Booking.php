<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public function advisor()
    {
        return $this->belongsTo(User::class,'advisor_id','id');
    } 
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    } 
    public function service()
    {
        return $this->belongsTo(Service::class,'service_id','id');
    } 
    public function slot()
    {
        return $this->belongsTo(Slot::class,'slot_id','id');
    } 
    use HasFactory;
}
