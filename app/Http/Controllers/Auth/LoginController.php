<?php

namespace App\Http\Controllers\Auth;;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class LoginController extends Controller
{
    // общая точка входа (sign in, sign up, reset password)
    public function enter()
    {
        return view('auth.enter');
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
            return response() ->json(['code'=>200,'redirect'=>route('main')]);
        }
        else{
            return redirect()->back()->withErrors([
                'error' => Lang::get('auth.failed'),
            ]);
        }
    }

    // выйти
    public function logout()
    {
        Auth::logout();
        return redirect()->back();
    }
}
