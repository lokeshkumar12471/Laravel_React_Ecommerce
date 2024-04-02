<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index(Request $request){

        $category=Category::get();
        return response()->json([
            'category'=>$category,
            'status'=>200,
            'message'=>'Category List Displaying Successfully'
        ]);
    }


    public function allcategory(){
        $category = Category::where('status','0')->get();
         return response()->json([
            'category'=>$category,
            'status'=>200,
            'message'=>'AllCategory List Displaying Successfully'
        ]);
    }
    public function store(Request $request){
        $vaildator = Validator::make($request->all(),[
           'name'=>'required|max:191',
           'slug'=>'required|max:191',
            'meta_title'=>'required|max:191',
        ]);
        if($vaildator->fails()){
       return response()->json([
       'errors'=>$vaildator->messages(),
       'status'=>422]);
        }else{
         $category = new Category;
         $category->meta_title=$request->meta_title;
         $category->meta_keyword=$request->meta_keyword;
         $category->meta_descrip=$request->meta_descrip;
         $category->slug=$request->slug;
         $category->name=$request->name;
         $category->description=$request->description;
         $category->status=$request->status == true ? '1':'0';
         $category->save();
         return response()->json([
            'status'=>200,
            'message'=>'Category Added Successfully'
        ]);
        }
        }


        public function edit($id){
            $category=Category::find($id);
            if($category){
            return response()->json(['category'=>$category,'status'=>200]);
            }else{
             return response()->json(['status'=>404,'message'=>'No Category Id Found']);
            }
        }

           public function update(Request $request,$id){
        $vaildator = Validator::make($request->all(),[
           'name'=>'required|max:191',
           'slug'=>'required|max:191',
            'meta_title'=>'required|max:191',
        ]);
        if($vaildator->fails()){
       return response()->json([
       'errors'=>$vaildator->messages(),
       'status'=>422]);
        }else{
        $category =  Category::find($id);
       if($category){
         $category->meta_title=$request->meta_title;
         $category->meta_keyword=$request->meta_keyword;
         $category->meta_descrip=$request->meta_descrip;
         $category->slug=$request->slug;
         $category->name=$request->name;
         $category->description=$request->description;
         $category->status=$request->status == true ? '1':'0';
         $category->update();
         return response()->json([
            'status'=>200,
            'message'=>'Category Updated Successfully'
        ]);
        }else{
        return response()->json([
            'status'=>404,
            'message'=>'No Category Id Found'
        ]);
            }

        }
        }

        public function delete($id){
            $category=Category::find($id);
            if($category){
                $category->delete();
             return response()->json(['status'=>200,'message'=>'Category Deleted Successfully']);
             }else{
              return response()->json(['status'=>404,'message'=>'No Category Id Found']);
             }
         }

}