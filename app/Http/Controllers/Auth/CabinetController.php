<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerifyCabinetEmail;
use App\Models\User;
use App\Models\VerifyCabinet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class CabinetController extends Controller
{
    public function cabinet()
    {
        return view('auth.cabinet');
    }

    public function change()
    {
//        request()->validate([
//            'login' => ['bail','alpha_dash','min:3','max:20'],
//            'email' => ['bail','email'],
//            'password' => ['bail','min:5','max:30','alpha_dash','confirmed'],
//           'confirm_password' => ['bail','min:5','max:30','alpha_dash']
//        ]);

        $change_data = [];
        if (request()->login !== auth()->user()->login){
            if (User::where('login', request()->login)->first())
                return response()->json([
                    'message' => 'Пользователь с таким именем уже зарегистрирован',
                    'status' => 'error',
                ]);
            $change_data['login'] = request()->login;
        }

        if (request()->email !== auth()->user()->email){
            if (User::where('email', request()->email)->first())
                return response()->json([
                    'message' => 'Пользователь с таким email уже зарегистрирован',
                    'status' => 'error',
                ]);
            $change_data['email'] = request()->email;
        }
        if (request()->password) {
            $change_data['password'] = request()->password;
            $change_data['password_confirmation'] = request()->password_confirmation;
        }

//        $change_data->validate([
//            'login' => ['bail','alpha_dash','min:3','max:20'],
//            'email' => ['bail','email'],
//            'password' => ['bail','min:5','max:30','alpha_dash','confirmed'],
//            'confirm_password' => ['bail','min:5','max:30','alpha_dash']
//        ]);

        if (empty($change_data))
            return response()->json([
                'message' => 'Вы не изменили данные!',
                'status' => 'warning',
            ]);

        Validator::make($change_data, [
            'login' => ['bail', 'alpha_dash', 'min:3', 'max:20'],
            'email' => ['bail', 'email'],
            'password' => ['bail', 'min:5', 'max:30', 'alpha_dash', 'confirmed'],
            // 'password_confirmation' => ['bail','min:5','max:30','alpha_dash']
        ])->validate();


        $changes = VerifyCabinet::create([
            'email' => auth()->user()->email,
            'new_login' => $change_data['login'] ?? null,
            'new_password' => is_null($change_data['password'] ?? null) ? null : bcrypt($change_data['password']),
            'new_email' => $change_data['email'] ?? null,
            'confirm_new_email' => is_null($change_data['email'] ?? null),
        ]);

//
//
        Mail::to($changes->email)->send(new VerifyCabinetEmail($changes, $changes->email));

        if (!$changes->confirm_new_email)
            Mail::to($changes->new_email)->send(new VerifyCabinetEmail($changes, $changes->new_email));

        return response()->json([
            'message' => (!$changes->confirm_new_email) ?
                'Пожалуйста перейдите по двум ссылкам отправленным на ваш текущий email и ваш новый email' :
                'Пожалуйста перейдите по ссылке отправленной на ваш email',
//        'message'=>[
//            'email' => auth()->user()->email,
//            'new_login' => $change_data['login'] ?? null,
//            'new_password' => is_null($change_data['password']??null)?null:bcrypt($change_data['password']),
//           'new_email'=>$change_data['email']??null,
//            'confirm_new_email'=>is_null($change_data['email']??null)
//        ],
//        'message'=>$change_data,
            'status' => 'success',
        ]);
    }

    public function save(VerifyCabinet $verifycabinet, $email)
    {
        if ($verifycabinet->confirm_email && $verifycabinet->confirm_new_email){
            return view('popup.popup', ['status' => 'error', 'message' => 'Данные уже изменены', 'redirect' => route('main')]);
        }

        if ($verifycabinet->email === $email) {
            if (!$verifycabinet->confirm_email)
                $verifycabinet->update(["confirm_email" => true]);
            if (!$verifycabinet->confirm_new_email) {

                return view('popup.popup', ['status' => 'info', 'message' => 'Для завершения изменений данных перейдите по ссылке отправленной на ваш новый email', 'redirect' => route('main')]);
            }
        }
        else if ($verifycabinet->new_email === $email) {
            if (!$verifycabinet->confirm_new_email)
                $verifycabinet->update(["confirm_new_email" => true]);
            if (!$verifycabinet->confirm_email) {

                return view('popup.popup', ['status' => 'info', 'message' => 'Для завершения изменений данных перейдите по ссылке отправленной на ваш текущий email', 'redirect' => route('main')]);
            }
        }

        $user = User::where('email', $verifycabinet->email)->first();
        $newdata = [];
        if (!is_null($verifycabinet->new_login))
            $newdata['login'] = $verifycabinet->new_login;
        if (!is_null($verifycabinet->new_email))
            $newdata['email'] = $verifycabinet->new_email;
        if (!is_null($verifycabinet->new_password))
            $newdata['password'] = $verifycabinet->new_password;
        $user->update($newdata);

        Auth::logout();
        return redirect()->route('enter');
    }
}
