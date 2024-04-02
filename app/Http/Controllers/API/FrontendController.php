<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FrontendController extends Controller
{
    public function  category(){
        $category=Category::where('status','0')->get();
        return response()->json([
            'status'=>200,
            'category'=>$category,
        ]);
    }

    public function product($slug){
        $category=Category::where('status','0')->where('slug',$slug)->get();
        if($category){
          $product=Product::where('category_id',$category[0]->id)->where('status','0')->get();
        if($product)
        {
            return response()->json([
                'status'=>200,
                'product_data'=>[
                    'product'=> $product,
                    'category'=>$category,
                ]

            ]);
        }
        else
        {
            return response()->json([
                'status'=>400,
                'message'=>'No Product Available'
            ]);
        }
    }else{
            return response()->json([
                'status'=>404,
                'message'=>'No Such Category Found'
            ]);
        }
    }



    public function viewproductdetail($category_slug, $product_slug){
        $category=Category::where('status','0')->where('slug',$category_slug)->get();
        if($category){
          $product=Product::where('category_id',$category[0]->id)->where('slug',$product_slug)->where('status','0')->get();
        if($product)
        {
            return response()->json([
                'status'=>200,
                    'product'=> $product,
            ]);
        }
        else
        {
            return response()->json([
                'status'=>400,
                'message'=>'No Product Available'
            ]);
        }
    }else{
            return response()->json([
                'status'=>404,
                'message'=>'No Such Category Found'
            ]);
        }
    }



}