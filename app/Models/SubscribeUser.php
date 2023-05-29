<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscribeUser extends Model
{
    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    public function plan()
    {
        return $this->hasOne(SubscriptionPlan::class,'id','subscription_id');
    }
    use HasFactory;
}
