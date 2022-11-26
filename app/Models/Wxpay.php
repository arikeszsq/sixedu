<?php

namespace App\Models;


class Wxpay
{

    /**
     * @var mixed
     *
     * 服务商分账模式，不使用
     */
    protected $appid;
    protected $mch_id;
    protected $key;
    protected $openid;
    protected $out_trade_no;
    protected $body;
    protected $total_fee;

    function __construct($openid, $out_trade_no, $body, $total_fee, $profit_sharing = 'Y', $shops = [])
    {
        $this->appid = env('AppID');//小程序appid
        $this->openid = $openid; //用户的openid
        $this->mch_id = env('Mch_id'); //商户号  微信商户平台中查找
        $this->key = env('Wx_pay_key'); //支付秘钥:商户号的密钥, 微信商户平台设置
        $this->out_trade_no = $out_trade_no; //自己生成的订单号
        $this->body = $body; //支付时显示的提示
        $this->total_fee = floatval($total_fee);//金额:使用分为单位的所有要乘100
        $this->profit_sharing = $profit_sharing;//是否分账
        $this->shops = $shops;//是否商家
    }

    public function pay()
    {
        //统一下单接口
        $return = $this->weixinapp();
        return $return;
    }

    //统一下单接口
    private function unifiedorder()
    {
        $url = 'https://api.mch.weixin.qq.com/pay/unifiedorder'; //应该是同步回调地址(不需要更改)
        $shops = $this->shops;
        if ($this->profit_sharing == 'Y') {
            //参数是Y的时候为服务商模式
            $this->key = $shops['sub_key'];
            //这里是按照顺序的 因为下面的签名是按照顺序 排序错误 肯定出错
            $parameters = array(
                'appid' => env('Server_appid'), //服务号的appid
                'mch_id' => env('Server_mch_id'), ////服务商商户号
                'sub_appid' => $shops['sub_appid'],//特约商户的小程序APPID
                'sub_mch_id' => $shops['sub_mch_id'],//特约商户的商户号
                'nonce_str' => $this->createNoncestr(), //随机字符串
                'body' => $this->body, ///这个自己写,微信订单里面显示的是商品名称,商品描述
                'out_trade_no' => $this->out_trade_no, //商户订单号
                'total_fee' => floatval($this->total_fee), //总金额 单位 分,因为充值金额最小是1 而且单位为分 如果是充值1元所以这里需要*100
                'spbill_create_ip' => $_SERVER['REMOTE_ADDR'], //终端IP,服务器IP
                'notify_url' => 'https://zsq.a-poor.com/api/pay/notify', //支付成功回调地址，注意1. 确保外网能正常访问 2.https
                'openid' => $this->openid, //用户appid
                'trade_type' => 'JSAPI',//交易类型 　　　　　　//要是返回该产品权限未开通请在产品中心开通jsAPi他包含的小程序支付,
                'profit_sharing' => 'Y'//此参数为Y的时候为微信服务商支付
            );
        } else {
            //微信小程序普通支付
            $parameters = array(
                'appid' => $this->appid, //小程序ID
                'mch_id' => $this->mch_id, //商户号
                'nonce_str' => $this->createNoncestr(), //随机字符串
                'body' => $this->body, //商品描述
                'out_trade_no' => $this->out_trade_no, //商户订单号
                'total_fee' => $this->total_fee, //总金额 单位 分
                'spbill_create_ip' => $_SERVER['REMOTE_ADDR'], //终端IP
                'notify_url' => 'https://zsq.a-poor.com/api/pay/notify', //支付成功回调地址，注意1. 确保外网能正常访问 2.https
                'openid' => $this->openid, //用户id
                'trade_type' => 'JSAPI'//交易类型 　　　　　　//要是返回该产品权限未开通请在产品中心开通jsAPi他包含的小程序支付
            );
        }
        //统一下单签名
        $parameters['sign'] = $this->getSign($parameters);
        $xmlData = $this->arrayToXml($parameters);
        $return = $this->xmlToArray($this->postXmlCurl($xmlData, $url, 60));
        return $return;
    }

