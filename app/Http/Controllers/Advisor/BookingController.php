<?php

namespace App\Http\Controllers\Advisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index($id)
    {
        $data = Booking::where('advisor_id',$id)->get();

        $response = ['status'=>true,"message" => "Status Changed Successfully!"];
        return response($response, 200);
    }

    public function changeStatus($id)
    {
        $status = Booking::where('id',$id)->first();

        if($status->status == 'pending')
        {
            $status->status = 'completed';
        }
        else
        {
            $status->status = 'pending';
        }
        $status->save();

        // $log = new Log();
        // $log->activity = Auth::guard('admin')->user()->first_name. ' change Banner status with name ' .$status->title. ' at ' .Carbon::now();
        // $log->save();

        $response = ['status'=>true,"message" => "Status Changed Successfully!"];
        return response($response, 200);

    }
}
