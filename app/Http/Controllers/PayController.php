<?php


namespace App\Http\Controllers;

use App\Http\Traits\PaySuccessTrait;
use App\Models\Activity;
use App\Models\ActivityGroup;
use App\Models\ActivitySignUser;
use App\Models\Pay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PayController extends Controller
{

    use PaySuccessTrait;

    /**
     *服务商拓展的商户就属于特约商户，普通商户授权某些功能有了服务商也会变为特约商户
     *
     *
     * Server_appid= //服务号的appid
     * Server_mch_id= //服务商商户号
     * sub_key //特约商户的key
     * sub_appid= //子商户(特约商户)的appid
     * sub_mch_id= //子商户(特约商户)商户号
     *
     *
     *
     * https://www.freesion.com/article/34881028190/
     * 1,需要在微信服务商后台绑定特约商户 和绑定小程序 特约商户申请可以在小程序内部实现。可以自己写接口 后期咱们在写
     * 2,服务商有单独的appid和secret和小程序的appid和secret不一致
     * 3,特约商户有自己的商户号和密钥 与服务商的商户号和密钥不一致
     * 4,在统一下单的时候只有参数’profit_sharing’=>'Y’的时候才会是服务商模式支付。否则就是普通小程序支付
     * 5,服务商需要设置分账比例最低百分之30
     * 6,上述代码已上线，能够正常使用。如果在使用过程中报错，或者返回值错误请检查服务商appid、secret、特约商户商户号和密钥、小程序appid、secret等参数是否正确没有用错
     * 7,服务商分账时使用的证书为服务商证书和微信支付的证书不一致
     * 原文链接：https://blog.csdn.net/weixin_43202928/article/details/119024929
     */


    /**
     * @OA\Post(
     *     path="/api/pay/pay",
     *     tags={"支付"},
     *     summary="支付",
     *   @OA\RequestBody(
     *       required=true,
     *       description="支付",
     *       @OA\MediaType(
     *         mediaType="application/x-www-form-urlencoded",
     *         @OA\Schema(
     *              @OA\Property(property="activity_id",type="Integer",description="活动的id"),
     *              @OA\Property(property="type",type="Integer",description="开团类型必填：1开团 2单独购买"),
     *              @OA\Property(property="sign_name",type="Integer",description="报名学生姓名必填"),
     *              @OA\Property(property="sign_mobile",type="Integer",description="报名手机号必填"),
     *              @OA\Property(property="sign_age",type="Integer",description="报名学生年龄"),
     *              @OA\Property(property="sign_sex",type="Integer",description="性别：1男2女"),
     *              @OA\Property(property="course_ids",type="Integer",description="课程，1，2，3"),
     *              @OA\Property(property="is_agree",type="Integer",description="同意协议 1"),
     *              @OA\Property(property="school_child_ids",type="Integer",description="校区，1，2，3"),
     *              @OA\Property(property="info_one",type="Integer",description="信息一"),
     *              @OA\Property(property="info_two",type="Integer",description="信息二"),
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
    public function pay(Request $request)
    {
        $inputs = $request->all();
        $user_id = self::authUserId();
        Log::info('用户:', ['user_id' => $user_id]);
        $inputs['uid'] = $user_id;
        $inputs['user_id'] = $user_id;

        $validator = \Validator::make($inputs, [
            'activity_id' => 'required',
            'type' => 'required',
            'sign_name' => 'required',
            'sign_mobile' => 'required',
        ], [
            'activity_id.required' => '活动ID必填',
            'type.required' => '开团类型必填：1开团 2单独购买',
            'sign_name.required' => '报名学生姓名必填',
            'sign_mobile.required' => '报名手机号必填',
        ]);
        if ($validator->fails()) {
            return self::parametersIllegal($validator->messages()->first());
        }

        if (isset($inputs['group_id']) && $inputs['group_id']) {
            $group = ActivityGroup::query()->find($inputs['group_id']);
            if ($group && $group->finished == 1) {
                return self::error('10008', '已满团');
            }
        }


        self::updateUserName($inputs['sign_name']);
        $activity_id = $inputs['activity_id'];
        $activity = Activity::getActivityById($activity_id);
        $is_many = $activity->is_many;

        if ($is_many == Activity::is_many_多商家) {
            $validator2 = \Validator::make($inputs, [
                'sign_age' => 'required',
                'sign_sex' => 'required',
                'is_agree' => 'required',
                'course_ids' => 'required',
                'school_child_ids' => 'required',
            ], [
                'sign_age.required' => '报名学生年龄必填',
                'sign_sex.required' => '性别必填：1男2女',
                'is_agree.required' => '必须同意协议',
                'course_ids.required' => '课程必填',
                'school_child_ids.required' => '校区必填',
            ]);
            if ($validator2->fails()) {
                return self::parametersIllegal($validator2->messages()->first());
            }
        }

        if ($is_many == Activity::is_many_单商家) {
            $validator3 = \Validator::make($inputs, [
                'info_one' => 'required',
                'info_two' => 'required',
            ], [
                'info_one.required' => '信息一必填',
                'info_two.required' => '信息二必填',
            ]);
            if ($validator3->fails()) {
                return self::parametersIllegal($validator3->messages()->first());
            }
        }
        $order_number = 'Or' . rand(1111, 9999) . '-' . date('Ymdhis') . '-' . $user_id;
        $inputs['order_num'] = $order_number;

        //总金额 最低为一分 必须是整数
        if ($inputs['type'] == ActivitySignUser::Type_直接买) {
            $fee = $activity->ori_price;
        } else {
            $fee = $activity->real_price;
        }
        $inputs['money'] = $fee;
        // 新建订单
        $order_id = ActivitySignUser::createOrder($inputs);
        if (!$order_id) {
            return self::error('10001', '创建订单失败');
        }

//        正式支付开始
        $obj = new Pay();
        $info = $obj->paytwo($order_number);
        return self::success($info);

        //        测试支付用
//        $order_obj = ActivitySignUser::query()->find($order_id);
//        return self::success($this->paySuccessDeal($order_obj));
    }


    /**
     * 支付成功
     * 增加课程的已售份数
     * 新建团或修改团信息：如果type是开团，group_id 不存在，才新建团，否则去修改团里面的信息
     * 给邀请人分发奖励:也就是把邀请记录表支付状态变成已支付
     * 修改订单的状态及信息
     * 修改邀请记录的支付状态
     * 生成用户的专属分享图片
     *
     * @return bool
     */
    public function notify()
    {
//        Log::info('支付成功后的回调:', ['pay_notify' => 'success']);
        $postXml = file_get_contents("php://input"); //接收微信参数
        if (empty($postXml)) {
            return false;
        }
        $attr = $this->xmlToArray($postXml);
        $out_trade_no = $attr['out_trade_no'];
//        Log::info('out_trade_no:', ['out_trade_no' => $out_trade_no]);
//        Log::info('out_trade_no:', ['attr' => $attr]);
        //-----------------------支付成功后的操作-----------------------------
        $order_no = $out_trade_no;
        $order = ActivitySignUser::query()->where('order_no', $order_no)->first();
        if ($order && $order->has_pay == 2) {
            Log::info('pay_notify:', ['info:' => '支付成功，更新订单']);
            return $this->paySuccessDeal($order);
        } else {
            Log::info('pay_notify:', ['info:' => '重复的支付成功后的回调']);
        }
    }

    function xmlToArray($xml)
    {
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        $val = json_decode(json_encode($xmlstring), true);
        return $val;
    }
}