    private static function postXmlCurl($xml, $url, $second = 60, $useCert = false)
    {
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); //严格校验
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        if ($useCert == true) {
            //设置证书
            //使用证书：cert 与 key 分别属于两个.pem文件
            //证书文件请放入服务器的非web目录下
            $sslCertPath = "/cert/apiclient_cert.pem";
            $sslKeyPath = "/cert/apiclient_key.pem";
            curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
            curl_setopt($ch, CURLOPT_SSLCERT, $sslCertPath);
            curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
            curl_setopt($ch, CURLOPT_SSLKEY, $sslKeyPath);
        }
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_TIMEOUT, 40);
        set_time_limit(0);
        //运行curl
        $data = curl_exec($ch);
        //返回结果
        if ($data) {
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            throw new WxPayException("curl出错，错误码:$error");
        }
    }

    //数组转换成xml
    private function arrayToXml($arr)
    {
        $xml = "<root>";
        foreach ($arr as $key => $val) {
            if (is_array($val)) {
                $xml .= "<" . $key . ">" . $this->arrayToXml($val) . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            }
        }
        $xml .= "</root>";
        return $xml;
    }


    //xml转换成数组
    public function xmlToArray($xml)
    {
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        $val = json_decode(json_encode($xmlstring), true);
        return $val;
    }


    //微信小程序接口
    private function weixinapp()
    {
        //统一下单接口
        $unifiedorder = $this->unifiedorder();
        // halt($unifiedorder);
        // if($unifiedorder['err_code_des'] == '201 商户订单号重复'){
        //   return '
        // }
        $parameters = array(
            'appId' => $this->appid, //小程序ID
            'timeStamp' => '' . time() . '', //时间戳
            'nonceStr' => $this->createNoncestr(), //随机串
            'package' => 'prepay_id=' . $unifiedorder['prepay_id'], //数据包 :要是返回201则要修改订单号，这个问题测试中容易出现，上线了基本不出现问题
            'signType' => 'MD5'//签名方式
        );
        //签名
        $parameters['paySign'] = $this->getSign($parameters);
        return $parameters;
    }


    /**
     * 产生随机字符串，不长于32位
     * @param int $length
     * @return string
     */
    private function createNoncestr($length = 32)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    /**
     * 生成签名
     * @param $Obj
     * @return string
     */
    private function getSign($Obj)
    {
        foreach ($Obj as $k => $v) {
            $Parameters[$k] = $v;
        }
        //签名步骤一：按字典序排序参数
        ksort($Parameters);
        //签名步骤二：在string后加入KEY
        $String = $this->formatBizQueryParaMap($Parameters, false);
        $String = $String . "&key=" . $this->key;
        //签名步骤三：MD5加密
        $String = md5($String);
        //签名步骤四：所有字符转为大写
        $result_ = strtoupper($String);
        return $result_;
    }

    /**
     * 格式化参数，签名过程需要使用
     * @param $paraMap
     * @param $urlencode
     * @return false|string
     */
    private function formatBizQueryParaMap($paraMap, $urlencode)
    {
        $buff = "";
        ksort($paraMap);
        foreach ($paraMap as $k => $v) {
            if ($urlencode) {
                $v = urlencode($v);
            }
            $buff .= $k . "=" . $v . "&";
        }
        $reqPar = '';
        if (strlen($buff) > 0) {
            $reqPar = substr($buff, 0, strlen($buff) - 1);
        }
        return $reqPar;
    }


    /***
     * 退款
     * @param $transaction_id
     * @param $out_refund_no
     * @param $total_fee
     * @param $refund_fee
     * @return array
     */
    public function refund($transaction_id, $out_refund_no, $total_fee, $refund_fee)
    {
        //退款参数
        $refundorder = array(
            'appid' => $this->appid,
            'mch_id' => $this->mch_id,
            'nonce_str' => $this->createNoncestr(),
            'transaction_id' => $transaction_id,
            'out_refund_no' => $out_refund_no,
            'total_fee' => $total_fee * 100,
            'refund_fee' => $refund_fee * 100
        );
        $refundorder['sign'] = $this->getSign($refundorder);
        //请求数据,进行退款
        $xmldata = $this->arrayToXml($refundorder);
        $url = 'https://api.mch.weixin.qq.com/secapi/pay/refund';
        $res = $this->postXmlCurl($xmldata, $url, 30, true);
        if (!$res) {
            return array('status' => 0, 'msg' => "Can't connect the server");
        }
        $content = $this->xmlToArray($res);
        if (strval($content['result_code']) == 'FAIL') {
            return array('status' => 0, 'msg' => strval($content['err_code']) . ':' . strval($content['err_code_des']));
        }
        if (strval($content['return_code']) == 'FAIL') {
            return array('status' => 0, 'msg' => strval($content['return_msg']));
        }
        return array('status' => 1, 'transaction_id' => strval($content['transaction_id']));
    }
}
