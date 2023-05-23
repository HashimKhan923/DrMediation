<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function book(Request $request)
    {
        $new = new Booking();
        $new->advisor_id = $request->advisor_id;
        $new->user_id = $request->user_id;
        $new->service_id = $request->service_id;
        $new->slot_id = $request->slot_id;
        $new->save();

        $response = ['status'=>true,"message" => "Booked Successfully!"];
        return response($response, 200);

    }
}
