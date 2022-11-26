<?php

namespace App\Http\Traits;

use App\Models\Activity;
use App\Models\ActivityGroup;
use App\Models\ActivitySignUser;
use App\Models\ActivitySignUserCourse;
use App\Models\CompanyCourse;
use App\Models\UserActivityInvite;
use Carbon\Carbon;

trait PaySuccessTrait
{
    use WeChatTrait;
    /**
     * 支付成功后：
     *
     * 增加课程的已售份数
     * 新建团或修改团信息：如果type是开团，group_id 不存在，才新建团，否则去修改团里面的信息
     * 给邀请人分发奖励:也就是把邀请记录表支付状态变成已支付
     * 修改订单的状态及信息
     * 修改邀请记录的支付状态
     * 生成用户的专属分享图片
     * @param $order
     * @return bool
     */
    public function paySuccessDeal($order)
    {
        //支付成功，更新订单状态
        $this->updateOrder($order);
        $this->addCourseSaleNum($order);
        if ($order->type == ActivitySignUser::Type_团) {
            $this->updateActivityGroup($order);//新建团或修改团信息
        }
        $this->updateInviterInfo($order);//给邀请人分发奖励:也就是把邀请记录表支付状态变成已支付,因为邀请人数是统计的邀请表数据
        $this->genInvitePic($order);
        return true;
    }

    public function addCourseSaleNum($order)
    {
        $order_num = $order->order_no;
        $courses = ActivitySignUserCourse::query()->where('order_num', $order_num)->get();
        foreach ($courses as $course) {
            $company_course = CompanyCourse::query()->find($course->course_id);
            $company_course->sale_num += 1;
            $company_course->save();
        }
    }

    public function updateActivityGroup($order)
    {
        ActivityGroup::updatePayInfo($order);
    }

    public function updateOrder($order)
    {
        $order_no = $order->order_no;
        ActivitySignUser::query()->where('order_no', $order_no)
            ->update([
                'has_pay' => 1,
                'status' => 3,
                'pay_time' => Carbon::now(),
            ]);
    }

    public function updateInviterInfo($order)
    {
        $user_id = $order->user_id;
        $activity_id = $order->activity_id;
        if($activity_id){
            UserActivityInvite::query()->where('activity_id', $activity_id)
                ->where('invited_user_id', $user_id)
                ->orderBy('id', 'desc')->update([
                    'has_pay' => 1
                ]);
        }
    }

    /**
     * 用户支付成功之后，生成分享二维码
     * @param $order
     */
    public function genInvitePic($order)
    {
        $order_no = $order->order_no;
        $activity_id = $order->activity_id;
        $user_id = $order->user_id;
        $share_code_url = $this->getShareQCode($activity_id,$user_id);
        if($share_code_url['code']==200){
            $url = $share_code_url['url'];
            $activity = Activity::query()->find($activity_id);
            $share_bg = $activity->share_bg;
            if($share_bg){
                $url = $this->mergeImg($share_bg,$share_code_url['url']);
            }
            ActivitySignUser::query()->where('order_no', $order_no)
                ->update([
                    'share_q_code' => $url
                ]);
        }
    }
}
