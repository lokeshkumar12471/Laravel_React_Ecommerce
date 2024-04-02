<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\CheckoutController;
use App\Http\Controllers\API\FrontendController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware(['auth:sanctum','isAPIAdmin'])->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register',[AuthController::class,'register'])->name('register');
Route::post('login',[AuthController::class,'login'])->name('login');
Route::get('get-collection',[FrontendController::class,'category'])->name('get-collection');
Route::get('fetchproducts/{slug}',[FrontendController::class,'product'])->name('fetch-products');
Route::get('viewproductdetail/{category_slug}/{product_slug}',[FrontendController::class,'viewproductdetail'])->name('viewproductdetail');
Route::post('add-to-cart',[CartController::class,'addtocart'])->name('addtocart');
Route::get('cart',[CartController::class,'viewcart'])->name('viewcart');
Route::put('cart-updatequantity/{cart_id}/{scope}',[CartController::class,'updatequantity'])->name('updatequantity');
Route::delete('delete-cartitem/{cart_id}',[CartController::class,'deleteCartitem'])->name('deleteCartitem');

Route::post('place-order',[CheckoutController::class,'placeorder'])->name('placeorder');
Route::post('validate-order',[CheckoutController::class,'validateOrder'])->name('validateOrder');



Route::middleware(['auth:api'])->group(function () {
    Route::get('/checkingAuthenticated',function (){
        return response()->json(['message'=>'You are in', 'status'=>200]);
    });
Route::post('refresh',[AuthController::class,'refresh'])->name('refresh');
Route::get('view-category',[CategoryController::class,'index'])->name('index');
Route::get('edit-category/{id}',[CategoryController::class,'edit'])->name('edit');
Route::post('update-category/{id}',[CategoryController::class,'update'])->name('update');
Route::delete('delete-category/{id}',[CategoryController::class,'delete'])->name('delete');
Route::post('store-category',[CategoryController::class,'store'])->name('store');
Route::get('all-category',[CategoryController::class,'allcategory'])->name('allcategory');
Route::post('store-product',[ProductController::class,'store'])->name('store-product');
Route::get('view-product',[ProductController::class,'index'])->name('view-product');
Route::get('edit-product/{id}',[ProductController::class,'edit'])->name('edit-product');
Route::post('update-product/{id}',[ProductController::class,'update'])->name('update-product');
//Orders
Route::get('admin/orders',[OrderController::class,'index'])->name('orders');
});
Route::post('logout',[AuthController::class,'logout'])->name('logout');