<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Reaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\Framework\isEmpty;

class ReactionController extends Controller
{
    public function reaction(Request $request)
    {

         $valid = ['like', 'unlike', 'dislike', 'undislike'];
//       dd($request);

        $validator = Validator::make($request->all(),[
            'type' => ['bail','required','in:'.implode(',', $valid),],
            'commentId' => ['bail', 'required', 'numeric'],
        ]);
        if ($validator->fails())  {
            return Response::json(array("errors" => $validator->getMessageBag()->toArray()), 422);
        }

        $comment = Comment::find($request->commentId);
        $type = $request->type;

        if (!$comment)
            return response()->json([
                'message' => 'Такого комментария не существует!',
                'status' => 'error'
            ], 400);


        if (str_starts_with($request->type, 'un')) {
            $type = substr($request->type, 2);
            $reaction = $comment->checkUserReaction($type);

            if ($reaction !== null)
                $reaction->delete();

            else return response()->json([
                'message' => 'Такой реакции не существует!',
                'status' => 'error'
            ], 400);
        } else {
            $reaction = $comment->checkUserReactionExist();

            if ($reaction !== null) {
//                return response()->json([
//                    'message' => 'Такая реакция уже существует!',
//                    'status' => 'error'
//                ], 400);
                $reaction->update(['type' => $request->type]);
            } else {

                $reaction = new Reaction();
                $reaction->type = $type;
                $reaction->user()->associate($request->user());
                $comment->reactions()->save($reaction);
            }

        }


        //return $comment->reactionsCount('like');
//        return response()->json(['like'=>100,
//            'dislike'=>500]);
        return response()->json(['like' => $comment->reactionsCount('like'),
            'dislike' => $comment->reactionsCount('dislike')]);
    }
}
