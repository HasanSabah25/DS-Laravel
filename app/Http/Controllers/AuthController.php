<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
// use Illuminate\Http\Requests\ForgotPasswordRequest;
// use Illuminate\Foundation\Http\ForgotPasswordRequest;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\PasswordReset;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
// use Symfony\Component\HttpFoundation\JsonResponse;

class AuthController extends Controller
{
    /**
     * Create User
     * @param ForgotPasswordRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */

     public function forgotPassword(ForgotPasswordRequest $request)
     {
        $user=($query=User::query());
        $user=$user->where($query->qualifyColumn('email'),$request->email)->first();

        if(!$user || ! $user->email){
            return response()->json()->error('No Record Found','Incorrect Email Address Provided',404);
        }

        $resetPasswordToken=str_pad(random_int(1,9999),4,'0',STR_PAD_LEFT);
        $userPassReset=PasswordReset::where('email',$user->email);
        if(!$userPassReset){
            PasswordReset::create([
                'email' => $user->email,
                'token' => $resetPasswordToken
            ]);
        }
        else{
            $userPassReset->update([
                'email' => $user->email,
                'token' => $resetPasswordToken
            ]);
        }

        $user->notify(new Notification($user,$resetPasswordToken));
// $user,
// $resetPasswordToken


        return response()->json([
            'No Record Found' => 'Incorrect Email Address Provided'
        ],200);
     }

    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function reset(ResetPasswordRequest $request)
    {
        $attributes=$request->validated();
        try {
            $user=User::where('email',$attributes['email'])->first();
            if(!$user){
                return response()->json()->error('No Record Found','Incorrect Email Address Provided',404);
            }
            $resetRequest=PasswordReset::where('email',$user->email)->first();
            if(!$resetRequest ||$resetRequest->token != $request->token){
                return response()->json()->error('AN Error Occured.please try again','Token Mismatch',400);
            }

           $user->fill([
            'password'=> Hash::make($attributes['password']),
           ]);
           $user->save();
           $user->tokens()->delete();
           $resetRequest->delete();
           $token=$user->createToken('authToken')->plainTextToken;
           $loginResponse=[
            // 'user'=>UserResource::make($user),
            'token'=>$token
           ];

            return response()->json([
                $loginResponse,
                'message' => 'Password Reset Successfully',
            ], 201);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
