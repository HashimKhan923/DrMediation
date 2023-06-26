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

    public function app_create(Request $request)
    {
        Survey::where('user_id',$request->user_id)->delete();

        $data = json_decode($request, true);

        $user_id = $data['user_id'];
        $category_id = $data['category_id'];
        $subcategory_ids = $data['subcategory_id'];

        foreach($subcategory_ids as $subcategory_id)
        {
            $new = new Survey();
            $new->user_id = $user_id;
            $new->category_id = $category_id;
            $new->subcategory_id = $subcategory_id;
            $new->save();
        }

        $response = ['status'=>true,"message" => "New Survey Added Successfully!"];
        return response($response, 200);
    }



}
