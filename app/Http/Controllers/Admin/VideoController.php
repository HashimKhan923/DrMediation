<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\Category;
use Illuminate\Support\Facades\File; 

class VideoController extends Controller
{
    public function index()
    {
       $Videos = Video::all();

       return response()->json(['Videos'=>$Videos]);
    }

    public function create(Request $request)
    {
        $new = new Video();
        $new->name = $request->name;
        $new->description = $request->description;
        $new->category_id = $request->category_id;
        if($request->file('thumbnail')){
            $file= $request->file('thumbnail');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('VideoThumbnail'), $filename);
            $new->thumbnail = $filename;
        }
        if($request->file('video')){
            $file= $request->file('video');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('Video'), $filename);
            $new->video = $filename;
        }
        $new->subscription = $request->subscription;
        $new->save();

        $response = ['status'=>true,"message" => "New Video Added Successfully!"];
        return response($response, 200);
    }

    public function edit($id)
    {
        $edit = Video::where('id',$id)->first();

        return response()->json(['edit'=>$edit]);
    }

    public function update(Request $request)
    {
        $update = Video::where('id',$request->id)->first();
        $update->name = $request->name;
        $update->description = $request->description;
        $update->category_id = $request->category_id;
        if($request->file('thumbnail')){
            $file= $request->file('thumbnail');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('VideoThumbnail'), $filename);
            $update->thumbnail = $filename;
        }
        if($request->file('video')){
            $file= $request->file('video');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('Video'), $filename);
            $update->video = $filename;
        }
        $update->subscription = $request->subscription;
        $update->save();

        $response = ['status'=>true,"message" => "Video Updated Successfully!"];
        return response($response, 200);
    }

    public function delete($id)
    {
      $file = Video::find($id);
          $video_path = public_path('Video/'.$file->video);
          $thumbnail_path = public_path('VideoThumbnail/'.$file->thumbnail);
        if (File::exists($video_path))
        {

            File::delete($video_path);
            File::delete($thumbnail_path);

        }

        $file->delete();
        $response = ['status'=>true,"message" => "Video Deleted Successfully!"];
        return response($response, 200);



    }
}
