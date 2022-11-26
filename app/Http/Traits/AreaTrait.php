<?php

namespace App\Http\Traits;

use Carbon\Carbon;
use EasyWeChat\Factory;
use EasyWeChat\Kernel\Http\StreamResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait AreaTrait
{

    /**
     * php ：求的不是很准确
     *
     *求两个已知经纬度之间的距离,单位为米
     * @param lng1,lng2 经度
     * @param lat1,lat2 纬度
     * @return float 距离，单位米
     * @edit www.jbxue.com
     * //举例，“上海市延安西路2055弄”到“上海市静安寺”的距离：
     * //上海市延安西路2055弄 经纬度：31.2014966,121.40233369999998
     * //上海市静安寺 经纬度：31.22323799999999,121.44552099999998
     * //那么：
     * //echo getdistance(31.2014966,121.40233369999998,31.22323799999999,121.44552099999998);
     **/

    function getPHPDistance($lng1, $lat1, $lng2, $lat2)
    {
        //将角度转为狐度
        $radLat1 = deg2rad($lat1);//deg2rad()函数将角度转换为弧度
        $radLat2 = deg2rad($lat2);
        $radLng1 = deg2rad($lng1);
        $radLng2 = deg2rad($lng2);
        $a = $radLat1 - $radLat2;
        $b = $radLng1 - $radLng2;
        $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2))) * 6378.137 * 1000;
        return $s;

    }

    /**
     * 腾讯地图，根据俩个地址经纬度和出行方式，计算俩地的距离
     * @param $mapFrom
     * @param $mapTo
     * @return false|mixed|string
     */
    function getDistance($mapFrom, $mapTo)
    {
        //$mapFrom      出发地的经纬度	格式‘39.071510,117.190091’即纬度与经度用逗号隔开
        //$mapTo        目的地的将纬度	格式'40.007632,116.389160'即纬度与经度用逗号隔开
        //$key          腾讯地图开发者秘钥，自己申请一个吧
        //$mode         计算方法driving（驾车）、walking（步行）、bicycling（自行车）
        $mode = 'driving';
        $key = env('TENCENT_MAP_API_KEY');
        $url = 'https://apis.map.qq.com/ws/distance/v1/?mode=' . $mode . '&from=' . $mapFrom . '&to=' . $mapTo . '&key=' . $key;
        $info = file_get_contents($url);
        $info = json_decode($info, true);
        if(isset($info['result']['elements'][0]['distance'])){
            $info = $info['result']['elements'][0]['distance'];
        }else{
            $info = 0;
        }
        return $info;
    }

    /**
     * 未用：使用的腾讯的
     * 高德获取某地的经纬度
     * 获取位置的经纬度
     * @param $address
     * @return string
     */
    public function getGeo($address)
    {
        $url = 'http://restapi.amap.com/v3/geocode/geo?address=' . $address . '&output=JSON&key=' . env('Area_key');
        $res = json_decode(file_get_contents($url), true);
        if (isset($res['infocode']) && $res['infocode'] == 10000) {
            return $res['geocodes']['location'];
        }
        return '';
    }

    /**
     * 未用：使用的腾讯的
     * 高德获取俩地的距离
     * @param $address1
     * @param $address2
     * @return float|int
     */
    public function getGap($address1, $address2)
    {
        $url = 'http://restapi.amap.com/v3/distance?origins=' . $address1 . '&destination=' . $address2 . '&output=json&key=' . env('Area_key') . '&type=1';
        $geo1 = $this->getGeo($address1);
        $geo2 = $this->getGeo($address2);
        if ($geo1 && $geo2) {
            $res = json_decode(file_get_contents($url), true);
            if (isset($res['infocode']) && $res['infocode'] == 10000) {
                return ($res['results']['distance']) / 1000;
            }
        }
        return 0;
    }
}
