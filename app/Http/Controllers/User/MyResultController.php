<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\Audio;
use App\Models\Video;
use App\Models\Podcast;
use App\Models\Blog;
use DB;

class MyResultController extends Controller
{
  public function index(Request $request)
  {
    $jj = Survey::where('user_id',$request->user_id)->get();
    $subcat_id = $jj->mode('subcategory_id');

    if($subcat_id == 105)
    {
      $response = ['status'=>true,"message" => "Please Contact with your advisor!"];
      return response($response, 200);
    }
    else
    {
      $SubCategory = SubCategory::where('id',$subcat_id)->first();  
    
      $Audio = Audio::with('audioSubCat')->whereHas('audioSubCat',function($query)use($subcat_id){
          $query->where('subcategory_id','=',$subcat_id);
      })->get();
  
      $Video = Video::with('videoSubCat')->whereHas('videoSubCat',function($query)use($subcat_id){
        $query->where('subcategory_id','=',$subcat_id);
    })->get();
  
    $Podcast = Podcast::with('podcastSubCat')->whereHas('podcastSubCat',function($query)use($subcat_id){
      $query->where('subcategory_id','=',$subcat_id);
    })->get();
  
  
    $Blog = Blog::with('blogSubCat')->whereHas('blogSubCat',function($query)use($subcat_id){
      $query->where('subcategory_id','=',$subcat_id);
    })->get();
        
        return response()->json(['Audio'=>$Audio,'Video'=>$Video,'Podcast'=>$Podcast,'Blog'=>$Blog,'SubCategory'=>$SubCategory]);



    }


  }
}
