<?php

namespace App\Http\Controllers\Api\V1;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\V1\BaseController As BaseController;

class RegisterController extends BaseController
{
    public function register(Request $request)
    {
    $validator=Validator::make($request->all(), [
        'name' =>'required',
        'email' =>'required|email|unique:users',
        'password' =>'required|min:6'
    ]);
    if ($validator ->fails()) {
        return $this->sendError('Validation Error.', $validator ->errors());
        $input =$request->all();
        $input['password']= Hash::make($input ['password']);
        $user=User::create($input) ;
        $success['token']= $user->createToken('MyApp')->accessToken;
        $success ['name'] = $user->name;
        return $this->sendResponse($success, 'User registered successfully.');
    }
}
    public function show(){
    return view('layouts.register');

    }

//     public function register(Request $request)
//     {
//         // $user = User::create($request->validated());
//     $request->validate([
//         'name' =>'required',
//         'email' =>'required|email|unique:users',
//         'password' =>'required|min:6'
//     ]);

// $postpass= Hash::make($request->password);
// $registerData= array(
//     'name'=> $request->name,
//     'email' => $request ->email,
//     'password' =>$postpass
// );
// // $check=$this->create($data);
// User::create($registerData);
//         return redirect('/')->with('message', "Account successfully registered.");
//     }
//     public function create(array $data){

//         return User::create([
//             'name'=> $data['name'],
//             'email'=> $data['email'],
//             'password'=>Hash::make($data['password'])
//         ]);
//     }

//     public function login(Request $request)
//     {
//     $request->validate([
//         'email' => 'required',
//         'password' => 'required'
//     ]);
//     $credentials = $request->only('email', 'password');
//     if (Auth::class::attempt($credentials)) {
//     return redirect()->intended('devspace')->with('message', 'signed in!');
//     }
//     else{
// $message='Login details are not Valid !';
//         return redirect('/login')->with(Session::class::put('message',$message));
//         // return redirect('/login')->with('message','Login details are not Valid !');
//     }
// }
}
