<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MeditationReport;

class MeditationReportController extends Controller
{
    public function index()
    {
        $data = MeditationReport::where('user_id',auth()->user()->id)->first();

        return response()->json(['data'=>$data]);
    }
}
