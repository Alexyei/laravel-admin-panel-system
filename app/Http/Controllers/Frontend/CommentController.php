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

        $request->validate([
            'comment' => ['bail','required','min:5','max:10000'],
            'postId' => ['bail','required','numeric'],
            'parentId' => ['bail','required','numeric'],
        ]);


        if ($request->postId === 0)
            dd($request);
        else {
            $post = Post::find($request->postId);
            $parent = Comment::find($request->parentId);
        }


        if(!$post)
            return response()->json([
                'message' => 'Такой страницы не существует!',
                'status' => 'error'
            ], 400);

        if(!$parent)
            return response()->json([
                'message' => 'Такого комментария не существует!',
                'status' => 'error'
            ], 400);


        $reply = new Comment();

        $reply->comment = $request->comment;

        $reply->user()->associate($request->user());

        $reply->parent_id = $parent->id;

        //$post = Post::find($request->get('post_id'));
        $post->comments()->save($reply);


        return view('partials.replies',
            ['comments'=>[$reply],'post_id'=>$request->postId,'level'=>0]);

    }

    public function delete(Request $request)
    {
        $request->validate([
            'commentId' => ['bail','required','numeric'],
        ]);

        $comment = Comment::find($request->commentId);

        if(!$comment)
            return response()->json([
                'message' => 'Такого комментария не существует!',
                'status' => 'error'
            ], 400);

        $comment->update(['deleted' => true]);

        return '<p class="deleted">Комментарий был удалён</p>';
//        return view('partials.replies',
//            ['comments'=>[$comment],'post_id'=>$comment->postId,'level'=>0]);


    }

    public function complaint(Request $request){

    }
}
