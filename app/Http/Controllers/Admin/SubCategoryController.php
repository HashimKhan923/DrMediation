<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class SubCategoryController extends Controller
{
    public function index()
    {
       $SubCategory = SubCategory::all();

       return response()->json(['SubCategory'=>$SubCategory]);
    }

    public function create(Request $request)
    {
        $new = new SubCategory();
        $new->name = $request->name;
        $new->category_id = $request->category_id;
        if($request->file('thumbnail')){
            $file= $request->thumbnail;
            $filename= date('YmdHis').$file->getClientOriginalName();
            $file->move(public_path('SubCategoryThumbnail'),$filename);
            $new->thumbnail = $filename;
        }
        $new->save();

        $response = ['status'=>true,"message" => "New SubCategory Added Successfully!"];
        return response($response, 200);
    }

    public function edit($id)
    {
        $edit = SubCategory::where('id',$id)->first();

        return response()->json(['edit'=>$edit]);
    }

    public function update(Request $request)
    {
        $update = SubCategory::where('id',$request->id)->first();
        $update->name = $request->name;
        $update->category_id = $request->category_id;
        if($request->file('thumbnail')){
            if(public_path('SubCategoryThumbnail/'.$update->thumbnail))
            {
                unlink(public_path('SubCategoryThumbnail/'.$update->thumbnail));
            }
            $file= $request->thumbnail;
            $filename= date('YmdHis').$file->getClientOriginalName();
            $file->move(public_path('SubCategoryThumbnail'),$filename);
            $update->thumbnail = $filename;
        }
        $update->save();

        $response = ['status'=>true,"message" => "SubCategory Updated Successfully!"];
        return response($response, 200);
    }

    public function delete($id)
    {
        $file = SubCategory::find($id);
        if(public_path('SubCategoryThumbnail/'.$file->thumbnail))
        {
            unlink(public_path('SubCategoryThumbnail/'.$file->thumbnail));
        }

      $file->delete();

        $response = ['status'=>true,"message" => "SubCategory Deleted Successfully!"];
        return response($response, 200);
    }
}
