<?php

namespace App\Http\Traits;

use App\Http\Constants\ResponseCodeConstant;
use Illuminate\Http\JsonResponse;
use stdClass;


trait ImageTrait
{
    /**
     * 获取图片尺寸信息
     * @param $imagePath
     * @return array|bool
     */
    public static function imageSize($imagePath)
    {
        if ($imagePath) {
            return getimagesize($imagePath);
        }
        return [];
    }

    public function fullImgUrl($url)
    {
        if (isset($url) && $url) {
            return env('IMG_SERVE') . $url;
        }else{
            return $url;
        }
    }
}
