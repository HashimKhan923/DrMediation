<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Support\Facades\File; 

class BlogController extends Controller
{
    public function index()
    {
       $Blog = Blog::all();

       return response()->json(['Blog'=>$Blog]);
    }

    public function create(Request $request)
    {
        $new = new Blog();
        $new->content = $request->content;
        $new->category_id = $request->category_id;
        $new->author = $request->author;
        $new->subscription =$request->subscription;
        if($request->file('thumbnail')){
            $file= $request->file('thumbnail');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('BlogThumbnail'), $filename);
            $new->thumbnail = $filename;
        }
        $new->save();

        $response = ['status'=>true,"message" => "New Blog Added Successfully!"];
        return response($response, 200);
    }

    public function edit($id)
    {
        $edit = Blog::where('id',$id)->first();

        return response()->json(['edit'=>$edit]);
    }

    public function update(Request $request)
    {
        $update = Blog::where('id',$request->id)->first();
        $update->content = $request->content;
        $update->category_id = $request->category_id;
        $update->author = $request->author;
        $update->subscription =$request->subscription;
        if($request->file('thumbnail')){
            $file= $request->file('thumbnail');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('BlogThumbnail'), $filename);
            $update->thumbnail = $filename;
        }
        $update->save();

        $response = ['status'=>true,"message" => "Blog updated Successfully!"];
        return response($response, 200);
    }

    public function delete($id)
    {
      $file = Blog::find($id);
          $image_path = public_path('BlogThumbnail/'.$file->audio);
        if (File::exists($image_path))
        {

            File::delete($image_path);

        }

        $file->delete();
        $response = ['status'=>true,"message" => "Blog Deleted Successfully!"];
        return response($response, 200);



    }

}
