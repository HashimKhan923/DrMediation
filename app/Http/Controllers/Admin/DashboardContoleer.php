<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Survey;
use App\Models\Audio;
use App\Models\Video;
use App\Models\Podcast;
use App\Models\Blog;

class DashboardContoleer extends Controller
{
    public function index()
    {
        $UserCount = User::where('role_id',2)->count();
        $AdvisorCount = User::where('role_id',3)->count();
        $SurveyCount = Survey::count();
        $CategoryCount = Category::where('id', '!=', 47)->count();

        $AudioCount = Audio::count();
        $VideoCount = Video::count();
        $PodcastCount = Podcast::count();
        $BlogCount = Blog::count();

        return response()->json(['UserCount'=>$UserCount,'AdvisorCount'=>$AdvisorCount,'SurveyCount'=>$SurveyCount,'CategoryCount'=>$CategoryCount,'AudioCount'=>$AudioCount,'VideoCount'=>$VideoCount,'PodcastCount'=>$PodcastCount,'BlogCount'=>$BlogCount,]);
    }

}
