<?php

namespace App\Http\Controllers\Auth;;

use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class LoginController extends Controller
{
    // общая точка входа (sign in, sign up, reset password)
    public function enter(User $user)
    {
        //user нужен для реферальной ссылки
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

    public function test(){
        $categories = Tag::withCount('posts')->orderBy('posts_count','desc')->take(2)->get();

        foreach ($categories as $cat) {
            echo $cat->name;
            echo $cat->posts_count;
            echo "<hr>";
        }
    }

}
