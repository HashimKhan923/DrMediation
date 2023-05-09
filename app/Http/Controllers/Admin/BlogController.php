<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogSubCategories;
use App\Models\Category;
use Illuminate\Support\Facades\File; 

class BlogController extends Controller
{
    public function index($id)
    {
       $Blog = Blog::with('category','blogSubCat.sub_category')->where('category_id',$id)->get();

       return response()->json(['Blog'=>$Blog]);
    }

    public function create(Request $request)
    {
        $new = new Blog();
        $new->title = $request->title;
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

        foreach($request->sub_category_id as $item)
        {
            $new1 = new BlogSubCategories();
            $new1->blog_id = $new->id;
            $new1->subcategory_id = $item;  
            $new1->save();
        }

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
        $update->title = $request->title;
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

        $gg = BlogSubCategories::where('blog_id',$update->id)->get();

        foreach($gg as $item)
        {
            BlogSubCategories::where('id',$item->id)->delete();
        }
        
        foreach($request->sub_category_id as $item)
        {
            $new1 = new BlogSubCategories();
            $new1->blog_id = $update->id;
            $new1->subcategory_id = $item;  
            $new1->save();
        }

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

    public function changeStatus($id)
    {
        $status = Blog::where('id',$id)->first();

        if($status->status == 1)
        {
            $status->status = 0;
        }
        else
        {
            $status->status = 1;
        }
        $status->save();

        // $log = new Log();
        // $log->activity = Auth::guard('admin')->user()->first_name. ' change Music status with name ' .$status->title. ' at ' .Carbon::now();
        // $log->save();

        $response = ['status'=>true,"message" => "Status Changed Successfully!"];
        return response($response, 200);

    }

}
