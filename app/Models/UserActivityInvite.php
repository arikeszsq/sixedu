<?php

namespace App\Models;


use App\User;
use Illuminate\Database\Eloquent\Model;

class UserActivityInvite extends Model
{

    protected $table = 'user_activity_invite';


    public function activity()
    {
        return $this->hasOne(Activity::class, 'id', 'activity_id');
    }

    public function inviteUser()
    {
        return $this->hasOne(User::class, 'id', 'A_user_id');
    }

    public function parentUser()
    {
        return $this->hasOne(User::class, 'id', 'parent_user_id');
    }

    public function aUser()
    {
        return $this->hasOne(User::class, 'id', 'invited_user_id');
    }
}
