<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Audio;
use App\Models\Video;
use App\Models\Podcast;
use App\Models\Blog;
use App\Models\Category;
use App\Models\SubscribeUser;

use Mail;

class HomeController extends Controller
{
    public function index($id)
    {
        $Category = Category::where('id',$id)->first();
        

        $Audio = Audio::with('audioCat','audioSubCat.sub_category')->whereHas('audioCat', function ($query) use ($id){
            $query->where('category_id',$id);
           })->where('status',1)->get();

        $Video = Video::with('videoCat','videoSubCat.sub_category')->whereHas('videoCat', function ($query) use ($id){
            $query->where('category_id',$id);
           })->where('status',1)->get();


        $Podcast = Podcast::with('podcastCat','podcastSubCat.sub_category')->whereHas('podcastCat', function ($query) use ($id){
            $query->where('category_id',$id);
           })->where('status',1)->get();


        $Blog = Blog::with('blogCat','blogSubCat.sub_category')->whereHas('blogCat', function ($query) use ($id){
            $query->where('category_id',$id);
           })->where('status',1)->get();

        SubscribeUser::where('end_time','<=',now())->delete();

        return response()->json(['Audio'=>$Audio,'Video'=>$Video,'Podcast'=>$Podcast,'Blog'=>$Blog,'Category'=>$Category]);
    }
}
