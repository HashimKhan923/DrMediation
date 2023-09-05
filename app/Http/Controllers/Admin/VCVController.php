<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VCV;

class VCVController extends Controller
{
    public function index()
    {
       $data = VCV::first();

       return response()->json(['data'=>$data]);

    }

    public function createOrupdate(Request $request)
    {
        $createOrupdate = VCV::first();

        if($createOrupdate == null)
        {
            $createOrupdate = new VCV();
        }


            $createOrupdate->voice = $request->voice_price;
            $createOrupdate->chat = $request->chat_price;
            $createOrupdate->video = $request->video_price;
            $createOrupdate->save();

            $response = ['status'=>true,"message" => 'Save Successfully!'];
            return response($response, 200);
    
    }
}
