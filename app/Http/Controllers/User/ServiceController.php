<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $data = Service::with('advisor')->where('status',1)->get();

        return response()->json(['data'=>$data]);
    }
}
