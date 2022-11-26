<?php


namespace App\Models;


use App\Http\Traits\UserTrait;

class Pay
{
    use UserTrait;
    public function paytwo($out_trade_no)
    {

        $appid = env('Server_appid');//服务号appid,也是服务商appid,即使申请成为服务商的服务号的appid
        $body = "活动报名"; //商品描述
        $mch_id = env('Server_mch_id');//服务商商户号
        $sub_appid = env('sub_appid');//小程序APPID
        $sub_mch_id = env('sub_mch_id');//子商户号
        $openid = self::authUserOpenId();//用户open_id;
        $nonce_str = $this->nonce_str();//随机字符串
        $notify_url = 'https://zsq.a-poor.com/api/pay/notify';//回调地址
//        $out_trade_no = $out_trade_no;//商户订单号
        $spbill_create_ip = $_SERVER['REMOTE_ADDR'];//服务器IP
        $total_fee = floatval(0.01*100);//因为充值金额最小是1 而且单位为分 如果是充值1元所以这里需要*100
        $trade_type = 'JSAPI';//交易类型 默认

        //这里是按照顺序的 因为下面的签名是按照顺序 排序错误 肯定出错
        $post['appid']            = $appid;
        $post['body']             = $body;
        $post['mch_id']           = $mch_id;
        $post['nonce_str']        = $nonce_str; //随机字符串
        $post['notify_url']       = $notify_url;
        $post['out_trade_no']     = $out_trade_no;
        $post['spbill_create_ip'] = $spbill_create_ip; //终端的ip
        $post['sub_appid']        = $sub_appid;
        $post['sub_mch_id']       = $sub_mch_id;
        $post['sub_openid']           = $openid;
        $post['total_fee']        = $total_fee; //总金额 最低为一块钱 必须是整数
        $post['trade_type']       = $trade_type;
        $sign                     = $this->sign($post); //签名

        $post_xml = '<xml>
	           <appid>'.$appid.'</appid>
	           <body>'.$body.'</body>
	           <mch_id>'.$mch_id.'</mch_id>
	           <nonce_str>'.$nonce_str.'</nonce_str>
	           <notify_url>'.$notify_url.'</notify_url>
	           <out_trade_no>'.$out_trade_no.'</out_trade_no>
	           <spbill_create_ip>'.$spbill_create_ip.'</spbill_create_ip>
	           <sub_appid>'.$sub_appid.'</sub_appid>
	           <sub_mch_id>'.$sub_mch_id.'</sub_mch_id>
	           <sub_openid>'.$openid.'</sub_openid>
	           <total_fee>'.$total_fee.'</total_fee>
	           <trade_type>'.$trade_type.'</trade_type>
	           <sign>'.$sign.'</sign>
	        </xml> ';
        //统一接口prepay_id
        $url   = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
        $xml   = $this->http_request($url,$post_xml);
        $array = $this->xml($xml);//全要大写

        //return $array;
        if ($array['RETURN_CODE'] == 'SUCCESS' && $array['RESULT_CODE'] == 'SUCCESS') {
            $time = time();
            $tmp = [];//临时数组用于签名
            $tmp['appId'] = $sub_appid;
            $tmp['nonceStr'] = $nonce_str;
            $tmp['package'] = 'prepay_id=' . $array['PREPAY_ID'];
            $tmp['signType'] = 'MD5';
            $tmp['timeStamp'] = "$time";
            $data['state'] = 1;
            $data['timeStamp'] = "$time";//时间戳
            $data['nonceStr'] = $nonce_str;//随机字符串
            $data['signType'] = 'MD5';//签名算法，暂支持 MD5
            $data['package'] = 'prepay_id=' . $array['PREPAY_ID'];//统一下单接口返回的 prepay_id 参数值，提交格式如：prepay_id=*
            $data['paySign'] = $this->sign($tmp);//签名,具体签名方案参见微信公众号支付帮助文档;
            $data['out_trade_no'] = $out_trade_no;

        } else {
            $data['state'] = 0;
            $data['text'] = "错误";
            $data['RETURN_CODE'] = $array['RETURN_CODE'];
            $data['RETURN_MSG'] = $array['RETURN_MSG'];
        }
        return $data;
    }

//随机32位字符串
    private function nonce_str()
    {
        $result = '';
        $str = 'QWERTYUIOPASDFGHJKLZXVBNMqwertyuioplkjhgfdsamnbvcxz';
        for ($i = 0; $i < 32; $i++) {
            $result .= $str[rand(0, 48)];
        }
        return $result;
    }

    //签名 $data要先排好顺序
    private function sign($data)
    {
        $stringA = '';
        foreach ($data as $key => $value) {
            if (!$value) continue;
            if ($stringA) $stringA .= '&' . $key . "=" . $value;
            else $stringA = $key . "=" . $value;
        }
        $wx_key = env('sub_key');//服务商key
        $stringSignTemp = $stringA . '&key=' . $wx_key;//申请支付后有给予一个商户账号和密码，登陆后自己设置key
        return strtoupper(md5($stringSignTemp));
    }


    //curl请求啊
    function http_request($url, $data = null, $headers = array())
    {
        $curl = curl_init();
        if (count($headers) >= 1) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

    //获取xml
    private function xml($xml)
    {
        $p = xml_parser_create();
        xml_parse_into_struct($p, $xml, $vals, $index);
        xml_parser_free($p);
        $data = [];
        foreach ($index as $key => $value) {
            if ($key == 'xml' || $key == 'XML') continue;
            $tag = $vals[$value[0]]['tag'];
            $value = $vals[$value[0]]['value'];
            $data[$tag] = $value;
        }
        return $data;
    }
}
