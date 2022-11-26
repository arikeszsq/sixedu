<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class UserAInvitePic extends Model
{

    protected $table = 'user_a_invite_pic';

    public function activity()
    {
        return $this->hasOne(Activity::class, 'id', 'activity_id');
    }

}
