<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index()
    {
      $data = Booking::with('advisor','user','slot.day')->get();

        return response()->json(['data'=>$data]);
    }
}
