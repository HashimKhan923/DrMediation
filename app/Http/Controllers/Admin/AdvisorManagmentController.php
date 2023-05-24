<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdvisorManagmentController extends Controller
{
    public function all_advisors()
    {
       $all_advisor = User::where('role_id',3)->get();

       return response()->json(['all_advisor'=>$all_advisor]); 
    }

    public function changeStatus($id)
    {
        $status = User::where('id',$id)->first();

        if($status->is_active == 1)
        {
            $status->is_active = 0;
        }
        else
        {
            $status->is_active = 1;
        }
        $status->save();

        $response = ['status'=>true,"message" => "Status Changed Successfully!"];
        return response($response, 200);

    }

    public function changeVerificationStatus($id)
    {
        $status = User::where('id',$id)->first();

        if($status->is_verify == 1)
        {
            $status->is_verify = 0;
        }
        else
        {
            $status->is_verify = 1;
        }
        $status->save();

        $response = ['status'=>true,"message" => "Status Changed Successfully!"];
        return response($response, 200);

    }

    public function delete($id)
    {
        User::find($id)->delete();

        $response = ['status'=>true,"message" => "Deleted Successfully!"];
        return response($response, 200);

    }
}
