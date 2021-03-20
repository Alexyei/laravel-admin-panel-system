<?php

namespace App\Http\Controllers\Auth;;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordEmail;
use App\Mail\VerifyEmail;
use App\Models\ResetPassword;
use App\Models\User;
use App\Models\VerifyUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function recovery()
    {
        request()->validate([
            'email' => ['bail','required','email']
        ]);

        $user = User::where('email', request()->email)->first();
        if ($user){
            $tempUser = ResetPassword::create([
//                'login' => $user->login,
                'email' => request()->email,
            ]);



            Mail::to($tempUser->email)->send(new ResetPasswordEmail($user));
            return response() ->json([
                'message'=>'Пожалуйста перейдите по ссылке отправленной на ваш email',
                'status'=>'success',
            ]);
        }
        else{
            return response()->json([
                'message' => 'Пользователя с указанным email не существует',
                'status' => 'error'
            ], 400);
        }

    }

    public function reset(User $user)
    {
        $password = Str::random(10);
        $user->update(["password" => bcrypt($password)]);
        return view('auth.reset',['login'=>$user->login,'password'=>$password]);
    }
}
