<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\VCV;

class AdvisorController extends Controller
{
    public function index()
    {
       $all_advisor = User::where('role_id',3)->get();

       $VCV = VCV::first();

       return response()->json(['all_advisor'=>$all_advisor]); 
    }
}
