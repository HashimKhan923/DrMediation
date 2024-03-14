<?php

namespace App\Http\Controllers\Advisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index($id)
    {
        $data = Booking::with('advisor','user','service','slot')->where('advisor_id',$id)->get();

        return response()->json(['data'=>$data]);
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

    public function send_link(Request $request)
    {

        $user = User::where('id',$request->user_id)->first();

        Mail::send(
            'email.call_link',
            [
                'name'=>$user->name,
                'link'=>$request->link
            ], 
        
        function ($message) use ($user) {
            $message->from(env('MAIL_USERNAME'));
            $message->to($user->email);
            $message->subject('Confirm Booking');
        });
    }
}
