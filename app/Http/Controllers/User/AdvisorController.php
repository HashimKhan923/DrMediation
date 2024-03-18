<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\VCV;
use App\Models\Booking;

class AdvisorController extends Controller
{
    public function index()
    {  $BookedSlots = Booking::all();
       $all_advisor = User::with('slots')->where('role_id',3)->where('status',1)->get();

       $VCV = VCV::first();

       return response()->json(['all_advisor'=>$all_advisor,'VCV'=>$VCV,'BookedSlots'=>$BookedSlots]); 
    }
}
