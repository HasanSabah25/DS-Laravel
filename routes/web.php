<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LogoutController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SocialAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('layouts.login');
// });

/*** Show Dashboard Routes ***/



/*** User CRUD Routes ***/

// Route::get('users', [App\Http\Controllers\UserController::class, 'index'])->name('users');
// Route::post('users/store', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
// Route::post('users/update',[App\Http\Controllers\UserController::class, 'update'])->name('users.update');
// Route::get('users/edit/{id}/',[UserController::class,'edit']);
// Route::get('users/destroy/{id}/',[UserController::class,'destroy']);

/*** Product CRUD Routes ***/

Route::get('products', [App\Http\Controllers\ProductController::class, 'index'])->name('products');
Route::post('products/store', [App\Http\Controllers\ProductController::class, 'store'])->name('products.store');
Route::post('products/update',[App\Http\Controllers\ProductController::class, 'update'])->name('products.update');
Route::get('products/edit/{id}/',[ProductController::class,'edit']);
Route::get('products/destroy/{id}/',[ProductController::class,'destroy']);



//Route::group(['middleware' => ['guest']], function() {

/*** Register Routes ***/
Route::get('/register', [RegisterController::class,'show'])->name('register.show');
Route::post('/register', [RegisterController::class,'register'])->name('register.perform');
Route::view('register', 'layouts.register')->name('register');

/*** Login Routes ***/

Route::get('/', [LoginController::class,'index'])->name('login.index');
Route::post('/login', [LoginController::class,'login'])->name('login.perform');
// Route::get('/login', [LoginController::class,'index'])->name('login');
// });
Route::get('dashboard',[LoginController::class,'dashboard'])->name('dashboard');
 /*** Logout Routes ***/
Route::group(['middleware' => ['auth']], function() {

    Route::get('/logout', [LogoutController::class,'perform'])->name('logout.perform');

});
//
// Route::view('devspace', 'layouts.devSpace');
Route::view('/registerv', 'layouts.register')->name('registerview');
// Route::post('register', [AuthController::class, 'createUser']);

/*** Sign In With Google Routes ***/

Route::get('/login-google',[SocialAuthController::class,'redirectToProvider'])->name('google.login');
Route::get('auth/google/callback',[SocialAuthController::class,'handleCallback'])->name('google.login.callback');

Route::view('reset-password','layouts.resetPassword')->name('reset.view');
Route::post('password/reset', [NewPasswordController::class, 'resetPassword'])->name('reset.perform');

// Route::post('users/update', [UserController::class,'update'])->name('users.update');
// Route::get('users/update', ['as' => 'users.update', 'uses' => 'UserController@update']);


