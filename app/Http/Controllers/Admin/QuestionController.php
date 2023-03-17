<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;

class QuestionController extends Controller
{
    public function index()
    {
       $Questions = Question::all();

       return response()->json(['Questions'=>$Questions]);
    }

    public function create(Request $request)
    {
        $new = new Question();
        $new->question = $request->question;
        $new->save();

        $response = ['status'=>true,"message" => "New Question Added Successfully!"];
        return response($response, 200);
    }

    public function edit($id)
    {
        $edit = Question::where('id',$id)->first();

        return response()->json(['edit'=>$edit]);
    }

    public function update(Request $request)
    {
        $update = Question::where('id',$request->id)->first();
        $update->question = $request->question;
        $update->save();

        $response = ['status'=>true,"message" => "Question Updated Successfully!"];
        return response($response, 200);
    }

    public function delete($id)
    {
        Question::find($id)->delete();

        $response = ['status'=>true,"message" => "Question Deleted Successfully!"];
        return response($response, 200);
    }
}
