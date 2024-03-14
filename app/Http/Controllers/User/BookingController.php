<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;
use App\Models\Slot;
use Mail;

class BookingController extends Controller
{

    public function index($id)
    {
        $data = Booking::where('user_id',$id)->get();


        return response()->json(['data'=>$data]);
    }

    public function book(Request $request)
    {
        $new = new Booking();
        $new->advisor_id = $request->advisor_id;
        $new->user_id = $request->user_id;
        $new->service_type = $request->service_type;
        $new->service_price = $request->service_price;
        $new->slot_id = $request->slot_id;
        $new->date = $request->date;
        $new->save();


        $user = User::where('id',$new->user_id)->first();
        $advisor = User::where('id',$new->advisor_id)->first();
        $slot = Slot::where('id',$new->slot_id)->first();      


        Mail::send(
            'email.confirm_booking',
            [
                'name'=>$user->name,
                'advisor'=>$advisor,
                'slot'=>$slot,
                'service'=>$new->service_type,
                'service_price'=>$new->service_price,
                'date'=>$new->date,
            ], 
        
        function ($message) use ($user) {
            $message->from(env('MAIL_USERNAME'));
            $message->to($user->email);
            $message->subject('Confirm Booking');
        });



        $response = ['status'=>true,"message" => "Booked Successfully! The confirmation email has been sent to your email."];
        return response($response, 200);

    }
}
