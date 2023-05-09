<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Podcast;
use App\Models\PodcastSubCategories;
use App\Models\Category;
use Illuminate\Support\Facades\File; 

class PodcastController extends Controller
{
    public function index($id)
    {
       $Podcast = Podcast::with('category','podcastSubCat.sub_category')->where('category_id',$id)->get();

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

        foreach($request->sub_category_id as $item)
        {
            $new1 = new PodcastSubCategories();
            $new1->podcast_id = $new->id;
            $new1->subcategory_id = $item;  
            $new1->save();
        }

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

        $gg = PodcastSubCategories::where('podcast_id',$update->id)->get();

        foreach($gg as $item)
        {
            PodcastSubCategories::where('id',$item->id)->delete();
        }
        
        foreach($request->sub_category_id as $item)
        {
            $new1 = new PodcastSubCategories();
            $new1->podcast_id = $update->id;
            $new1->subcategory_id = $item;  
            $new1->save();
        }

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
