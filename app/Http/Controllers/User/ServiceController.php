<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index($id)
    {
        $data = Service::with('advisor')->where('status',1)->where('advisor_id',$id)->get();

        return response()->json(['data'=>$data]);
    }
}
