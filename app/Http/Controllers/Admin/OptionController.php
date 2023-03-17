<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Option;


class OptionController extends Controller
{
    public function index()
    {
        $Options = Option::all();

        return response()->json(['Options'=>$Options]);

    }

    public function create(Request $request)
    {
        $new = new Option();
        $new->option = $request->option;
        $new->question_id = $request->question_id;
        $new->category_id = $request->category_id;
        $new->save();

        $response = ['status'=>true,"message" => "New Option Added Successfully!"];
        return response($response, 200);
    }

    public function edit($id)
    {
        $edit = Option::where('id',$id)->first();

        return response()->json(['edit'=>$edit]);
    }

    public function update(Request $request)
    {
        $update = Option::where('id',$request->id)->first();
        $update->option = $request->option;
        $update->question_id = $request->question_id;
        $update->category_id = $request->category_id;
        $update->save();

        $response = ['status'=>true,"message" => "Option Updated Successfully!"];
        return response($response, 200);
    }

    public function delete($id)
    {
        Option::find($id)->delete();

        $response = ['status'=>true,"message" => "Option Deleted Successfully!"];
        return response($response, 200);
    }
}
