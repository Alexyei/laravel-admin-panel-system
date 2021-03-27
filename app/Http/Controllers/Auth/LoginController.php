<?php

namespace App\Http\Controllers\Auth;;

use App\Mail\VerifyEmail;
use App\Models\Post;
use App\Models\User;
use App\Models\VerifyUser;
use DOMDocument;
use DOMNode;
use FilesystemIterator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;

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

    public function test()
    {

      //dd(Post::find(6)->text);
        $doc = new DOMDocument();
        $doc->loadHTML(Post::find(6)->text);
   //    dd($doc->saveHTML());
        dd(array_diff(scandir(public_path('/images/post/main/')), array('..', '.')));
        $tags = $doc->getElementsByTagName('img');
        $img_names = [];
        foreach ($tags as $tag) {
            $old_src = $tag->getAttribute('src');
            if (!str_starts_with($old_src,'/storage/uploads/')) continue;
           $src_name = array_slice(mb_split("\/", $old_src),-1)[0];
           $img_names[]=$src_name;
            $new_src_url = '/images/post/article/12/'.$src_name;
            $tag->setAttribute('src', $new_src_url);
        }
        return [$this->DOMinnerHTML($doc->getElementsByTagName('body')[0]),$img_names];


//        $contents = preg_replace_callback("/<img[^>]*?src *= *[\"']?([^\"']*)/i",
//            function ($matches) {
//                dd($matches);
//                //global $rootURL;
//                return $matches[1] . $rootURL . "?type=image&URL=" . base64_encode($matches['2']);
//            },
//            Post::find(6)->text);
    }

    function replaceTempSRC($text, $new_path='/images/post/article/12/', $delete = false){
        $doc = new DOMDocument();
        $doc->loadHTML($text);
        //    dd($doc->saveHTML());
        $tags = $doc->getElementsByTagName('img');
        $img_names = [];
        $save_img_names = [];
        foreach ($tags as $tag) {

            $old_src = $tag->getAttribute('src');
            $src_name = array_slice(mb_split("\/", $old_src),-1)[0];

            if (!str_starts_with($old_src,'/storage/uploads/'))
                continue;
            else
                $save_img_names[]=$src_name;

            $img_names[]=$src_name;
            $new_src_url = $new_path.$src_name;
            $tag->setAttribute('src', $new_src_url);
        }
        $new_text = $this->DOMinnerHTML($doc->getElementsByTagName('body')[0]);

        //move $img_name to $new_path

         if ($delete
             && iterator_count(new FilesystemIterator( pUblic_path($new_path), FilesystemIterator::SKIP_DOTS))
             !== (count($save_img_names) + count($img_names))){


             $images_in_dir = array_diff(scandir(public_path('/images/post/main/')), array('..', '.'));
             $del_imgs = array_diff($images_in_dir,$save_img_names,$img_names);
             foreach ($del_imgs as $img){
                 File::delete(public_path('$new_path'.$img));
             }
         }

    }

    function DOMinnerHTML(DOMNode $element)
    {
        $innerHTML = "";
        $children  = $element->childNodes;

        foreach ($children as $child)
        {
            $innerHTML .= $element->ownerDocument->saveHTML($child);
        }

        return $innerHTML;
    }


}
