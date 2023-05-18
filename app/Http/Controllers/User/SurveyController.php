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
        $Question = Question::with('category','options.OptionsSubCat')->where('category_id',$id)->get();
  
        return response()->json(['Question'=>$Question]);
    }

    public function create(Request $request)
    {
        Survey::where('user_id',$request->user_id)->delete();

        foreach($request->subcategory_id as $item)
        {
            $new = new Survey();
            $new->user_id = $request->user_id;
            $new->category_id = $request->category_id;
            $new->subcategory_id = $item;
            $new->save();
        }

        $response = ['status'=>true,"message" => "New Survey Added Successfully!"];
        return response($response, 200);
    }



}
