<?php

namespace App\Http\Controllers\Auth;;

use App\Mail\VerifyEmail;
use App\Models\User;
use App\Models\VerifyUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use function PHPUnit\Framework\isEmpty;

class RegisterController extends Controller
{
    // создаём временную запись
    public function create(Request $request, User $user)
    {
//        return response()->json([
//            'login' => $request->login,
//            'email' => $request->email,
//            'refer' => (!isEmpty($user))?$user->id:0,
//            'password' => bcrypt($request->password),
//        ]);
        $request->validate([
            'login' => ['bail','required','alpha_dash','min:3','max:20'],
            'email' => ['bail','required','email'],
            'password' => ['bail','required','min:5','max:30','alpha_dash','confirmed'],
//            'confirm_password' => ['bail','required','min:5','max:30','alpha_dash']
        ]);

        $tempUser = VerifyUser::create([
            'login' => $request->login,
            'email' => $request->email,
            'refer' => (!isEmpty($user))?$user->id:0,
            'password' => bcrypt($request->password),
        ]);



        Mail::to($tempUser->email)->send(new VerifyEmail($tempUser));
        return response() ->json([
            'message'=>'Please click on the link sent to your email',
            'status'=>'success',
        ]);
    }

    // подтверждение регистрации
    public function store(VerifyUser $verifyuser)
    {
        $user = $verifyuser;
        if (User::where('email', $user->email)->first())
            return view('auth.confirm',['error'=>'Пользователь с таким email уже зарегистрирован']);
        if (User::where('login', $user->login)->first())
            return view('auth.confirm',['error'=>'Пользователь с таким именем уже зарегистрирован']);

       // dd($verifyuser);
        User::create([
            'login' => $user->login,
            'email' => $user->email,
            'refer' => $user->refer,
            'password' => $user->password,
        ]);
        return view('auth.confirm');
    }
}
