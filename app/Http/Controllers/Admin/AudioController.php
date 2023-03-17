<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Audio;
use App\Models\Category;
use Illuminate\Support\Facades\File; 

class AudioController extends Controller
{
    public function index()
    {
       $Audios = Audio::all();

       return response()->json(['Audios'=>$Audios]);
    }

    public function create(Request $request)
    {
        $new = new Audio();
        $new->name = $request->name;
        $new->description = $request->description;
        $new->category_id = $request->category_id;
        if($request->file('thumbnail')){
            $file= $request->file('thumbnail');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('AudioThumbnail'), $filename);
            $new->thumbnail = $filename;
        }
        if($request->file('audio')){
            $file= $request->file('audio');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('Audio'), $filename);
            $new->audio = $filename;
        }
        $new->subscription = $request->subscription;
        $new->save();

        $response = ['status'=>true,"message" => "New Audio Added Successfully!"];
        return response($response, 200);
    }

    public function edit($id)
    {
        $edit = Audio::where('id',$id)->first();

        return response()->json(['edit'=>$edit]);
    }

    public function update(Request $request)
    {
        $update = Audio::where('id',$request->id)->first();
        $update->name = $request->name;
        $update->description = $request->description;
        $update->category_id = $request->category_id;
        if($request->file('thumbnail')){
            $file= $request->file('thumbnail');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('AudioThumbnail'), $filename);
            $update->thumbnail = $filename;
        }
        if($request->file('audio')){
            $file= $request->file('audio');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('Audio'), $filename);
            $update->audio = $filename;
        }
        $update->subscription = $request->subscription;
        $update->save();

        $response = ['status'=>true,"message" => "Audio Updated Successfully!"];
        return response($response, 200);
    }

    public function delete($id)
    {
      $file = Audio::find($id);
          $audio_path = public_path('Audio/'.$file->audio);
          $thumbnail_path = public_path('AudioThumbnail/'.$file->thumbnail);
        if (File::exists($image_path))
        {
            File::delete($image_path);
            File::delete($thumbnail_path);
        }

        $file->delete();
        $response = ['status'=>true,"message" => "Audio Deleted Successfully!"];
        return response($response, 200);



    }
}
