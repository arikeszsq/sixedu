<?php

namespace App\Models;


use App\User;
use Illuminate\Database\Eloquent\Model;

class UserAward extends Model
{

    protected $table = 'user_award';

    public function activity()
    {
        return $this->hasOne(Activity::class,'id','activity_id');
    }

    public function award()
    {
        return $this->hasOne(Award::class,'id','award_id');
    }

    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

}
