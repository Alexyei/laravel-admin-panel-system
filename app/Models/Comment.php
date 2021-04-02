<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * @mixin Builder
 */
class Comment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->orderBy('id','desc');
    }

    public function reactions()
    {
        return $this->morphMany(Reaction::class, 'reactionable')->orderBy('id','desc');
    }

    public function reactionsCount($type)
    {
        return $this->morphMany(Reaction::class, 'reactionable')->where('type', $type)->count();
    }

    public function checkUserReactionExist()
    {
        return $this->morphMany(Reaction::class, 'reactionable')->where('user_id',Auth::id())->orderBy('id','desc')->first();
    }

    public function checkUserReaction($type)
    {
        return $this->morphMany(Reaction::class, 'reactionable')->where('user_id',Auth::id())->where('type', $type)->orderBy('id','desc')->first();
    }
}
