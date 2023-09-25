<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    public function book(Request $request)
    {
        $new = new Booking();
        $new->advisor_id = $request->advisor_id;
        $new->user_id = $request->user_id;
        $new->service = $request->service;
        $new->slot_id = $request->slot_id;
        $new->date = $request->date;
        $new->save();

        $response = ['status'=>true,"message" => "Booked Successfully!"];
        return response($response, 200);

    }
}
