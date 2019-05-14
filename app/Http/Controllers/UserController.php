<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
class UserController extends Controller
{
    //注册
    public function reg(){
        return view('user.reg');
    }

    //注册执行
    public function regdo(Request $request){
        $data=$request->input();
        $json_str=json_encode($data);
        $private_key=openssl_pkey_get_private('file://'.storage_path('app/openssl/private_key.pem'));
        openssl_private_encrypt($json_str,$en_str,$private_key);
        $ba64=base64_encode($en_str);
        $url='http://api.1809a.com/reg';
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$ba64);
        curl_setopt($ch,CURLOPT_HTTPHEADER,['Content-type:text/plain']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);    //获取页面内容 不直接输出


        $a=curl_exec($ch);
        $arr=json_decode($a);
        if($arr->errno==0){
            header('Refresh:2;url=/user/login');
            echo "注册成功，跳转登录页面";
        }else{
            header('Refresh:2;url=/user/reg');
            echo "注册失败,".$arr->msg.",请重新注册";
        }
        curl_close($ch);
    }

    //登录
    public function login(){
        return view('user.login');
    }

    //登录执行
    public function logindo(Request $request){

        //接收表单提交
        $data=$request->input();
        $json_arr=json_encode($data);

        //获取私钥
        $private_key=openssl_pkey_get_private('file://'.storage_path('app/openssl/private_key.pem'));
        openssl_private_encrypt($json_arr,$en_str,$private_key);
        $ba64=base64_encode($en_str);

        //curl发送post数据
        $url='http://api.1809a.com/login';
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$ba64);
        curl_setopt($ch,CURLOPT_HTTPHEADER,['Content-type:text/plain']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);    //获取页面内容 不直接输出

        $a=curl_exec($ch);
        $arr=json_decode($a);
        if($arr){
            if($arr->errno==0){
                header('Refresh:2;url=/user/my');
                echo "登录成功，前往个人中心";
            }else{
                header('Refresh:2;url=/user/login');
                echo "登录失败,".$arr->msg.",请重新登录";
            }
        }


        curl_close($ch);
    }

    //个人中心
    public function my(){
        echo __METHOD__;
    }
}
