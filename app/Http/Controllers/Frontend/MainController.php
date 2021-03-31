<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $posts = Post::with('tags')->orderBy('id','desc')->paginate(4);
        return view('frontend.main', ['posts' => $posts]);
    }
}
