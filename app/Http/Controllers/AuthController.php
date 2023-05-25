<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Validator;
class AuthController extends Controller
{
    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        
        $user = User::where('email', $request->email)->first();
        if ($user) {

            if($user->is_active == 1)
            {
            if (Hash::check($request->password, $user->password)) {
                if($user->role_id == 3 && $user->is_verify == 0)
                {
                    $response = ['status'=>true,"message" => "Your Account is not verified!"];
                    return response($response, 422);
                }

                if(($user->role_id == 2 || $user->role_id == 3) && $user->is_phone == null)
                {
                    $response = ['status'=>true,"message" => "Phone Number is not verified"];
                    return response($response, 422);
                }
                else
                {
                    $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                    $user->is_online = 1;
                    $user->save();
                    $response = ['status'=>true,"message" => "Login Successfully",'token' => $token,'user'=>$user];
                    return response($response, 200);
                }

            } else {
                $response = ['status'=>false,"message" => "Password mismatch"];
                return response($response, 422);
            }

        }
        else
        {
            $response = ['status'=>false,"message" =>'Your Account has been Blocked by Admin!'];
            return response($response, 422);
        }
        } else {
            $response = ['status'=>false,"message" =>'User does not exist'];
            return response($response, 422);
        }
    }

    public function logout (Request $request) {

        // $offline = User::where('id',$id)->first();
        // $offline->is_online = 0;
        // $offline->save();

        $token = $request->user()->token();
        $token->revoke();
        $response = ['status'=>true,'message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }

    public function forgetpassword(Request $req)
    {
        $req->validate([
            'email' => 'required|email'
        ]);
        $query = User::where('email',$req->email)->first();
        // dd($query);
        if($query == null)
        {
            return response(['status' => false, 'message' => 'Email does not exist']);
        }        
        else{
            $token = uniqid();
            $query->remember_token = $token;
            $query->save();
            Mail::send(
                'email.password-reset',
                [
                    'token'=>$token,
                    'name'=>$query->name,
                    //'last_name'=>$query->last_name
                ], 
            
            function ($message) use ($query) {
                $message->from(env('MAIL_USERNAME'));
                $message->to($query->email);
                $message->subject('Forget Password');
            });
            return response(['status' => true, 'message' => 'Token send to your email']);

        }

    }

    public function token_check(Request $req)
    {
        $req->validate([
            'token' => 'required'
        ]);
        $query = User::where('remember_token',$req->token)->first();
        if($query == null)
        {
            return response(['status' => false, 'message' => 'Token not match']);
        }
        else{
            return response(['status' => true, 'message' => 'Token match','token'=>$req->token]);
        }

    }
    public function reset_password(Request $req)
    {
        $req->validate([
            'token'=>'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);
        $user = User::where('remember_token','=',$req->token)->first();  
        if($user == null)
        {
            return response(['status' => false, 'message' => 'Token not match']);
        }
        else
        {
            $user->password = Hash::make($req->password);
            $user->remember_token = null;
            $save = $user->save();
            if($save)
            {
                return response(['status' => true, 'message' => 'Success']);
            }
            else
            {
                return response(['status' => false, 'message' => 'Failed']);
            }
        }

    }

    public function profile_view($id)
    {
      $admin_profile = User::where('id',$id)->first();

      return response()->json(['admin_profile'=>$admin_profile],200);
    }

    public function profile_update(Request $request){
        $id=$request->id;
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => "required|email|max:255|unique:users,email,$id,id",
            'phone_number'=>'required|min:10|max:15'
            //'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        // $request['password']=Hash::make($request['password']);
        // $request['remember_token'] = Str::random(10);
        // $request['role_id']=1;
        $admin=User::find($id);
        $admin->name=$request->name;
        $admin->email=$request->email;
        $admin->phone_number=$request->phone_number;
        if($request->hasFile('image')){
            $file = $request->file('image');
            $fileType = "image-";
            $filename = $fileType.time()."-".rand().".".$file->getClientOriginalExtension();
            $file->storeAs("/public/profile/image", $filename);
            $admin->image = "public/profile/image/".$filename;
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
                //User::where( 'id' , auth::guard('user')->user()->id)->update( array( 'password' =>  $users->password));
                //$request->session()->put('alert', 'success');
                //$request->session()->put('change_passo', 'success');
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

}
