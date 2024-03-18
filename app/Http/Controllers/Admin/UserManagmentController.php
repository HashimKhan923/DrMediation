<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserManagmentController extends Controller
{
    public function all_users()
    {
       $all_users = User::where('role_id',2)->get();
       $all_admins = User::where('role_id',1)->get();

       return response()->json(['all_users'=>$all_users,'all_admins'=>$all_admins]); 
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

    public function delete($id)
    {
        User::find($id)->delete();

        $response = ['status'=>true,"message" => "Deleted Successfully!"];
        return response($response, 200);

    }

    public function is_phone($id)
    {
        $update=User::where('phone_number',$id)->first();
        $update->is_phone = 1;
        $update->save();

        $response = ['status'=>true,"message" => "Phone number verifed Successfully!"];
        return response($response, 200);
    }

}
