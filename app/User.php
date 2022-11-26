<?php

namespace App;

use App\Models\UserActivityInvite;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * generate api token
     *
     * @return mixed
     */
    public function generateToken()
    {
        $this->session = hash('sha256', Str::random(60));
        $this->time_login = Carbon::now()->timestamp;
        $this->save();

        return $this->session;
    }


    public static function getUserById($uid)
    {
        return User::query()->find($uid);
    }

    public static function getAUidByUid($uid)
    {
        $user = User::query()->find($uid);
        if ($user->is_A == 1) {
            return $user->id;
        } else {
            $a_user = UserActivityInvite::query()->where('invited_user_id', $uid)
//                ->where('has_pay', 1)
                ->where('A_user_id', '>', 0)
                ->orderBy('id', 'desc')
                ->first();
            return $a_user->A_user_id;
        }
    }

    const IsA_是 = 1;
    const IsA_否 = 2;
    const IsA_Option = [
        1 => '是',
        2 => '否'
    ];
}
