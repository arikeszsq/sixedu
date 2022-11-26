<?php

namespace App\Http\Traits;


trait PayNoticeTrait
{
    public function profitsharing($sub_appid,$sub_mch_id,$transaction_id,$total_price){
        //整理生成签名的参数
        $tmp = array(
            'type'=>'MERCHANT_ID',
            'account'=>'16046XXXXX',//商户号
            'amount'=>$total_price*30,//分账金额*分账百分比30就是百分之三十
            'description'=>'测试使用',
        );
        $nonce_str = '3a93c91ff4fd56a610ba9c47146ed8ec';
        $receivers = json_encode($tmp,JSON_UNESCAPED_UNICODE);
        $postArr = array(
            'appid' => 'wx5acb4562dxxxxx', //服务号的appid
            'mch_id' => '16046xxxxx', //商户号
            'sub_appid'=>$sub_appid,//特约商户appid
            'sub_mch_id' => $sub_mch_id,//特约商户商户号
            'nonce_str'=>$nonce_str,
            'transaction_id'=>$transaction_id,//微信订单号
            'out_order_no'=>rand(1,100).rand(1000,9999),
            'receivers'=>$receivers
        );
        $sign = $this->getSign($postArr, 'HMAC-SHA256','密钥');
        $postArr['sign'] = $sign;
        $url = 'https://api.mch.weixin.qq.com/secapi/pay/profitsharing';///分账url
        $postXML = $this->toXml($postArr);
        $curl_res = $this->post($url,$postXML);
        return $curl_res;
    }

    public function getSign(array $param, $signType = 'MD5', $md5Key)
    {
        $values = $this->paraFilter($param);
        $values = $this->arraySort($values);
        $signStr = $this->createLinkstring($values);
        $signStr .= '&key=' . $md5Key;
        switch ($signType)
        {
            case 'MD5':
                $sign = md5($signStr);
                break;
            case 'HMAC-SHA256':
                $sign = hash_hmac('sha256', $signStr, $md5Key);
                break;
            default:
                $sign = '';
        }
        return strtoupper($sign);
    }

    public function paraFilter($para)
    {
        $paraFilter = array();
        while (list($key, $val) = each($para))
        {
            if ($val == "") {
                continue;
            } else {
                if (! is_array($para[$key])) {
                    $para[$key] = is_bool($para[$key]) ? $para[$key] : trim($para[$key]);
                }
                $paraFilter[$key] = $para[$key];
            }
        }
        return $paraFilter;
    }


    /**
     * @function 对输入的数组进行字典排序
     * @param array $param 需要排序的数组
     * @return array
     * @author helei
     */
    public function arraySort(array $param)
    {
        ksort($param);
        reset($param);
        return $param;
    }


    /**
     * @function 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
     * @param array $para 需要拼接的数组
     * @return string
     * @throws \Exception
     */
    public function createLinkString($para)
    {
        if (! is_array($para)) {
            throw new \Exception('必须传入数组参数');
        }
        reset($para);
        $arg  = "";
        while (list($key, $val) = each($para)) {
            if (is_array($val)) {
                continue;
            }

            $arg.=$key."=".urldecode($val)."&";
        }
        //去掉最后一个&字符
        $arg = substr($arg, 0, strlen($arg) - 2);
        //如果存在转义字符，那么去掉转义
        if (get_magic_quotes_gpc()) {
            $arg = stripslashes($arg);
        }
        return $arg;
    }


    /**
     * @function 将array转为xml
     * @param array $values
     * @return string|bool
     * @author xiewg
     **/
    public function toXml($values)
    {
        if (!is_array($values) || count($values) <= 0) {
            return false;
        }
        $xml = "<xml>";
        foreach ($values as $key => $val) {
            if (is_numeric($val)) {
                $xml.="<".$key.">".$val."</".$key.">";
            } else {
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }


    public function setOption($option) {
        $this->option = $option + $this->option;
        return $this;
    }

    public function post($url, $data, $timeoutMs = 3000) {
        return $this->request( $data, $url,$timeoutMs);
    }

    public function request($xml, $url, $useCert = false, $second = 30)
    {
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        //如果有配置代理这里就设置代理
//        if(WxPayConfig::CURL_PROXY_HOST != "0.0.0.0"
//            && WxPayConfig::CURL_PROXY_PORT != 0){
//            curl_setopt($ch,CURLOPT_PROXY, WxPayConfig::CURL_PROXY_HOST);
//            curl_setopt($ch,CURLOPT_PROXYPORT, WxPayConfig::CURL_PROXY_PORT);
//        }
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);//严格校验
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        if (defined('CURLOPT_IPRESOLVE') && defined('CURL_IPRESOLVE_V4')) {
            curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        }
        if($useCert == true){
            $cert_dir = '服务商证书目录';
            if(
                !file_exists($cert_dir."apiclient_cert.pem") ||
                !file_exists($cert_dir."apiclient_key.pem")
            ){
                return "2";
            }
            //设置证书 证书自己参考支付设置
            //使用证书：cert 与 key 分别属于两个.pem文件
            curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
            curl_setopt($ch,CURLOPT_SSLCERT, $cert_dir."apiclient_cert.pem");
            curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
            curl_setopt($ch,CURLOPT_SSLKEY, $cert_dir."apiclient_key.pem");
        }
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        //运行curl
        $data = curl_exec($ch);
//        var_dump($data);
//        die;
        //返回结果
        if($data){
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            return "";
        }
    }
}
