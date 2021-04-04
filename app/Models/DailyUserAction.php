<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @mixin Builder
 */
class DailyUserAction extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $primaryKey = 'user_id';
    public $incrementing = false;
    // Determines which database table to use
//    protected $table = 'daily_user_actions';
//
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');

    }
}
