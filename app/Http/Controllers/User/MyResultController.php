<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Survey;
use DB;

class MyResultController extends Controller
{
    public function index()
    {
      $MyResult = Survey::with('category')->where('user_id',1)
        ->select('category_id',DB::raw('count(*) *100 / (select count(*) from surveys) as percentage'))
        ->groupBy('category_id')
        ->get(); 
        
        return response()->json(['MyResult'=>$MyResult]);
    }
}
