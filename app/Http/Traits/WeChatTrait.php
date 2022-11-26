<?php

namespace App\Http\Traits;

use App\Models\Activity;
use Carbon\Carbon;
use EasyWeChat\Factory;
use EasyWeChat\Kernel\Http\StreamResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait WeChatTrait
{

    /**
     * @param $user_id
     * @param $activity_id
     * @return mixed|string
     * 直接根据用户id和活动id，生成分享二维码
     */
    public function getUserInvitePic($activity_id, $user_id)
    {
        $share_code_url = $this->getShareQCode($activity_id, $user_id);
        $url = '';
        if ($share_code_url['code'] == 200) {
            $url = $share_code_url['url'];
            $activity = Activity::query()->find($activity_id);
            $share_bg = $activity->share_bg;
            if ($share_bg) {
                $url = $this->mergeImg($share_bg, $share_code_url['url']);
            }
        }
        return $url;
    }

    /**没用这个，用的是下面的getShareQCode **/
    public function shareCodeByEasyWeChat($id, $user_id = null)
    {
//        if ($user_id) {
//            $scene = 'id=' . $id . '&uid=' . $user_id;
//        } else {
//            $scene = 'id=' . $id;
//        }

        if ($user_id) {
            $scene = $id . ',' . $user_id;
        } else {
            $scene = $id;
        }


        $config = [
            'app_id' => env('AppID'),
            'secret' => env('AppSecret'),
            // response_type为可选项指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            'response_type' => 'array',
        ];
        $path = public_path('uploads/Qrcode/');
        if (!file_exists($path)) {
            mkdir($path, 0700, true);
        }
        $filename = 'miniProgram' . time() . '.png';
        $app = Factory::miniProgram($config); // 小程序
        $response = $app->app_code->getUnlimit($scene, ["page" => 'pages/index/index']);
        Log::info('小程序$response::' . json_encode($response, JSON_UNESCAPED_UNICODE));
        if ($response instanceof StreamResponse) {
            $file = $response->saveAs($path, $filename);  //保存文件的操作
            return [
                'code' => 200,
                'msg' => 'success',
                'url' => $path . $file
            ];
        } else {
            return [
                'code' => 10001,
                'msg' => 'failed'
            ];
        }
    }

    public function getAccessToken()
    {
        $access_obj = DB::table('access_token')
            ->where('valid_time', '>', date('Y-m-d H:i:s', time()))
            ->first();
        if ($access_obj) {
            $access_token = $access_obj->access_token;
        } else {
            $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . env('AppID') . '&secret=' . env('AppSecret');
            $token = file_get_contents($url);
            $token_array = json_decode($token, true);
            if (isset($token_array['access_token']) && $token_array['access_token']) {
                $valid_time = date('Y-m-d H:i:s', time() + $token_array['expires_in'] - 20);
                DB::table('access_token')->truncate();
                DB::table('access_token')
                    ->insert([
                        'access_token' => $token_array['access_token'],
                        'expires_in' => $token_array['expires_in'],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                        'valid_time' => $valid_time,
                    ]);
            }
            $access_token = $token_array['access_token'];
        }
        return $access_token;
    }

    /**
     * 根据比例生成最终分享图片
     * 只有小程序上线了，才可以生成分享图
     * @param $activity_id
     * @param null $user_id
     * @return array
     */
    public function getShareQCode($activity_id, $user_id = null)
    {
        $qr_path = "uploads/code/";
        if (!file_exists($qr_path)) {
            mkdir($qr_path, 0777, true);
        }
        $filename = time() . '.png';
        $file = $qr_path . $filename;
        $url = 'https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=' . $this->getAccessToken();
//        if ($user_id) {
//            $scene = 'id=' . $activity_id . '&uid=' . $user_id;
//        } else {
//            $scene = 'id=' . $activity_id;
//        }

        if ($user_id) {
            $scene = $activity_id . ',' . $user_id;
        } else {
            $scene = $activity_id;
        }


        $param = json_encode(["scene" => $scene, "page" => 'pages/index/index', "width" => 300]);

//        $contents = $this->httpRequest($url, $param, "POST");
        $contents = $this->curlPost($url, $param);
        if (isset(json_decode($contents, true)['errcode'])) {
            return [
                'code' => json_decode($contents, true)['errcode'],
                'msg' => json_decode($contents, true)['errmsg']
            ];
        }
//        $data_uri = $this->data_uri($contents, 'image/png');
//        return '<image src=' . $data_uri . '></image>';
        $res = file_put_contents($file, $contents);//将微信返回的图片数据流写入文件
        if ($res === false) {
            Log::error('getShareQCode:', ['getShareQCode' => '文件写入失败']);
            return [
                'code' => 10002,
                'msg' => '文件写入失败'
            ];
        } else {
            return [
                'code' => 200,
                'msg' => 'success',
                'url' => $file
            ];
        }
    }

    //二进制转图片image/png
    public function data_uri($contents, $mime)
    {
        $base64 = base64_encode($contents);
        return ('data:' . $mime . ';base64,' . $base64);
    }

    //把请求发送到微信服务器换取二维码
    public function httpRequest($url, $data = '', $method = 'GET')
    {
        $curl = curl_init();// 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url);// 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);// 对认证证书来源的检测
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);// 从证书中检查SSL加密算法是否存在
//        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        if ($method == 'POST') {
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data != '') {
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            }
        }
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }


    //开启curl post请求
    function curlPost($url, $data)
    {
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检测
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Expect:')); //解决数据包大不能提交
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        $tmpInfo = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            echo 'Errno' . curl_error($curl);
        }
        curl_close($curl); // 关键CURL会话
        return $tmpInfo; // 返回数据
    }


    /***
     * 案例一：将活动背景图片和动态二维码图片合成一张图片
     * 按比例，可以先计算第一张图的宽度高度，然后计算第二张图的宽度高度，然后按比例生成
     * PHP 获取图像宽度函数：imagesx()
     * PHP 获取图像高度函数：imagesy()
     *
     * imagecopymerge(图片1地址, 图片2地址, 80, 90, 图片2横坐标开始位置,图片2纵坐标开始位置, 生成后图片2所占宽度, 生成后图片2所占高度, 100);
     *
     * imagecopymerge ( resource $dst_im , resource $src_im , int $dst_x , int $dst_y , int $src_x , int $src_y , int $src_w , int $src_h , int $pct )
     * 将 src_im 图像中坐标从 src_x，src_y 开始，宽度为 src_w，高度为 src_h 的一部分拷贝到 dst_im 图像中坐标为 dst_x 和 dst_y 的位置上。
     * 两图像将根据 pct 来决定合并程度，其值范围从 0 到 100。
     * 当 pct = 0 时，实际上什么也没做，当为 100 时对于调色板图像本函数和 imagecopy() 完全一样，它对真彩色图像实现了 alpha 透明。
     * @param $img_bg
     * @param $img_min
     */
    public function mergeImg($img_bg, $img_min, $per = null)
    {
        if (!$per) {
            $per = 0.25;
        }
        $qr_path = "uploads/merge/";
        if (!file_exists($qr_path)) {
            mkdir($qr_path, 0700, true);
        }
        $imageValue = getimagesize($img_bg);
        $image_1_width = $imageValue[0]; //原图宽
        $image_1_height = $imageValue[1]; //原图高
        $imageValue_min = getimagesize($img_min);
        $image_2_width = $imageValue_min[0]; //原图宽
        // 按宽度占背景图0.25 的比例，缩放背景图
        $percent_1_4_width = $image_1_width * $per;
        $percent = $percent_1_4_width / $image_2_width;
        $img_min_src = $this->updatePic($img_min, $percent);
        $image_update = getimagesize($img_min_src);
        $src_x = $image_update[0];
        $src_y = $image_update[1];
        $img_bg = file_get_contents($img_bg);
        $image_1 = imagecreatefromstring($img_bg);
        $img_min = file_get_contents($img_min_src);
        $image_2 = imagecreatefromstring($img_min);
        $aim_x = $image_1_width - $src_x - 20;
        $aim_y = $image_1_height - $src_y - 20;
        imagecopymerge($image_1, $image_2, $aim_x, $aim_y, 0, 0, $src_x, $src_y, 100);
        $img_name = 'merge' . time() . '.png';
        $img_path = $qr_path . $img_name;
        imagepng($image_1, $img_path);
//        return '<img src=http://edu.com.me/' . $img_path . '>';
        return $img_path;
    }

    /**
     * 我们的代码需要做到以下步骤才能完成对图形的缩放：
     * 打开来源图片
     * 设置图片缩放百分比（缩放）
     * 获得来源图片，按比调整大小
     * 新建一个指定大小的图片为目标图
     * 将来源图调整后的大小放到目标中
     * 销毁资源
     */
    public function updatePic($img_bg, $percent)
    {
        $qr_path = "uploads/update/";
        if (!file_exists($qr_path)) {
            mkdir($qr_path, 0700, true);
        }
//打开来源图片
        $img_bg_src = file_get_contents($img_bg);
        $a = imagecreatefromstring($img_bg_src);
// 将图片宽高获取到
        list($width, $height) = getimagesize($img_bg);
//设置新的缩放的宽高
        $new_width = $width * $percent;
        $new_height = $height * $percent;
//创建新图片
        $new_image = imagecreatetruecolor($new_width, $new_height);
//将原图$image按照指定的宽高，复制到$new_image指定的宽高大小中
        imagecopyresampled($new_image, $a, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
//        header('content-type:image/jpeg');
        $update_img_name = 'update_' . time() . '.png';
        $new_path = $qr_path . $update_img_name;
        imagepng($new_image, $new_path);
        return $new_path;
    }
}
