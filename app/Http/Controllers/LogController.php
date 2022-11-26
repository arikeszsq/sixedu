<?php


namespace App\Http\Controllers;


use App\Models\UserActivityInvite;
use App\User;
use Illuminate\Http\Request;
use Exception;

class LogController extends Controller
{
    public function lists(Request $request)
    {
        $inputs= $request->all();
        $user_id = self::authUserId();
        $inputs['uid'] = $user_id;
        $log_type = $inputs['log_type'];
        try {
            $data = [];
            if ($log_type == 1) {
                //邀请用户记录
                $lists = UserActivityInvite::query()
                    ->with('activity')
                    ->with('inviteUser')
                    ->where('parent_user_id', $user_id)->get();
                foreach ($lists as $list) {
                    $data[] = [
                        'activity_name' => $list->activity->title,
                        'invited_user_name' => $list->inviteUser->name,
                        'created_at' => date('Y-m-d H:i',strtotime($list->activity->created_at)),
                        'money' => '',
                        'name' => '',
                    ];
                }
            } elseif ($log_type == 2) {
                //奖励记录
                $lists = UserActivityInvite::query()
                    ->with('activity')
                    ->with('inviteUser')
                    ->where('has_pay',1)
                    ->where(function ($query) use ($user_id) {
                        $query->where('A_user_id', $user_id)
                            ->orwhere(function ($query) use ($user_id) {
                                $query->where('parent_user_id', $user_id);
                            });
                    })->get();
                foreach ($lists as $list) {
                    if ($list->A_user_id == $list->parent_user_id) {
                        $data[] = [
                            'activity_name' => $list->activity->title,
                            'invited_user_name' => $list->inviteUser->name,
                            'created_at' => date('Y-m-d H:i',strtotime($list->activity->created_at)),
                            'money' => $list->activity->a_invite_money,
                            'name' => 'A级别邀请人奖励'
                        ];
                    }elseif($list->A_user_id !=$user_id){
                        $data[] = [
                            'activity_name' => $list->activity->title,
                            'invited_user_name' => $list->inviteUser->name,
                            'created_at' => date('Y-m-d H:i',strtotime($list->activity->created_at)),
                            'money' => $list->activity->second_invite_money,
                            'name' => '二级邀请人奖励'
                        ];
                    }else{
                        $data[] = [
                            'activity_name' => $list->activity->title,
                            'invited_user_name' => $list->inviteUser->name,
                            'created_at' => date('Y-m-d H:i',strtotime($list->activity->created_at)),
                            'money' => $list->activity->a_other_money,
                            'name' => 'A用户别人邀请获得的奖励'
                        ];
                    }
                }
            }
            return self::success($data);
        } catch (Exception $e) {
            return self::error($e->getCode(), $e->getMessage());
        }
    }
}
