<?php


namespace App\Http\Controllers;


use App\Http\Services\ActivityService;
use App\Http\Services\GroupService;
use Exception;
use Illuminate\Http\Request;

class GroupController extends Controller
{

    public $groupService;

    public function __construct(GroupService $groupService)
    {
        $this->groupService = $groupService;
    }

    public function create(Request $request)
    {
        //支付成功之后才会加团或者开团，方法放在ActivityGroup的模型里
    }


    /**
     * @OA\Get(
     *     path="/api/group/lists",
     *     tags={"团"},
     *     summary="团列表",
     *     @OA\Parameter(name="activity_id",in="query",description="活动id",required=true),
     *     @OA\Parameter(name="name",in="query",description="团的名字"),
     *     @OA\Parameter(name="avatar",in="query",description="团长头像"),
     *     @OA\Parameter(name="leader_name",in="query",description="团长名字"),
     *     @OA\Parameter(name="leader_id",in="query",description="团长ID"),
     *     @OA\Parameter(name="num",in="query",description="成团需求人数"),
     *     @OA\Parameter(name="current_num",in="query",description="团现拥有人数"),
     *     @OA\Parameter(name="finished",in="query",description="是否已成团：1是 ，2否"),
     *     @OA\Parameter(name="in_group",in="query",description="我是否在团里，1是2否，判断在团里就是邀请别人，不在团里就是加入团"),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function lists(Request $request)
    {
        $inputs = $request->all();
        $validator = \Validator::make($inputs, [
            'activity_id' => 'required',
        ], [
            'activity_id.required' => '活动ID必填',
        ]);
        $inputs['user_id'] = self::authUserId();
        if ($validator->fails()) {
            return self::parametersIllegal($validator->messages()->first());
        }
        try {
            return self::success($this->groupService->lists($inputs));
        } catch (Exception $e) {
            return self::error($e->getCode(), $e->getMessage());
        }
    }

    /**
     * @OA\Get(
     *     path="/api/group/user-lists/{id}",
     *     tags={"团"},
     *     summary="参团的用户列表",
     *     @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      description="团id"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     )
     * )
     * @param $id
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function userList($id)
    {
        try {
            return self::success($this->groupService->userList($id));
        } catch (Exception $e) {
            return self::error($e->getCode(), $e->getMessage());
        }
    }
}
