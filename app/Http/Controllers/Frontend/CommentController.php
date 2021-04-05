<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Complaint;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Psy\Util\Json;

class CommentController extends Controller
{
    public function store(Request $request)
    {
//        dd($request);


        $validator = Validator::make($request->all(),[
            'comment' => ['required','min:5','max:10000'],
            'postId' => ['required','numeric'],
            'parentId' => ['required','numeric'],
        ]);
        if ($validator->fails())  {
            return Response::json(array("errors" => $validator->getMessageBag()->toArray()), 422);
        }



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

        $validator = Validator::make($request->all(),[
            'comment' => ['bail','required','min:5','max:10000'],
            'postId' => ['bail','required','numeric'],
            'parentId' => ['bail','required','numeric'],
        ]);
        if ($validator->fails())  {
            return Response::json(array("errors" => $validator->getMessageBag()->toArray()), 422);
        }


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

        $validator = Validator::make($request->all(),[
            'commentId' => ['bail','required','numeric'],
        ]);
        if ($validator->fails())  {
            return Response::json(array("errors" => $validator->getMessageBag()->toArray()), 422);
        }

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
       // dd($request);
        $valid = ['spam','abuse','unfriendly','other'];
        $validator = Validator::make($request->all(),[
            'commentId' => ['bail','required','numeric'],
            'cause' => ['bail','required','in:'.implode(',', $valid),],
        ]);
        if ($validator->fails())  {
            return Response::json(array("errors" => $validator->getMessageBag()->toArray()), 422);
        }
        $comment = Comment::find($request->commentId);

        if(!$comment)
            return response()->json([
                'message' => 'Такого комментария не существует!',
                'status' => 'error'
            ], 400);

        if ($comment->checkComplaintExist($request->cause))
            return response()->json([
                'message' => 'Такое предупреждение уже было отправлено!',
                'status' => 'error'
            ], 400);

        if($request->user()->dailyLimits()->complaints_count > 0){
            $complaint = new Complaint();
            $complaint->user()->associate($request->user());
            $complaint->comment()->associate($request->commentId);
            $complaint->cause = $request->cause;
            $complaint->save();
            $complaint->user()->first()->complaint();

            return response()->json([
                'limit'=>$request->user()->dailyLimits()->complaints_count,
                'message' => 'Предупреждение успешно отправлено!',
                'status' => 'success'
            ], 200);
        }
        else{
            return response()->json([
                'message' => 'Ваш дневной лимит предупреждений исчерпан!',
                'status' => 'error'
            ], 400);
        }
    }
}
