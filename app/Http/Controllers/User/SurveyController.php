<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Survey;

class SurveyController extends Controller
{
    public function index($id)
    {
        $Questions = Question::with('category','options.OptionsSubCat')->where('category_id',$id)->get();
  
        return response()->json(['Question'=>$Question]);
    }

    public function create(Request $request)
    {
        foreach($request->option_id as $option_id)
        {
            $new = new Survey();
            $new->user_id = $request->user_id;
            $new->category_id = $request->category_id;
            $new->subcategory_id = $request->subcategory_id;
            $new->save();
        }

        $response = ['status'=>true,"message" => "New Survey Added Successfully!"];
        return response($response, 200);
    }

    public function type(Request $request)
    {
        User::where('id');
    }


}
