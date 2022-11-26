<?php

namespace App\Http\Traits;

use App\Models\Activity;
use App\Models\UserActivityInvite;
use App\Models\UserApplyCashOut;
use Carbon\Carbon;
use EasyWeChat\Factory;
use EasyWeChat\Kernel\Http\StreamResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait MoneyCountTrait
{
    public function historyCashOutTotalMoney($user_id)
    {
        return UserApplyCashOut::query()->where('status', 1)
            ->where('user_id', $user_id)
            ->sum('apply_money');
    }

    public function getAllMoney($user_id)
    {
        $A_money_lists = UserActivityInvite::query()
        ->where('has_pay', 1)
        ->where('A_user_id', $user_id)
        ->where('parent_user_id', $user_id)
        ->get();
        $money = 0;
        foreach ($A_money_lists as $list)
        {
            $activity = Activity::query()->find($list->activity_id);
            $s_price = $activity->a_invite_money;
            $money+=$s_price;
        }

        $A_other_money_lists = UserActivityInvite::query()
        ->where('has_pay', 1)
        ->where('A_user_id', $user_id)
        ->where('parent_user_id','!=', $user_id)
        ->get();
        foreach ($A_other_money_lists as $list)
        {
            $activity = Activity::query()->find($list->activity_id);
            $s_price = $activity->a_other_money;
            $money+=$s_price;
        }

        $money_lists = UserActivityInvite::query()
            ->where('has_pay', 1)
            ->where('A_user_id','!=', $user_id)
            ->where('parent_user_id', $user_id)
            ->get();
        foreach ($money_lists as $list)
        {
            $activity = Activity::query()->find($list->activity_id);
            $s_price = $activity->second_invite_money;
            $money+=$s_price;
        }

        return $money;

    }
}
