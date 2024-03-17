<?php

namespace App\Http\Controllers\Advisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Slot;

class DashboardContoleer extends Controller
{
    public function index($advisor_id)
    {
        $UserCount = Booking::where('advisor_id', $advisor_id)->distinct('user_id')->count('user_id');
        $CompletedBookingCount = Booking::where('advisor_id', $advisor_id)->where('status','completed')->count();
        $PendingBookingCount = Booking::where('advisor_id', $advisor_id)->where('status','pending')->count();
        $SlotCount = Slot::where('user_id',$advisor_id)->count();

        return response()->json(['UserCount'=>$UserCount,'CompletedBookingCount'=>$CompletedBookingCount,'PendingBookingCount'=>$PendingBookingCount,'SlotCount'=>$SlotCount]);
    }
}
