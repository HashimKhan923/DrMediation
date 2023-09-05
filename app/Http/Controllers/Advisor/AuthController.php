<?php

namespace App\Http\Controllers\Advisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AdvisorData;
use Validator;
use Hash;
use Mail;

class AuthController extends Controller
{
    public function register (Request $request) {
        // dd($request);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            "email" => "required|email|unique:users,email",
            'password' => 'required|string|min:6',
            "phone" => 'required',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone;
        $user->password = Hash::make($request->password);
        $user->role_id = 3;
        // $user->is_active = 1;
        $user->save();

        $userData = new AdvisorData();
        $userData->user_id = $user->id;
        $userData->address = $request->address;


        if($request->file('education'))
        {
            foreach($request->education as $education)
            {
                $file= $education;
                $filename= date('YmdHi').$file->getClientOriginalName();
                $file->storeAs('public', $filename);
                $educationFiles[] = $filename;
                
            }

            $userData->education = $educationFiles;

        }

        if($request->file('certificates'))
        {
            foreach($request->certificates as $certificate)
            {
                $file= $certificate;
                $filename= date('YmdHis').$file->getClientOriginalName();
                $file->storeAs('public', $filename);
                $certificateFiles[] = $filename;
            }

            $userData->certificates = $certificateFiles;

        }

        if($request->file('degrees'))
        {
            foreach($request->degrees as $degree)
            {
                $file= $degree;
                $filename= date('YmdHis').$file->getClientOriginalName();
                $file->storeAs('public', $filename);
                $degreeFiles[] = $filename;
                
            }

            $userData->degrees = $degreeFiles;

        }

        $userData->biodata = $request->biodata;
        $userData->save();


        Mail::send(
            'email.advisor_documents',
            [
                'user'=>$user,
                'data'=>$userData,
                //'last_name'=>$query->last_name
            ], 
        
        function ($message) {
            $message->from(env('MAIL_USERNAME'));
            $message->to('support@drmeditation.net');
            $message->subject('New Advisor');
        });


        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $response = ['status'=>true,"message" => "Register Successfully",'token' => $token];
        return response($response, 200);
    }

    public function profile_view($id)
    {
      $admin_profile = User::where('id',$id)->first();

      return response()->json(['admin_profile'=>$admin_profile],200);
    }

    public function usercheck(Request $request)
    {
        $user=auth('api')->user();
        return response()->json(['admin_profile'=>$user],200);
    }

    public function profile_update(Request $request){
        $id=$request->id;
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => "required|email|max:255|unique:users,email,$id,id",
            // 'phone_number'=>'required|min:10|max:15',
            //'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $admin=User::find($id);
        $admin->name=$request->name;
        $admin->email=$request->email;
        // $admin->phone_number=$request->phone_number;
        if($request->file('image')){
            $file= $request->file('image');
            $filename= date('YmdHis').$file->getClientOriginalName();
            $file->storeAs('public', $filename);
            $admin->image = $filename;
        }
        //$admin->save();
        if($admin->save()){
          $response = ['status'=>true,"message" => "Profile Update Successfully","user"=>$admin];
          return response($response, 200);
        }
        $response = ['status'=>false,"message" => "Profile Not Update Successfully"];
         return response($response, 422);  
    }

    public function passwordChange(Request $request){
        $controlls = $request->all();
        $id=$request->id;
        $rules = array(
            "old_password" => "required",
            "new_password" => "required|required_with:confirm_password|same:confirm_password",
            "confirm_password" => "required"
        );

        $validator = Validator::make($controlls, $rules);
        if ($validator->fails()) {
            //return redirect()->back()->withErrors($validator)->withInput($controlls);
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $user = User::where('id',$request->id)->first();
        $hashedPassword = $user->password;
 
        if(Hash::check($request->old_password , $hashedPassword )) {
 
            if (!Hash::check($request->new_password , $hashedPassword)) {
                $users =User::find($request->id);
                $users->password = bcrypt($request->new_password);
                $users->save();
                $response = ['status'=>true,"message" => "Password Changed Successfully"];
                return response($response, 200);
            }else{
                $response = ['status'=>true,"message" => "new password can not be the old password!"];
                return response($response, 422);
            }
 
        }else{
            $response = ['status'=>true,"message" => "old password does not matched"];
            return response($response, 422);
        }

    }

    public function is_phone($id)
    {
        $update=User::where('phone_number',$id)->first();
        $update->is_phone = 1;
        $update->save();

        $response = ['status'=>true,"message" => "Phone number verifed Successfully!"];
        return response($response, 200);
    }

    public function is_active($id)
    {
        $is_active = User::where('id',$id)->first();

        if($is_active->is_active == 1)
        {
            $is_active->is_active = 0;

            $response = ['status'=>true,"message" => "Status Changed Successfully!"];
            return response($response, 200);
        }
        else
        {
            $is_active->is_active = 1;

            $response = ['status'=>true,"message" => "Status Changed Successfully!"];
            return response($response, 200);
        }
    }
}
