<?php

namespace App\Http\Controllers\Advisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slot;

class SlotController extends Controller
{
    public function index($id)
    {
         $Slot=Slot::where('user_id',$id)->get();

         return response()->json(['Slot'=>$Slot]);
    }

    public function create(Request $request)
    {
        $new = new Slot();
        $new->user_id = $request->user_id;
        $new->date = $request->date;
        $new->time = $request->time;
        $new->save();

        $response = ['status'=>true,"message" => "New Slot Added Successfully!"];
        return response($response, 200);
    }

    public function delete($id)
    {
        Slot::find($id)->delete();

        $response = ['status'=>true,"message" => "Slot Deleted Successfully!"];
        return response($response, 200);
    }


}
