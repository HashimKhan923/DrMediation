<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
class SubscriptionPlanController extends Controller
{
    public function index()
    {
        $SubscriptionPlan = SubscriptionPlan::with('advisor','user','service','slot')->where('status',1)->get();

        return response()->json(['SubscriptionPlan'=>$SubscriptionPlan]);  
    }

    public function create(Request $request)
    {


        $new = new SubscriptionPlan();
        $new->name = $request->name;
        $new->price = $request->price;
        $new->time_number = $request->time_number;
        $new->time_name = $request->time_name;
        $new->save();

        // $log = new Log();
        // $log->activity = Auth::guard('admin')->user()->first_name. ' create Subscription with name ' .$new->name. ' at ' .Carbon::now();
        // $log->save();

        $response = ['status'=>true,"message" => "New Subscription Added Successfully!"];
        return response($response, 200);

        }

    public function delete($id)
    {
      $delete = SubscriptionPlan::find($id);
    //   $log = new Log();
    //   $log->activity = Auth::guard('admin')->user()->first_name. ' delete Subscription with name ' .$delete->name. ' at ' .Carbon::now();
    //   $log->save();
      $delete->delete();
      $response = ['status'=>true,"message" => "Subscription Deleted Successfully!"];
      return response($response, 200);
    }

    public function edit($id)
    {



        $SubscriptionPlan = SubscriptionPlan::where('id',$id)->first();

        return response()->json(['SubscriptionPlan'=>$SubscriptionPlan]);      }

    public function update(Request $request)
    {


        // $request->validate([
        //     'title'=>'required',
        //     'link'=>'required',
        //     'image'=>'required',

        // ]);


        $update = SubscriptionPlan::where('id',$request->id)->first();
        $update->name = $request->name;
        $update->price = $request->price;
        $update->time_number = $request->time_number;
        $update->time_name = $request->time_name;
        $update->save();

        // $log = new Log();
        // $log->activity = Auth::guard('admin')->user()->first_name. ' update Subscription with name ' .$update->name. ' at ' .Carbon::now();
        // $log->save();


        $response = ['status'=>true,"message" => "Subscription Updated Successfully!"];
        return response($response, 200);    }


    public function changeStatus($id)
    {
        $status = SubscriptionPlan::where('id',$id)->first();

        if($status->status == 1)
        {
            $status->status = 0;
        }
        else
        {
            $status->status = 1;
        }
        $status->save();

        $response = ['status'=>true,"message" => "Subscription Status Changed Successfully!"];
        return response($response, 200);

    }
}
