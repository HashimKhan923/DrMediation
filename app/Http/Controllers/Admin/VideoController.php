<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\VideoCategory;
use App\Models\VideoSubCategories;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function index($id)
    {
        $Videos = Video::with('videoCat','videoSubCat.sub_category')->whereHas('videoCat', function ($query) use ($id){
            $query->where('category_id',$id);
           })->get();

       return response()->json(['Videos'=>$Videos]);
    }

    public function create(Request $request)
    {

        
        $new = new Video();
        $new->name = $request->name;
        $new->description = $request->description;
        if($request->file('thumbnail')){
            $file= $request->file('thumbnail');
            $filename= date('YmdHis').$file->getClientOriginalName();
            $file->storeAs('public', $filename);
            $new->thumbnail = $filename;
        }
        if($request->file('video')){
            $file= $request->file('video');
            $filename= date('YmdHis').$file->getClientOriginalName();
            $file->storeAs('public', $filename);
            $new->video = $filename;
        }
        $new->subscription = $request->subscription;
        $new->save();


                    // Create categories and subcategories records
        foreach ($request->categories as $categoryData) {
            $category = new VideoCategory();
            $category->video_id = $new->id;
            $category->category_id = $categoryData['category_id'];
            $category->save();
    
            foreach ($categoryData['subcategory_id'] as $subcategoryId) {
                $subcategory = new VideoSubCategories();
                $subcategory->video_id = $new->id;
                $subcategory->video_category_id = $category->id;
                $subcategory->subcategory_id = $subcategoryId;
                
                $subcategory->save();
            }

        }




        // foreach($request->sub_category_id as $item)
        // {
        //     $new1 = new VideoSubCategories();
        //     $new1->video_id = $new->id;
        //     $new1->subcategory_id = $item;  
        //     $new1->save();
        // }

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
            $filename= date('YmdHis').$file->getClientOriginalName();
            $file->storeAs('public', $filename);
            $update->thumbnail = $filename;
        }
        if($request->file('video')){
            $file= $request->file('video');
            $filename= date('YmdHis').$file->getClientOriginalName();
            $file->storeAs('public', $filename);
            $update->video = $filename;
        }
        $update->subscription = $request->subscription;
        $update->save();

        $gg = VideoCategory::where('video_id',$update->id)->get();

        foreach($gg as $item)
        {
            VideoCategory::where('id',$item->id)->delete();
        }
        
            // Create categories and subcategories records
            foreach ($request->categories as $categoryData) {
                $category = new VideoCategory();
                $category->video_id = $update->id;
                $category->category_id = $categoryData['category_id'];
                $category->save();
        
                foreach ($categoryData['subcategory_id'] as $subcategoryId) {
                    $subcategory = new VideoSubCategories();
                    $subcategory->video_id = $update->id;
                    $subcategory->video_category_id = $category->id;
                    $subcategory->subcategory_id = $subcategoryId;
                    
                    $subcategory->save();
                }
    
            }

        $response = ['status'=>true,"message" => "Video Updated Successfully!"];
        return response($response, 200);
    }

    public function delete($id)
    {
      $file = Video::find($id);
          
          $image_path = 'app/public'.$file->thumbnail;
          if(Storage::exists($image_path))
          {
              Storage::delete($image_path);
          }

          $video_path = 'app/public'.$file->video;
          if(Storage::exists($video_path))
          {
              Storage::delete($video_path);
          }

        $file->delete();
        $response = ['status'=>true,"message" => "Video Deleted Successfully!"];
        return response($response, 200);



    }

    public function soft_delete(Request $request)
    {
        VideoCategory::where('video_id',$request->video_id)->where('category_id',$request->category_id)->delete();

        $response = ['status'=>true,"message" => "Video Deleted Successfully!"];
        return response($response, 200);
    }

    public function changeStatus($id)
    {
        $status = Video::where('id',$id)->first();

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
