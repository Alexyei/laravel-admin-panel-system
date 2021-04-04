<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;

/**
 * @mixin Builder
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login',
        'email',
        'password',
        'refer'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
//        'remember_token',
//        'refer',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
//        'email_verified_at' => 'datetime',
    ];

    public function complaint(){
       // $this->belongsTo(DailyUserAction::class,'user_id')->decrement('complaints_count');
        DailyUserAction::where('user_id',$this->original['id'])->decrement('complaints_count');
    }

    public function dailyLimits()
    {
        //return $this->belongsTo(DailyUserAction::class, 'user_id')->firstOrCreate(['user_id' =>$this->original['id']]);
       // return $this->hasOne(DailyUserAction::class, 'user_id');

        $limits = DailyUserAction::where('user_id',$this->original['id'])->first();
        if ($limits === null)
        {
            $limits = new DailyUserAction(['user_id' =>$this->original['id']]);
            $limits->save();
        }

       return $limits;
    }
}
