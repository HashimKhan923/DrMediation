<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\SubscribeUser;
use Carbon\Carbon;

class SubscriptionPlanController extends Controller
{
    public function index()
    {
        $Subscription=Subscription::where('status',1)->get();
        return response()->json(['Subscription'=>$Subscription]);
    }

    public function subscribe(Request $request)
    {

      $start_time = Carbon::now();  
      $Subscription = Subscription::where('id',$request->subscription_id)->first();
      


      if($Subscription->time_name == 'days')
      {
        $end_time = Carbon::now()->addDay($Subscription->time_number);
      }
      if($Subscription->time_name == 'months')
      {
        $end_time = Carbon::now()->addMonth($Subscription->time_number);
      }
      if($Subscription->time_name == 'years')
      {
        $end_time = Carbon::now()->addYear($Subscription->time_number);
      }

      $check = SubscribeUser::where('user_id',$request->user_id)->where('subscription_id',$request->subscription_id)->first();
      if(!$check)
      {
        $new = new SubscribeUser;
        $new->user_id = $request->user_id;
        $new->subscription_id = $request->subscription_id;
        $new->start_time = $start_time;
        $new->end_time = $end_time;
        $new->save();

        return response()->json(['message'=>'Your Subscription Completed Successfully!']);
      }
      else
      {
        return response()->json(['message'=>'You Have Already using this package']);
      }

  
    }

    public function subscribeUsers()
    {
      $SubscribeUser = SubscribeUser::with('user','plan')->get();
      return response()->json(['SubscribeUser'=>$SubscribeUser]);
    }
}
