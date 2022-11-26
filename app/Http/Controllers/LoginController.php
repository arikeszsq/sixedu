<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use EasyWeChat\Factory;

class LoginController extends \App\Http\Controllers\Auth\LoginController
{

    /**
     * @OA\Info(
     *     version="1.0",
     *     title="Example for response examples value"
     * )
     * @OA\PathItem(path="/api")
     * @OA\Post(
     *     path="/api/login",
     *     tags={"登录"},
     *     summary="登录",
     *   @OA\RequestBody(
     *       required=true,
     *       description="address edit",
     *       @OA\MediaType(
     *         mediaType="application/x-www-form-urlencoded",
     *         @OA\Schema(
     *              @OA\Property(property="code",type="String",description="code",),
     *              @OA\Property(property="iv",type="String",description="iv",),
     *              @OA\Property(property="data",type="String",description="data",),
     *          ),
     *       ),
     *   ),
     *     @OA\Response(
     *         response=100000,
     *         description="success",
     *      @OA\JsonContent(
     *             @OA\Examples(example="token", value={"token": "asfasdfasdfasdf"}, summary="token")
     *         )
     *     )
     * )
     */
    public function login(Request $request)
    {
        $inputs = $request->all();
        $code = $inputs['code'];
        $iv = $inputs['iv'];
        $encryptedData = $inputs['data'];
        $config = [
            'app_id' => env('AppID'),
            'secret' => env('AppSecret'),
        ];
        $app = Factory::miniProgram($config); // 小程序
        $session = $app->auth->session($code);
        $decryptedData = $app->encryptor->decryptData($session['session_key'], $iv, $encryptedData);
        $open_id = $decryptedData['openId'];
        $user = User::query()->where('openid', $open_id)->first();
        if (!$user) {
            $user = new User();
            $user->openid = $open_id;
            $user->name = $this->filterEmoji($decryptedData['nickName']);
            $user->avatar = $decryptedData['avatarUrl'];
            $user->gender = $decryptedData['gender'];
            $user->country = $decryptedData['country'];
            $user->province = $decryptedData['province'];
            $user->city = $decryptedData['city'];
        }
//        $user = User::query()->firstOrCreate([
//            'openid' => $decryptedData['openId'],
//        ], [
//            'openid' => $decryptedData['openId'],
//            'name' => $this->filterEmoji($decryptedData['nickName']),
//            'avatar' => $decryptedData['avatarUrl'],
//            'gender' => $decryptedData['gender'],
//            'country' => $decryptedData['country'],
//            'province' => $decryptedData['province'],
//            'city' => $decryptedData['city'],
//        ]);
        $user->token = $user->generateToken();
        $user->save();
        return self::success($user)->withHeaders(['token' => $user->token]);
    }

    // 过滤掉emoji表情
    private function filterEmoji($str)
    {
        $str = preg_replace_callback(    //执行一个正则表达式搜索并且使用一个回调进行替换
            '/./u',
            function (array $match) {
                return strlen($match[0]) >= 4 ? '' : $match[0];
            },
            $str);

        return $str;
    }
}
