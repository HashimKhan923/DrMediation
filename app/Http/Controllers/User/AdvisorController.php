<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdvisorController extends Controller
{
    public function all_advisors()
    {
       $all_advisor = User::where('role_id',3)->get();

       return response()->json(['all_advisor'=>$all_advisor]); 
    }
}
