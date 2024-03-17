<?php

namespace App\Http\Controllers\Advisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookingNote;

class BookingNoteController extends Controller
{
    public function createOrupdate(Request $request)
    {
        $BookingNote = BookingNote::where('booking_id',$request->booking_id)->first();

        if(!$BookingNote)
        {
            $BookingNote = new BookingNote();
            $BookingNote->booking_id = $request->booking_id;
        }

            $BookingNote->note = $request->note;
            $BookingNote->save();

            return response()->json(['message'=>'saved successfully',200]);

    }
}
