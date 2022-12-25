<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Models\User;

class LoginController extends Controller
{



    public function index()
    {
        // return view('layouts.login');
       return User::all();
    }

    /**
     * Handle account login request
     *
     * @param LoginRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    // public function login(LoginRequest $request)
    // {
    //     $credentials = $request->getCredentials();

    //     if(!Auth::validate($credentials)):
    //         return redirect()->to('login')
    //             ->withErrors(trans('auth.failed'));
    //     endif;

    //     $user = Auth::getProvider()->retrieveByCredentials($credentials);

    //     Auth::login($user);

    //     return $this->authenticated($request, $user);
    // }
        public function login(Request $request)
    {
    $request->validate([
        'email' => 'required',
        'password' => 'required'
    ]);
    $credentials = $request->only('email', 'password');
    if (Auth::class::attempt($credentials)) {
    return redirect()->route('dashboard')->with('message', 'signed in!');
    }
//     else{
// $message='Login details are not Valid !';
//         return redirect('/')->with(Session::class::put('message',$message));
        return redirect('/')->with('message','Login details are not Valid !');
    // }
}
public function dashboard(){
    if(Auth::check()){
        return view('layouts.devSpace');
    }
    else{
        return view('layouts.404');
    }
}

    /**
     * Handle response after user authenticated
     *
     * @param Request $request
     * @param Auth $user
     *
     * @return \Illuminate\Http\Response
     */
    protected function authenticated(Request $request, $user)
    {
        return redirect()->intended();
    }
}
