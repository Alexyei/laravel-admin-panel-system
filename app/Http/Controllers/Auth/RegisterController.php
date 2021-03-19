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
            'refer' => $user->id??0,
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
       $refer = $user->refer?User::find($user->refer)->login:'';

       // $refer = $refer?$refer->login:null;
       // dd($user->refer);
        if (User::where('email', $user->email)->first())
            //return view('auth.enter',['error'=>'Пользователь с таким email уже зарегистрирован']);
        return view('popup.popup',['status'=>'error','message'=>'Пользователь с таким email уже зарегистрирован','redirect'=>route('enter',$refer)]);
        if (User::where('login', $user->login)->first())
            //return view('auth.enter',['error'=>'Пользователь с таким именем уже зарегистрирован']);
            return view('popup.popup',['status'=>'error','message'=>'Пользователь с таким именем уже зарегистрирован','redirect'=>route('enter',$refer)]);
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
