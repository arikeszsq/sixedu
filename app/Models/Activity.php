<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{

    const Status_已上架 = 1;
    const Status_已下架 = 2;

    const is_many_单商家 = 1;
    const is_many_多商家 = 2;

    public static $is_many_list = [
        Activity::is_many_单商家 => '单商家',
        Activity::is_many_多商家 => '多商家'
    ];


    public static $status_list = [
        Activity::Status_已上架 => '已上架',
        Activity::Status_已下架 => '已下架'
    ];

    protected $table = 'activity';

    public static function getActivityById($id)
    {
        return Activity::query()->find($id);
    }

    public function activityCompany()
    {
        return $this->hasMany(ActivitySignCom::class, 'activity_id', 'id');
    }

    public static function getActivityListOptions()
    {
        $activities = Activity::query()
//            ->where('start_time', '>', Carbon::now())
//            ->where('status', 1)//上架
            ->orderBy('id', 'desc')
            ->get();
        $options = [];
        foreach ($activities as $activity) {
            $options[$activity->id] = $activity->title;
        }
        return $options;
    }
}
