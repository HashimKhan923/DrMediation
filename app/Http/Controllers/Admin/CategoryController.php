<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    public function index()
    {
       $Categories = Category::with('sub_cat.category')->where('id','!=',47)->get();

       return response()->json(['Categories'=>$Categories]);
    }

    public function create(Request $request)
    {
        $new = new Category();
        $new->name = $request->name;
        $new->description = $request->description;
        if($request->file('thumbnail')){
            $file= $request->thumbnail;
            $filename= date('YmdHis').$file->getClientOriginalName();
            $file->move(public_path('CategoryThumbnail'),$filename);
            $new->thumbnail = $filename;
        }
        if($request->file('banner')){
            $file= $request->banner;
            $filename= date('YmdHis').$file->getClientOriginalName();
            $file->move(public_path('CategoryBanner'),$filename);
            $new->banner = $filename;
        }
        $new->save();

        $response = ['status'=>true,"message" => "New Category Added Successfully!"];
        return response($response, 200);
    }

    public function edit($id)
    {
        $edit = Category::where('id',$id)->first();

        return response()->json(['edit'=>$edit]);
    }

    public function update(Request $request)
    {
        $update = Category::where('id',$request->id)->first();
        $update->name = $request->name;
        $update->description = $request->description;
        if($request->file('thumbnail')){

            // if(public_path('CategoryThumbnail/'.$update->thumbnail))
            // {
            //     unlink(public_path('CategoryThumbnail/'.$update->thumbnail));
            // }

            $file= $request->thumbnail;
            $filename= date('YmdHis').$file->getClientOriginalName();
            $file->move(public_path('CategoryThumbnail'),$filename);
            $update->thumbnail = $filename;
        }

        if($request->file('banner')){

            // if(public_path('Categorybanner/'.$update->banner))
            // {
            //     unlink(public_path('Categorybanner/'.$update->banner));
            // }

            $file= $request->banner;
            $filename= date('YmdHis').$file->getClientOriginalName();
            $file->move(public_path('CategoryBanner'),$filename);
            $update->banner = $filename;
        }
        $update->save();

        $response = ['status'=>true,"message" => "Category Updated Successfully!"];
        return response($response, 200);
    }

    public function delete($id)
    {
        $file = Category::find($id);
        if(public_path('CategoryThumbnail/'.$file->thumbnail))
        {
            unlink(public_path('CategoryThumbnail/'.$file->thumbnail));
        }
        if(public_path('CategoryBanner/'.$file->banner))
        {
            unlink(public_path('CategoryBanner/'.$file->banner));
        }

      $file->delete();

        $response = ['status'=>true,"message" => "Category Deleted Successfully!"];
        return response($response, 200);
    }


}
