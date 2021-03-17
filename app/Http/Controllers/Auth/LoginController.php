<?php

namespace App\Http\Controllers\Auth;;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    // общая точка входа (sign in, sign up, reset password)
    public function enter()
    {
        return view('auth.enter');
    }

    // войти
    public function login()
    {
        return view('auth.login');
    }

    // выйти
    public function logout()
    {
        return view('auth.login');
    }
}
