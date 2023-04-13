<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Option;
use App\Models\OptionCategories;

class QuestionController extends Controller
{
    public function index()
    {
       $Questions = Question::with('category','options.OptionsSubCat')->get();

       return response()->json(['Questions'=>$Questions]);
    }

    public function create(Request $request)
    {
        
        
        $new = new Question();
        $new->question = $request->question;
        $new->category_id = $request->category_id;
        $new->save();


            foreach($request->options as $item)
            {
                $newOpt = new Option();
                
                    $newOpt->option = $item['option'];


                $newOpt->category_id = $request->category_id;
                $newOpt->question_id = $new->id;
                $newOpt->save();

                    foreach($item['subcategory'] as $scat)
                    {
                    $new2 = new OptionCategories();
                    $new2->option_id = $newOpt->id;
                    $new2->category_id = $request->category_id;
                    $new2->subcategory_id =$scat ;

                    $new2->save();
                    }


                
            }

            

        $response = ['status'=>true,"message" => "New Question Added Successfully!"];
        return response($response, 200);
    }

    public function edit($id)
    {
        $edit = Question::with('options.OptionsSubCat')->where('id',$id)->first();

        return response()->json(['edit'=>$edit]);
    }

    public function update(Request $request)
    {
        $update = Question::where('id',$request->id)->first();
        $update->question = $request->question;
        $update->category_id = $request->category_id;
        $update->save();


            foreach($request->options as $item)
            {
                $updateOpt = new Option();
                $updateOpt->option = $item['option'];
                $updateOpt->category_id = $request->category_id;
                $updateOpt->question_id = $update->id;
                $updateOpt->save();

                    foreach($item['subcategory'] as $scat)
                    {
                        $update2 = new OptionCategories();
                        $update2->option_id = $updateOpt->id;
                        $update2->category_id = $request->category_id;
                        $update2->subcategory_id =$scat ;
                        $update2->save();
                    }


                
            }

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
