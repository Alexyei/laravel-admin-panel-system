<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('backend.dashboard');
    }

    public function tinyMCEUpload(){
       // return response()->json(['location'=>'/storage/$path']);
       // $fileName = request()->file('file')->getClientOriginalName();
        $fileName = time() . '_' . mb_substr(request()->file('file')->getClientOriginalName(), 0, 239);
        $path=request()->file('file')->storeAs('uploads', $fileName, 'public');
        return response()->json(['location'=>"/storage/$path"]);
    }
}
