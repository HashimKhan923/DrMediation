<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Survey;

class DashboardContoleer extends Controller
{
    public function index()
    {
        $UserCount = User::where('role_id',2)->count();
        $AdvisorCount = User::where('role_id',3)->count();
        $SurveyCount = Survey::count();
        $CategoryCount = Category::count();

        return response()->json(['UserCount'=>$UserCount,'AdvisorCount'=>$AdvisorCount,'SurveyCount'=>$SurveyCount,'CategoryCount'=>$CategoryCount]);
    }

}
