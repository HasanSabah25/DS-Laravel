<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class RegisterController extends Controller
{
    public function createUser(Request $request)
    {
        try {
                $validateUser = Validator::make($request->all(),
                [
                    'name' => 'required',
                    'email' => 'required|email|unique:users',
                    'password' => 'required'
                ]);

                if($validateUser->fails()){
                    return response()->json([
                        'status' => false,
                        'message' => 'validation error',
                        'errors' => $validateUser->errors()
                    ], 401);
                }

                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password)
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'User Created Successfully',
                    'token' => $user->createToken("API TOKEN")->plainTextToken
                ], 200);

            } catch (\Throwable $th) {
                return response()->json([
                    'status' => false,
                    'message' => $th->getMessage()
                ], 500);
            }
    }

    public function show()
    {
    return view('layouts.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' =>'required',
            'email' =>'required|email|unique:users',
            'password' =>'required|min:6'
        ]);
        $postpass= Hash::make($request->password);
        $registerData= array(
            'name'=> $request->name,
            'email' => $request ->email,
            'password' =>$postpass
        );
        User::create($registerData);
        return redirect('/')->with('message', "Account successfully registered.");
    }
}
//      public function create(array $data)
//      {
//          return User::create([
//         'name'=> $data['name'],
//         'email'=> $data['email'],
//         'password'=>Hash::make($data['password'])
//          ]);
//      }
//     public function login(Request $request)
//     {
//          $request->validate([
//          'email' => 'required',
//          'password' => 'required'
//          ]);
//          $credentials = $request->only('email', 'password');
//              if (Auth::class::attempt($credentials)) {
//                  return redirect()->intended('devspace')->with('message', 'signed in!');
//          }
//              else{
//              $message='Login details are not Valid !';
//                 return redirect('/login')->with(Session::class::put('message',$message));
//                // return redirect('/login')->with('message','Login details are not Valid !');
//          }
//      }
