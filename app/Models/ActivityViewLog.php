<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ActivityViewLog extends Model
{

    protected $table = 'activity_view_log';

    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    public function activity()
    {
        return $this->hasOne(Activity::class,'id','activity_id');
    }

}
