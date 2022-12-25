<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SocialAuthController extends Controller
{
    public function redirectToProvider(){
        return Socialite::driver('google')->redirect();
    }


    public function handleCallback(){
        try {
           $user=Socialite::driver('google')->user();
        } catch (\Exception $th) {
            return redirect('/');
        }
        $existingUser=User::where('google_id',$user->id)->first();

        if ($existingUser) {
           Auth::login($existingUser,true);
        } else {
            $password=Hash::make(random_int(100000,1000000000));
            $newUser=User::create([
                'name'=> $user->name,
                'email'=> $user->email,
                'password'=> $password,
                'google_id'=> $user->id,

           ]);
           Auth::login($newUser,true);
        }
        return redirect()->to('dashboard')->with('message', 'signed in!');

    }
}
