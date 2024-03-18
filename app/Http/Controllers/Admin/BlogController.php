<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogSubCategories;
use App\Models\BlogCategory;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index($id)
    {
        $Blog = Blog::with('blogCat.blogSubCat.sub_category')->whereHas('blogCat', function ($query) use ($id){
            $query->where('category_id',$id);
           })->get();

       return response()->json(['Blog'=>$Blog]);
    }

    public function create(Request $request)
    {
        $new = new Blog();
        $new->title = $request->title;
        $new->content = $request->content;
        $new->category_id = $request->category_id;
        $new->author = $request->author;
        $new->subscription =$request->subscription;
        if($request->file('thumbnail')){
            $file= $request->thumbnail;
            $filename= date('YmdHis').$file->getClientOriginalName();
            $file->move(public_path('BlogThumbnail'),$filename);
            $new->thumbnail = $filename;
        }
        $new->save();


        // Create categories and subcategories records
        foreach ($request->categories as $categoryData) {
            $category = new BlogCategory();
            $category->blog_id = $new->id;
            $category->category_id = $categoryData['category_id'];
            $category->save();
    
            foreach ($categoryData['subcategory_id'] as $subcategoryId) {
                $subcategory = new BlogSubCategories();
                $subcategory->blog_id = $new->id;
                $subcategory->blog_category_id = $category->id;
                $subcategory->subcategory_id = $subcategoryId;
                
                $subcategory->save();
            }
    

        }




        // foreach($request->sub_category_id as $item)
        // {
        //     $new1 = new BlogSubCategories();
        //     $new1->blog_id = $new->id;
        //     $new1->subcategory_id = $item;  
        //     $new1->save();
        // }

        $response = ['status'=>true,"message" => "New Blog Added Successfully!"];
        return response($response, 200);
    }

    public function edit($id)
    {
        $edit = Blog::where('id',$id)->first();

        return response()->json(['edit'=>$edit]);
    }

    public function update(Request $request)
    {
        $update = Blog::where('id',$request->id)->first();
        $update->title = $request->title;
        $update->content = $request->content;
        $update->category_id = $request->category_id;
        $update->author = $request->author;
        $update->subscription =$request->subscription;
        if($request->file('thumbnail')){
            $file= $request->thumbnail;
            $filename= date('YmdHis').$file->getClientOriginalName();
            $file->move(public_path('BlogThumbnail'),$filename);
            $update->thumbnail = $filename;
        }
        $update->save();

        $gg = BlogCategory::where('blog_id',$update->id)->get();
        if($gg)
        {
            foreach($gg as $item)
            {
                BlogCategory::where('id',$item->id)->delete();
            }
        }

        
        // Create categories and subcategories records
        if($request->categories)
        {
            foreach ($request->categories as $categoryData) {
                $category = new BlogCategory();
                $category->blog_id = $update->id;
                $category->category_id = $categoryData['category_id'];
                $category->save();
        
                foreach ($categoryData['subcategory_id'] as $subcategoryId) {
                    $subcategory = new BlogSubCategories();
                    $subcategory->blog_id = $update->id;
                    $subcategory->blog_category_id = $category->id;
                    $subcategory->subcategory_id = $subcategoryId;
                    
                    $subcategory->save();
                }
        
    
            }
        }


        $response = ['status'=>true,"message" => "Blog updated Successfully!"];
        return response($response, 200);
    }

    public function delete($id)
    {
      $file = Blog::find($id);
      if(public_path('BlogThumbnail/'.$file->thumbnail))
      {
          unlink(public_path('BlogThumbnail/'.$file->thumbnail));
      }

        $file->delete();
        $response = ['status'=>true,"message" => "Blog Deleted Successfully!"];
        return response($response, 200);



    }

    public function soft_delete(Request $request)
    {
        BlogCategory::where('blog_id',$request->blog_id)->where('category_id',$request->category_id)->delete();

        $response = ['status'=>true,"message" => "Blog Deleted Successfully!"];
        return response($response, 200);
    }

    public function changeStatus($id)
    {
        $status = Blog::where('id',$id)->first();

        if($status->status == 1)
        {
            $status->status = 0;
        }
        else
        {
            $status->status = 1;
        }
        $status->save();

        // $log = new Log();
        // $log->activity = Auth::guard('admin')->user()->first_name. ' change Music status with name ' .$status->title. ' at ' .Carbon::now();
        // $log->save();

        $response = ['status'=>true,"message" => "Status Changed Successfully!"];
        return response($response, 200);

    }

}
