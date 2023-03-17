<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Podcast;
use App\Models\Category;
use Illuminate\Support\Facades\File; 

class PodcastController extends Controller
{
    public function index()
    {
       $Podcast = Podcast::all();

       return response()->json(['Podcast'=>$Podcast]);
    }

    public function create(Request $request)
    {
        $new = new Podcast();
        $new->name = $request->name;
        $new->description = $request->description;
        $new->category_id = $request->category_id;
        if($request->file('thumbnail')){
            $file= $request->file('thumbnail');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('PodcastThumbnail'), $filename);
            $new->thumbnail = $filename;
        }
        if($request->file('podcast')){
            $file= $request->file('podcast');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('Podcast'), $filename);
            $new->podcast = $filename;
        }
        $new->subscription = $request->subscription;
        $new->save();

        $response = ['status'=>true,"message" => "New Podcast Added Successfully!"];
        return response($response, 200);
    }

    public function edit($id)
    {
        $edit = Podcast::where('id',$id)->first();

        return response()->json(['edit'=>$edit]);
    }

    public function update(Request $request)
    {
        $update = Podcast::where('id',$request->id)->first();
        $update->name = $request->name;
        $update->description = $request->description;
        $update->category_id = $request->category_id;
        if($request->file('thumbnail')){
            $file= $request->file('thumbnail');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('PodcastThumbnail'), $filename);
            $update->thumbnail = $filename;
        }
        if($request->file('podcast')){
            $file= $request->file('podcast');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('Podcast'), $filename);
            $update->podcast = $filename;
        }
        $update->subscription = $request->subscription;
        $update->save();

        $response = ['status'=>true,"message" => "Podcast Updated Successfully!"];
        return response($response, 200);
    }

    public function delete($id)
    {
      $file = Podcast::find($id);
          $podcast_path = public_path('Podcast/'.$file->podcast);
          $thumbnail_path = public_path('PodcastThumbnail/'.$file->thumbnail);
        if (File::exists($podcast_path))
        {
            File::delete($podcast_path);
            File::delete($thumbnail_path);
        }

        $file->delete();
        $response = ['status'=>true,"message" => "Podcast Deleted Successfully!"];
        return response($response, 200);



    }
}
