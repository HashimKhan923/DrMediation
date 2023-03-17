<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Survey;

class SurveyController extends Controller
{
    public function index()
    {
        $Question = Question::with('options')->get();
  
        return response()->json(['Question'=>$Question]);
    }

    public function create(Request $request)
    {
        foreach($request->category_id as $category_id)
        {
            $new = new Survey();
            $new->user_id = $request->user_id;
            $new->category_id = $category_id;
            $new->save();
        }

        $response = ['status'=>true,"message" => "New Survey Added Successfully!"];
        return response($response, 200);
    }


}
