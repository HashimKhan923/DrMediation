<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Podcast;
use App\Models\PodcastCategory;
use App\Models\PodcastSubCategories;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class PodcastController extends Controller
{
    public function index($id)
    {
        $Podcast = Podcast::with('podcastCat','podcastSubCat.sub_category')->whereHas('podcastCat', function ($query) use ($id){
            $query->where('category_id',$id);
           })->get();

       return response()->json(['Podcast'=>$Podcast]);
    }

    public function create(Request $request)
    {
        

        $new = new Podcast();
        $new->name = $request->name;
        $new->description = $request->description;
        if($request->file('thumbnail')){
            $file= $request->file('thumbnail');
            $filename= date('YmdHis').$file->getClientOriginalName();
            $file->storeAs('public', $filename);
            $new->thumbnail = $filename;
        }
        if($request->file('podcast')){
            $file= $request->file('podcast');
            $filename= date('YmdHis').$file->getClientOriginalName();
            $file->storeAs('public', $filename);
            $new->podcast = $filename;
        }
        $new->subscription = $request->subscription;
        $new->save();

        // Create categories and subcategories records
        foreach ($request->categories as $categoryData) {
            $category = new PodcastCategory();
            $category->podcast_id = $new->id;
            $category->category_id = $categoryData['category_id'];
            $category->save();
    
            foreach ($categoryData['subcategory_id'] as $subcategoryId) {
                $subcategory = new PodcastSubCategories();
                $subcategory->podcast_id = $new->id;
                $subcategory->podcast_category_id = $category->id;
                $subcategory->subcategory_id = $subcategoryId;
                
                $subcategory->save();
            }

        }

        // foreach($request->sub_category_id as $item)
        // {
        //     $new1 = new PodcastSubCategories();
        //     $new1->podcast_id = $new->id;
        //     $new1->subcategory_id = $item;  
        //     $new1->save();
        // }

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
            $filename= date('YmdHis').$file->getClientOriginalName();
            $file->storeAs('public', $filename);
            $update->thumbnail = $filename;
        }
        if($request->file('podcast')){
            $file= $request->file('podcast');
            $filename= date('YmdHis').$file->getClientOriginalName();
            $file->storeAs('public', $filename);
            $update->podcast = $filename;
        }
        $update->subscription = $request->subscription;
        $update->save();

        $gg = PodcastCategory::where('podcast_id',$update->id)->get();

        foreach($gg as $item)
        {
            PodcastCategory::where('id',$item->id)->delete();
        }
        
        // Create categories and subcategories records
        foreach ($request->categories as $categoryData) {
            $category = new PodcastCategory();
            $category->podcast_id = $update->id;
            $category->category_id = $categoryData['category_id'];
            $category->save();
    
            foreach ($categoryData['subcategory_id'] as $subcategoryId) {
                $subcategory = new PodcastSubCategories();
                $subcategory->podcast_id = $update->id;
                $subcategory->podcast_category_id = $category->id;
                $subcategory->subcategory_id = $subcategoryId;
                
                $subcategory->save();
            }

        }

        $response = ['status'=>true,"message" => "Podcast Updated Successfully!"];
        return response($response, 200);
    }

    public function delete($id)
    {
      $file = Podcast::find($id);
      
          $image_path = 'app/public'.$file->thumbnail;
          if(Storage::exists($image_path))
          {
              Storage::delete($image_path);
          }

          $podcast_path = 'app/public'.$file->podcast;
          if(Storage::exists($podcast_path))
          {
              Storage::delete($podcast_path);
          }

        $file->delete();
        $response = ['status'=>true,"message" => "Podcast Deleted Successfully!"];
        return response($response, 200);

    }

    public function soft_delete(Request $request)
    {
        PodcastCategory::where('podcast_id',$request->podcast_id)->where('category_id',$request->category_id)->delete();

        $response = ['status'=>true,"message" => "Podcast Deleted Successfully!"];
        return response($response, 200);
    }

    public function changeStatus($id)
    {
        $status = Podcast::where('id',$id)->first();

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
