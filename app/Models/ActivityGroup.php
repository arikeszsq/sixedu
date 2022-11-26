<?php

namespace App\Models;


use App\Http\Traits\UserTrait;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ActivityGroup extends Model
{
    use UserTrait;

    protected $table = 'activity_group';

    const Status_有效_已支付 = 1;
    const Status_无效_未支付 = 2;

    const Finished_成团 = 1;
    const Finished_未成团 = 2;

    public function activity()
    {
        return $this->hasOne(Activity::class, 'id', 'activity_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'leader_id');
    }

    public function openuser()
    {
        return $this->hasOne(User::class, 'id', 'creater_id');
    }

    public static function getGroupById($id)
    {
        return ActivityGroup::query()->find($id);
    }

    public static function updatePayInfo($order)
    {
        if ($order->group_id) {
            $group = ActivityGroup::query()->find($order->group_id);
            $group_current_num = intval($group->current_num) + 1;
            $group->current_num = $group_current_num;
            if ($group_current_num == $group->num) {
                $group->finished = self::Finished_成团;
                $group->success_time = Carbon::now();
            }
            $group->save();
            $group_id = $group->id;
        } else {
            //新建团
            $group_id = self::NewGroup($order->activity_id, $order->user_id);
            //新建完团，更新订单里团group_id
            ActivitySignUser::query()->where('order_no', $order->order_no)->update([
                'group_id' => $group_id
            ]);
        }
        return $group_id;
    }

    public static function NewGroup($activity_id, $user_id)
    {
        $activity = Activity::getActivityById($activity_id);
        $group = new ActivityGroup();
        $group->activity_id = $activity_id;
        $group->name = static::getOnlyCode($activity_id);
        $group->num = $activity->deal_group_num;
        $group->current_num = 1;
        $group->leader_id = $user_id;
        $group->creater_id = $user_id;
        $group->status = 1;
        $group->save();
        return $group->id;
    }

    public static function getOnlyCode($activity_id)
    {
        $code = $activity_id . '团-' . rand(11111111, 99999999);
        $first = ActivityGroup::query()->where('name', $code)->first();
        if ($first) {
            static::getOnlyCode($activity_id);
        }
        return $code;
    }
}
