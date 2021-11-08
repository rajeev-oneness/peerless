<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $req)
    {
        $req->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $userVerified = false;
        $user = User::where('email',$req->email)->first();
        if($user){
            if($user->block == 0){
                if(Hash::check($req->password,$user->password)) {
                    $userVerified = true;
                } else {
                    $errors['password'] = 'Credentials does not match';
                }

                if($userVerified){
                    auth()->login($user);
                    return redirect()->intended('/home');
                }
            }else{
                $errors['email'] = 'This account is temporary blocked';
            }
        }else{
            $errors['email'] = 'Credentials does not match';
        }
        return back()->withErrors($errors)->withInput($req->all());
    }
}
