<?php

namespace App\Http\Controllers\Advisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index($id)
    {
        $Service = Service::where('advisor_id',$id)->get();

        return response()->json(['Service'=>$Service]);
    }

    public function createOrupdate(Request $request)
    {
        $check = Service::where('advisor_id',$request->advisor_id)->where('type',$request->type)->first();

        if($check)
        {
            $check->type = $request->type;
            $check->price = $request->price;
        }
        else
        {
            $check = new Service();
            $check->advisor_id = $request->advisor_id;
            $check->type = $request->type;
            $check->price = $request->price;
        }

        $check->save();

        $response = ['status'=>true,"message" => "Saved Successfully!"];
        return response($response, 200);
    }



    public function changeStatus($id)
    {
        $status = Service::where('id',$id)->first();

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
