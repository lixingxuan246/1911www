<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
class AlipayController extends Controller
{
    //

    /**
     * 支付页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function testPay()
    {
        return view('goods');
    }


    /**
     * 跳转支付宝支付
     */
    public function pay(Request $request)
    {
        $oid = $request->get('oid');
        //echo '订单ID： '. $oid;
        //根据订单查询到订单信息  订单号  订单金额

        //调用 支付宝支付接口

        // 1 请求参数
        $param2 = [
            'out_trade_no'      => time().mt_rand(11111,99999),
            'product_code'      => 'FAST_INSTANT_TRADE_PAY',
            'total_amount'      => 5999,
            'subject'           => '1911-测试订单-'.Str::random(16),
        ];

        // 2 公共参数
        $param1 = [
            'app_id'        => '2016102000727848',                          //沙箱ip
            'method'        => 'alipay.trade.page.pay',
            'return_url'    => 'http://1911lxx.comcto.com/alipay/return',   //同步通知地址
            'charset'       => 'utf-8',
            'sign_type'     => 'RSA2',
            'timestamp'     => date('Y-m-d H:i:s'),
            'version'       => '1.0',
            'notify_url'    => 'http://1911lxx.comcto.com/alipay/notify',   // 异步通知
            'biz_content'   => json_encode($param2),
        ];

        //echo '<pre>';print_r($param1);echo '</pre>';
        // 计算签名
        ksort($param1);
        //echo '<pre>';print_r($param1);echo '</pre>';

        $str = "";
        foreach($param1 as $k=>$v)
        {
            $str .= $k . '=' . $v . '&';
        }

        $str = rtrim($str,'&');     // 拼接待签名的字符串

        $sign = $this->sign($str);
        //echo $sign;echo '<hr>';

        //沙箱测试地址
        $url = 'https://openapi.alipaydev.com/gateway.do?'.$str.'&sign='.urlencode($sign);
        //echo $url;die;
        return redirect($url);
        //echo $url;
    }



    protected function sign($data)
{
//        if ($this->checkEmpty($this->rsaPrivateKeyFilePath)) {
////            $priKey = $this->rsaPrivateKey;
////
////            $res = "-----BEGIN RSA PRIVATE KEY-----\n" .
////                wordwrap($priKey, 64, "\n", true) .
////                "\n-----END RSA PRIVATE KEY-----";
////        } else {
////            $priKey = file_get_contents($this->rsaPrivateKeyFilePath);
////            $res = openssl_get_privatekey($priKey);
////        }

    $priKey = file_get_contents(storage_path('ali_priv.key'));
    $res = openssl_get_privatekey($priKey);
    //var_dump($res);echo '<hr>';

    ($res) or die('您使用的私钥格式错误，请检查RSA私钥配置');

    openssl_sign($data, $sign, $res, OPENSSL_ALGO_SHA256);
    openssl_free_key($res);
    $sign = base64_encode($sign);
    return $sign;
}
}
