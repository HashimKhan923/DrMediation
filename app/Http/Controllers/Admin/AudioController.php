<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Audio;
use App\Models\AudioCategory;
use App\Models\AudioSubCategories;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class AudioController extends Controller
{
    public function index($id)
    {
       $Audios = Audio::with('audioCat.audioSubCat.sub_category')->whereHas('audioCat', function ($query) use ($id){
        $query->where('category_id',$id);
       })->get();

       return response()->json(['Audios'=>$Audios]);
    }

    public function create(Request $request)
    {
        

        $new = new Audio();
        $new->name = $request->name;
        $new->description = $request->description;

        if($request->file('thumbnail'))
        {
            $file= $request->thumbnail;
            $filename= date('YmdHis').$file->getClientOriginalName();
            $file->move(public_path('AudioThumbnail'),$filename);
            $new->thumbnail = $filename;
        }
        if($request->file('audio')){
            $file= $request->audio;
            $filename= date('YmdHis').$file->getClientOriginalName();
            $file->move(public_path('Audio'),$filename);
            $new->audio = $filename;
        }
        $new->subscription = $request->subscription;
        $new->save();
    
        // Create categories and subcategories records
        foreach ($request->categories as $categoryData) {
            $category = new AudioCategory();
            $category->audio_id = $new->id;
            $category->category_id = $categoryData['category_id'];
            $category->save();
    
            foreach ($categoryData['subcategory_id'] as $subcategoryId) {
                $subcategory = new AudioSubCategories();
                $subcategory->audio_id = $new->id;
                $subcategory->audio_category_id = $category->id;
                $subcategory->subcategory_id = $subcategoryId;
                
                $subcategory->save();
            }
    
            // // Attach the category to the product
            // $product->categories()->attach($category->id);
        }






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

            // if(public_path('AudioThumbnail/'.$update->thumbnail))
            // {
            //     unlink(public_path('AudioThumbnail/'.$update->thumbnail));
            // }
            $file= $request->thumbnail;
            $filename= date('YmdHis').$file->getClientOriginalName();
            $file->move(public_path('AudioThumbnail'),$filename);
            $update->thumbnail = $filename;

        }
        if($request->file('audio')){

            if(public_path('Audio/'.$update->audio))
            {
                unlink(public_path('Audio/'.$update->audio));
            }

            $file= $request->audio;
            $filename= date('YmdHis').$file->getClientOriginalName();
            $file->move(public_path('Audio'),$filename);
            $update->audio = $filename;
        }
        $update->subscription = $request->subscription;
        $update->save();

        $gg = AudioCategory::where('audio_id',$update->id)->get();

        foreach($gg as $item)
        {
            AudioCategory::where('id',$item->id)->delete();
        }
        if($request->categories != null)
        {
                    // Create categories and subcategories records
        foreach ($request->categories as $categoryData) {
            $category = new AudioCategory();
            $category->audio_id = $update->id;
            $category->category_id = $categoryData['category_id'];
            $category->save();
            if(isset($categoryData['subcategory_id']))
            {
                foreach ($categoryData['subcategory_id'] as $subcategoryId) {
                    $subcategory = new AudioSubCategories();
                    $subcategory->audio_id = $update->id;
                    $subcategory->audio_category_id = $category->id;
                    $subcategory->subcategory_id = $subcategoryId;
                    
                    $subcategory->save();
                }
            }

    
            // // Attach the category to the product
            // $product->categories()->attach($category->id);
        }
        }   


        $response = ['status'=>true,"message" => "Audio Updated Successfully!"];
        return response($response, 200);
    }

    public function delete($id)
    {
      $file = Audio::find($id);
          

      if(public_path('AudioThumbnail/'.$file->thumbnail))
      {
          unlink(public_path('AudioThumbnail/'.$file->thumbnail));
      }

      if(public_path('Audio/'.$file->audio))
      {
          unlink(public_path('Audio/'.$file->audio));
      }

        $file->delete();
        $response = ['status'=>true,"message" => "Audio Deleted Successfully!"];
        return response($response, 200);

    }

    public function soft_delete(Request $request)
    {
        AudioCategory::where('audio_id',$request->audio_id)->where('category_id',$request->category_id)->delete();

        $response = ['status'=>true,"message" => "Audio Deleted Successfully!"];
        return response($response, 200);
    }

    public function changeStatus($id)
    {
        $status = Audio::where('id',$id)->first();

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
