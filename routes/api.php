<?php

// use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\Api\V1\BaseController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewPasswordController;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
     return $request->user();
    });

    /*** User Routes For Showing The User  ****/

    Route::get('users/show/{id}',[UserController::class,'show']);

    /*** Product Routes  ****/

    Route::post('products',[ProductController::class,'indexApi'])->middleware('auth:sanctum');
    Route::post('products/add',[ProductController::class,'storeApi']);
    Route::put('products/{id}',[ProductController::class,'updateApi']);
    Route::delete('products/{id}',[ProductController::class,'destroyApi']);
    Route::get('products',function(){
        return response()->json([
        'status' => false,
        'message' => 'Unauthorized!'
        ], 404);
    })->name('login');

    /*** Login And Register Routes  ****/
    Route::post('/auth/login', [LoginController::class, 'loginUser']);
    Route::post('/auth/register', [RegisterController::class, 'createUser']);
    /*** Forgot And Reset Password Routes  ****/
    // Route::post('/forgot', [AuthController::class, 'forgotPassword']);
    // Route::post('/reset', [AuthController::class, 'reset']);
    Route::post('/forgot-password', [NewPasswordController::class, 'forgotPassword']);
    Route::post('/reset-password', [NewPasswordController::class, 'resetPassword']);


// Route::apiresource('products',ProductController::class,array("as" => "api"))->middleware('auth:sanctum');
// Route::apiResource('products', ProductController::class)->middleware('auth:sanctum');
// Route::apiResource('products', ProductController::class)->middleware('auth:sanctum');
//Route::get('products',[ProductController::class,'indexApi']);
// Route::post('register',[RegisterController::class,'register']);
// Route::middleware('auth:api')->group(function () {
//     Route::resource('products',BaseController::class);
// });
// Route::group(['prefix'=> 'V1','namespace'=>'App\Http\Contorllers\Api\V1'],function(){
//     Route::apiResource('loginn',LoginController::class,'index');
//     Route::apiResource('register',RegisterController::class);
// });
// Route::get('/loginn',function(){
//     return Product::all();
// });

