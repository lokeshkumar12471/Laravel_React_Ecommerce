<?php

namespace App\Http\Controllers\API;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index(){
        $orders=Order::get();
        return response()->json([
            'status'=>200,
            'orders'=>$orders,
        ]);

    }
}
