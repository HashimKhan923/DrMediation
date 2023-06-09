<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Audio;
use App\Models\AudioSubCategories;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class AudioController extends Controller
{
    public function index($id)
    {
       $Audios = Audio::with('category','audioSubCat.sub_category')->where('category_id',$id)->get();

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
            $filename= date('YmdHis').$file->getClientOriginalName();
            $file->storeAs('public', $filename);
            $new->thumbnail = $filename;
        }
        if($request->file('audio')){
            $file= $request->file('audio');
            $filename= date('YmdHis').$file->getClientOriginalName();
            $file->storeAs('public', $filename);
            $new->audio = $filename;
        }
        $new->subscription = $request->subscription;
        $new->save();

        foreach($request->sub_category_id as $item)
        {
            $new1 = new AudioSubCategories();
            $new1->audio_id = $new->id;
            $new1->subcategory_id = $item;  
            $new1->save();
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
            $file= $request->file('logo');
            $filename= date('YmdHis').$file->getClientOriginalName();
            $file->storeAs('public', $filename);
            $update->thumbnail = $filename;
        }
        if($request->file('audio')){
            $file= $request->file('logo');
            $filename= date('YmdHis').$file->getClientOriginalName();
            $file->storeAs('public', $filename);
            $update->audio = $filename;
        }
        $update->subscription = $request->subscription;
        $update->save();

        $gg = AudioSubCategories::where('audio_id',$update->id)->get();

        foreach($gg as $item)
        {
            AudioSubCategories::where('id',$item->id)->delete();
        }
        
        foreach($request->sub_category_id as $item)
        {
            $new1 = new AudioSubCategories();
            $new1->audio_id = $update->id;
            $new1->subcategory_id = $item;  
            $new1->save();
        }

        $response = ['status'=>true,"message" => "Audio Updated Successfully!"];
        return response($response, 200);
    }

    public function delete($id)
    {
      $file = Audio::find($id);
          

          $image_path = 'app/public'.$file->thumbnail;
          if(Storage::exists($image_path))
          {
              Storage::delete($image_path);
          }

          $audio_path = 'app/public'.$file->audio;
          if(Storage::exists($audio_path))
          {
              Storage::delete($audio_path);
          }

        $file->delete();
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
