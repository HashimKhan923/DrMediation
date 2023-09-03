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


        Mail::send(
            'khan',
            [
                'token'=>'sasa',
                'name'=>'dasa',
                //'last_name'=>$query->last_name
            ], 
        
        function ($message){
            $message->from(env('MAIL_USERNAME'));
            $message->to('khanhash1994@gmail.com');
            $message->subject('Forget Password');
        });
        return response(['status' => true, 'message' => 'Token send to your email']);




        // $Category = Category::where('id',$id)->first();
        // $Audio = Audio::where('category_id',$id)->get();
        // $Video = Video::where('category_id',$id)->get();
        // $Podcast = Podcast::where('category_id',$id)->get();
        // $Blog = Blog::where('category_id',$id)->get();
        // SubscribeUser::where('end_time','<=',now())->delete();

        // return response()->json(['Audio'=>$Audio,'Video'=>$Video,'Podcast'=>$Podcast,'Blog'=>$Blog,'Category'=>$Category]);
    }
}
