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

       return response()->json(['all_users'=>$all_users]); 
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

}
