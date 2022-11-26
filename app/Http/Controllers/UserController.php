<?php


namespace App\Http\Controllers;


use App\Http\Traits\MoneyCountTrait;
use App\Http\Traits\WeChatTrait;
use App\Models\Activity;
use App\Models\UserActivityInvite;
use App\Models\UserAInvitePic;
use App\Models\UserApplyCashOut;
use App\User;
use Illuminate\Http\Request;
use Exception;

class UserController extends Controller
{
    use WeChatTrait;
    use MoneyCountTrait;

    /**
     * @OA\Get(
     *     path="/api/user/info",
     *     tags={"用户"},
     *     summary="用户信息",
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    public function info()
    {
        $user_id = self::authUserId();
        $inputs['uid'] = $user_id;
        $user = User::query()->find($user_id);
        try {
            $data = [
                'name' => $user->name,
                'avatar' => $user->avatar,
                'gender' => $user->gender,
                'country' => $user->country,
                'province' => $user->province,
                'city' => $user->city,
                'is_A' => $user->is_A,
                'address' => $user->address,
                'map_points' => $user->map_points,
                'share_num' => UserActivityInvite::query()->where('parent_user_id', $user_id)->count(),
                'share_success_num' => UserActivityInvite::query()->where('parent_user_id', $user_id)
                    ->where('has_pay', 1)->count(),
                'current_stay_money' => ($this->getAllMoney($user_id)) - ($this->historyCashOutTotalMoney($user_id)),
            ];
            return self::success($data);
        } catch (Exception $e) {
            return self::error($e->getCode(), $e->getMessage());
        }
    }


    /**
     * @OA\Post(
     *     path="/api/user/update",
     *     tags={"用户"},
     *     summary="设置家的位置",
     *   @OA\RequestBody(
     *       required=true,
     *       description="设置家的位置",
     *       @OA\MediaType(
     *         mediaType="application/x-www-form-urlencoded",
     *         @OA\Schema(
     *              @OA\Property(property="map_points",type="String",description="设置家的地址，纬经度"),
     *              @OA\Property(property="address",type="String",description="设置家的地址"),
     *          ),
     *       ),
     *   ),
     *     @OA\Response(
     *         response=100000,
     *         description="success"
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function update(Request $request)
    {
        $inputs = $request->all();
        $user_id = self::authUserId();
        $inputs['uid'] = $user_id;
        $user = User::query()->find($user_id);
        try {
            if (isset($inputs['map_points']) && $inputs['map_points']) {
                $user->map_points = $inputs['map_points'];
            }
            if (isset($inputs['address']) && $inputs['address']) {
                $user->address = $inputs['address'];
            }
            $user->save();
            return self::success($user);
        } catch (Exception $e) {
            return self::error($e->getCode(), $e->getMessage());
        }
    }

    /**
     * 设置用户为A用户
     */
    public function setA()
    {
        $user_id = self::authUserId();
        try {
            $user = User::query()->find($user_id);
            $user->is_A = 1;
            $user->save();
//            $a_invite_user = UserAInvitePic::query()->orderBy('id', 'desc')->first();
//            $activity = Activity::query()->find($a_invite_user->activity_id);
            $data = [
//                'type' => $activity->is_many,
//                'activity_id' => $activity->id,
                'name' => $user->name
            ];
            return self::success($data);
        } catch (Exception $e) {
            return self::error($e->getCode(), $e->getMessage());
        }
    }

    public function getInvitePic(Request $request)
    {
        $inputs = $request->all();
        $user_id = self::authUserId();
        $activity_id = $inputs['activity_id'];
        $pic_url = $this->getUserInvitePic($activity_id, $user_id);
        return self::success($pic_url);
    }

    public function applyCashOut(Request $request)
    {
        $inputs = $request->all();
        $user_id = self::authUserId();
        $apply_money = $inputs['apply_money'];

        $his_money = $this->historyCashOutTotalMoney($user_id);
        $data = [
            'user_id' => $user_id,
            'apply_money' => $apply_money,
            'history_total_money' => $his_money,
            'current_stay_money' => ($this->getAllMoney($user_id)) - $his_money,
            'created_at' => date('Y-m-d H:i:s', time())
        ];
        $id = UserApplyCashOut::query()->insertGetId($data);
        return self::success($id);
    }
}
