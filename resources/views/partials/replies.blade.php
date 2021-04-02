{{--@foreach($comments as $comment)--}}
{{--    <div class="display-comment">--}}
{{--        <strong>{{ $comment->user->name }}</strong>--}}
{{--        <p>{{ $comment->comment }}</p>--}}
{{--        <a href="" id="reply"></a>--}}
{{--        <form method="post" action="{{ route('reply.add') }}">--}}
{{--            @csrf--}}
{{--            <div class="form-group">--}}
{{--                <input type="text" name="comment" class="form-control" />--}}
{{--                <input type="hidden" name="post_id" value="{{ $post_id }}" />--}}
{{--                <input type="hidden" name="comment_id" value="{{ $comment->id }}" />--}}
{{--            </div>--}}
{{--            <div class="form-group">--}}
{{--                <input type="submit" class="btn btn-sm btn-outline-danger py-0" style="font-size: 0.8em;" value="Reply" />--}}
{{--            </div>--}}
{{--        </form>--}}
{{--        @include('post.partials.replies', ['comments' => $comment->replies])--}}
{{--    </div>--}}
{{--@endforeach--}}

@foreach($comments as $comment)
<div data-comment-id='{{ $comment['id'] }}' class="comment reply-{{$level}}">
    @if($comment['deleted'])
    <p class="deleted">Комментарий был удалён</p>
    @else
        <div class="comment-header @guest  not-allowed @endguest">
            <div class="comment-info ">
                <h3>{{$comment->user->login}}</h3>
                <p>{{strftime( "%B %e, %Y", strtotime($comment['created_at'])) }}</p>
            </div>
            <div class="comment-action">
                <div class="comment-menu">

                    <a href="#" class="comment-menu-icon" data-action-type="complain">
                        <i class="fas fa-exclamation"></i>
                    </a>
                    @admin
                        <a href="#" class="comment-menu-icon" data-action-type="delete">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    @endadmin
                </div>
                <div class="reaction-info">
                    <span class="reaction-up-count">{{$comment->reactionsCount('like')}}</span>
{{--                    ' . ((isset($reaction) and $reaction === 'like') ? ' active' : '') . '--}}
                    <a href="#" data-reaction-type="like"  data-comment-id='{{ $comment['id'] }}' class="reaction-icon
                     '@auth
                        @if($comment->checkUserReaction('like') !== null)
                        active
                    @endif
                    @endauth'">
                    <i class="fas fa-long-arrow-alt-up"></i>
                    </a>
                    <span class="reaction-down-count">{{$comment->reactionsCount('dislike')}}</span>
{{--                    ' . ((isset($reaction) and $reaction === 'dislike') ? ' active' : '') . '--}}
                    <a href="#" data-reaction-type="dislike"  data-comment-id='{{ $comment['id'] }}' class="reaction-icon
                    '@auth
                    @if($comment->checkUserReaction('dislike') !== null)
                        active
                    @endif
                    @endauth'">
                    <i class="fas fa-long-arrow-alt-down"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="comment-body">
            <p>{{$comment['comment']}}</p>
        </div>
        @auth
            <div class="comment-answer" data-comment-id='{{ $comment['id'] }}' onclick="reply(this)" >
            <a >Ответить</a>
        </div>
        @endauth
    @endif
@include('partials.replies', ['comments' => $comment->replies, 'level' => $level+1])
</div>
@endforeach
