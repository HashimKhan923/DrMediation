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
        foreach($request->day_id as $day)
        {
            $new = new Slot();
            $new->user_id = $request->user_id;
            $new->day_id = $day;
            $new->time = $request->time;
            $new->save();
        }


    }

    public function delete($id)
    {
        Slot::find($id)->delete();

        $response = ['status'=>true,"message" => "Slot Deleted Successfully!"];
        return response($response, 200);
    }

    public function changeStatus($id)
    {
        $status = Slot::where('id',$id)->first();

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
