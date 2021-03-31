<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
//        dd($request);

        $request->validate([
            'comment' => ['bail','required','min:5','max:10000'],
            'postId' => ['bail','required','numeric'],
            'parentId' => ['bail','required','numeric'],
        ]);


        if ($request->postId === 0)
            dd($request);
        else {
            $post = Post::find($request->postId);
        }

        if(!$post)
            return response()->json([
                'message' => 'Такой страницы не существует!',
                'status' => 'error'
            ], 400);

        $comment = new Comment;

        $comment->comment = $request->comment;

        $comment->user()->associate($request->user());


        $post->comments()->save($comment);

//        return back();

//        return response() ->json([
//            'message'=>'Пожалуйста перейдите по ссылке отправленной на ваш email',
//            'status'=>'success',
//        ]);

        return view('partials.replies',
            ['comments'=>[$comment],'post_id'=>$request->postId,'level'=>0]);
    }

    public function replyStore(Request $request)
    {

        dd($request);
        $reply = new Comment();

        $reply->comment = $request->get('comment');

        $reply->user()->associate($request->user());

        $reply->parent_id = $request->get('comment_id');

        $post = Post::find($request->get('post_id'));

        $post->comments()->save($reply);

        return back();

    }
}
