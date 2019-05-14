<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    //对称加密
    public function test(){
        // 加密算法
        $encryptMethod = 'AES-256-CBC';
        // 明文数据
        $data = 'Hello World';

        $iv = 'abcddddddddddddo';
        $encrypted = openssl_encrypt($data, $encryptMethod, 'secret', OPENSSL_RAW_DATA, $iv);
        $str=base64_encode($encrypted);
        echo '加密:'.$encrypted;echo '<br>';
        echo 'b64:'.$str;

    }
    //凯撒加密
    public function num(){
      $abc='a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z';
      $str='abcdf';
      $a=str_split($str);
      $arr=explode(',',$abc);
      for($i=0;$i<count($arr);$i++){
          for($y=0;$y<count($a);$y++){
              if($a[$y]==$arr[$i]){
                  $vvv=$arr[$i+1];
                  print_r($vvv);
              }
          }

      }

    }
    public function caesar(){
        $str='abcd';
        $length=strlen($str);
        for($i=0;$i<$length;$i++){
            $sh = ord($str[$i]);
            $ch = chr($sh+1);
            echo $ch;
        }
    }
    public function decaesar($str){
        $length=strlen($str);
        for($i=0;$i<$length;$i++){
            $sh = ord($str[$i]);
            $ch = chr($sh-1);
            echo $ch;
        }
    }
    public function vvv(){


        echo '加密：'.$this->caesar();;echo '<br>';
        echo '解密：'.$this->decaesar($this->caesar());;echo '<br>';
    }

    //非对称加密
    public function caesarTest(){
        $data=[
          'nickname'=>'zhangsan',
          'ka'=>'123345567',
        ];
        $json_str=json_encode($data);

        $private_key=openssl_pkey_get_private('file://'.storage_path('app/openssl/private_key.pem'));
        var_dump($private_key);
        //加密
        openssl_private_encrypt($json_str,$en_str,$private_key);
        $arr=base64_encode($en_str);
        $url='http://api.1809a.com/decaesar';
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$arr);
        curl_setopt($ch,CURLOPT_HTTPHEADER,['Content-type:text/plain']);

        $vv=curl_exec($ch);
        var_dump($vv);
        curl_close($ch);

    }

    //签名
    public function sign(){
        $data=[
          'oid'=>666,
          'amount'=>300,
          'username'=>'aliu'
        ];
        $json_str=json_encode($data);
        $private_key=openssl_pkey_get_private('file://'.storage_path('app/openssl/private_key.pem'));
        openssl_sign($json_str,$signature,$private_key);
        $base64=base64_encode($signature);
        $url='http://api.1809a.com/signTest?sign='.urlencode($base64);
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$json_str);
        curl_setopt($ch,CURLOPT_HTTPHEADER,['Content-type:text/plain']);

        curl_exec($ch);
        $e=curl_errno($ch);
        var_dump($e);
        curl_close($ch);
    }

    public function a(){
        return view('test.a');
    }
}
