<?php

namespace App\Http\Controllers\Auth;;

use App\Models\User;
use App\Models\VerifyUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    // создаём временную запись
    public function create(User $user)
    {
        return view('auth.login');
    }

    // подтверждение регистрации
    public function store(VerifyUser $user)
    {
        return view('auth.login');
    }
}
