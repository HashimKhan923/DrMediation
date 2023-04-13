<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;

class BannerController extends Controller
{
    public function index()
    {
        $Banner = Banner::where('status',1)->get();

        return response()->json(['Banner'=>$Banner]);    }


    public function create(Request $request)
    {


        $new = new Banner();
        $new->name = $request->title; 
        $new->link = $request->link;
        if($request->file('image')){
            $file= $request->file('image');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('Banners'), $filename);
            $new->image = $filename;
        }
        $new->save();

        // $log = new Log();
        // $log->activity = Auth::guard('admin')->user()->first_name. ' create Banner with name ' .$new->title. ' at ' .Carbon::now();
        // $log->save();

        $response = ['status'=>true,"message" => "New Banner Added Successfully!"];
        return response($response, 200);    }

    public function delete($id)
    {
        $file = Banner::find($id);
        $image_path = public_path('Banners/'.$file->audio);
      if (File::exists($image_path))
      {

          File::delete($image_path);

      }

      $file->delete();
      $response = ['status'=>true,"message" => "Banner Deleted Successfully!"];
      return response($response, 200);

    }

    public function edit($id)
    {
        $Banner = Banner::where('id',$id)->first();

        return response()->json(['Banner'=>$Banner]);
    }

    public function update(Request $request)
    {


        $update = Banner::where('id',$request->id)->first();




        $update->name = $request->title;
        $update->link = $request->link;
        if($request->file('image')){
            $file= $request->file('image');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('Banners'), $filename);
            $update->image = $filename;
        }
        $update->save();

        // $log = new Log();
        // $log->activity = Auth::guard('admin')->user()->first_name. ' update Banner with name ' .$update->title. ' at ' .Carbon::now();
        // $log->save();

        $response = ['status'=>true,"message" => "Banner Updated Successfully!"];
        return response($response, 200);
    }

    public function changeStatus($id)
    {
        $status = Banner::where('id',$id)->first();

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
        // $log->activity = Auth::guard('admin')->user()->first_name. ' change Banner status with name ' .$status->title. ' at ' .Carbon::now();
        // $log->save();

        $response = ['status'=>true,"message" => "Status Changed Successfully!"];
        return response($response, 200);

    }
}
