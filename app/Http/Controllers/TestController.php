<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    public function userinfo()
    {
        echo 'userinfo123';
    }

    //对称加密中的加密
    public function aes1()
    {
        $method = 'AES-256-CBC';
        $data = '李星轩';
        $iv = 'jjjjjkkkkkiiiiii';
        $key = '1911www';
        $url = 'http://api.1911.com/aes';
        $openssl = OPENSSL_RAW_DATA;
        $data = openssl_encrypt($data, $method, $key, $openssl, $iv);
//        $base64 = base64_encode($data);
//        $base63 = $url . '?date=' . urlencode($base64);

        $post_data = [
            'data' => $data,
        ];
        $ch=curl_init();
        //设置参数
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        //发送请求
        $response=curl_exec($ch);
        echo $response;
        curl_close($ch);
        //提示错误
//        $errno='234'.curl_errno($ch);
//        if($errno){
//            $errmsg='123'.curl_error($ch);
//            var_dump($errmsg);
//        }

    }

    public function aes2(){
        $date = '长江唱几句而非我还';
        $content = file_get_contents(storage_path('key'));
        $pub_key = openssl_get_publickey($content);
        $url = 'http://api.1911.com/aes2';
        openssl_public_encrypt($date,$enc_data,$pub_key);
//        var_dump($enc_data);
        $post_data = [
            'data' => $enc_data,
        ];
        $ch=curl_init();
        //设置参数
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        //发送请求
        $response=curl_exec($ch);
        echo $response;
        curl_close($ch);

    }

    public function aes3(){
           $apikey = $_POST['data'];
           $priv = file_get_contents(storage_path('priv.key'));
           $privkey = openssl_get_privatekey($priv);
           openssl_private_decrypt($apikey,$enc_data,$privkey);
           echo '<br>';
           echo 'www解密：'.$enc_data;
    }


    public function sign1(){
        $data = 'hello xingxuan';
        $key = 'api1911';

        $sign = sha1($data.$key);

        $url = 'http://api.1911.com/sign?data='.$data.'&sign='.$sign;
        $resposer = file_get_contents($url);
        echo $resposer;

    }


/*
 * 验签加密
 * */

    public function sign2(){
        $data = '乐宁';
        $contents = file_get_contents(storage_path('priv.key'));
        $privkey = openssl_get_privatekey($contents);
        openssl_sign($data,$signature,$privkey,OPENSSL_ALGO_SHA1);

//        echo '私钥加密：'.$signature;
//        $url = 'http://api.1911.com/signtwo?data='.$data.'&sign='.$signature;
        $url = 'http://api.1911.com/signtwo';
//        echo $url;nni
//        $response = file_get_contents($url);
//        curl发送post请求
            $post_data = [
                'data' => $data,
                'sign' => $signature,
            ];
        $ch=curl_init();
//        设置参数
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        //发送请求
        $response=curl_exec($ch);
//        echo $response;
        curl_close($ch);
        echo $response;
    }


    /*
     * 数据对称加密 ，私钥签名
     * */
    public function test2(){
        $data = '1911接口开发';

        $priv = file_get_contents(storage_path('priv.key'));
        $p = openssl_get_privatekey($priv);
        openssl_sign($data,$signature,$priv,OPENSSL_ALGO_SHA1);


        $method = 'AES-256-CBC';
        $iv = 'lkjhgfoiuytrlkjh';
        $openssl = OPENSSL_RAW_DATA;
        $key = '1911';
        $data2 = openssl_encrypt($signature,$method,$key,$openssl,$iv);
//        echo $data2;die;




//        echo 'test2:'.$signature;
        $url = 'api.1911.com/test2';
        $post_data = [
            'data' => $data2,
            'data2' => $data,
            'sign' => $signature,
        ];
        $ch=curl_init();
        //设置参数
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1);
//        curl_setopt($ch,CURLOPT_HTTPHEADER,$post_data);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

        //发送请求
        $response=curl_exec($ch);
        echo $response;
        curl_close($ch);








    }
}


