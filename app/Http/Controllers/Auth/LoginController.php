<?php

namespace App\Http\Controllers\Auth;;

use App\Mail\VerifyEmail;
use App\Models\User;
use App\Models\VerifyUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    // общая точка входа (sign in, sign up, reset password)
    public function enter(User $user)
    {
        return view('auth.enter',['user'=>$user]);
    }

    // войти
    public function login(Request $request)
    {
        //'bail' - не првоерять после первой ошибки
        $request->validate([
            'login' => ['bail','required','alpha_dash','min:3','max:20'],
            'password' => ['bail','required','min:5','max:30','alpha_dash'],
        ]);

        if(Auth::attempt(['login'=>$request->login,'password'=>$request->password])){
            //return redirect(route('main'))->with('success', 'Logged In Successfully');
            return response() ->json(['redirect'=>route('main')]);
        }
        else{
            return response()->json([
                'message' => Lang::get('auth.failed'),
                'status' => 'error'
            ], 400);
        }
    }

    // выйти
    public function logout()
    {
        Auth::logout();
        return redirect()->back();
    }
}
