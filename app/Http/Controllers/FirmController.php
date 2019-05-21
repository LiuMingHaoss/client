<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\FirmUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class FirmController extends Controller
{
    //注册页面
     public function reg(){
         $res=DB::table('firm_user')->where('uid',Auth::id())->first();
         if($res){
             if($res->appid){
                 return view('firm.my',['data'=>$res]);
             }else{
                 echo '暂未通过审核，无法获取参数';
             }

         }else{
             return view('firm.reg');
         }

     }
     //执行注册
    public function regdo(Request $request){
        $file = $request->file('firm_img');
        // 文件是否上传成功
        if ($file->isValid()) {

            // 获取文件相关信息
            $originalName = $file->getClientOriginalName(); // 文件原名
            $ext = $file->getClientOriginalExtension();     // 扩展名
            $path = $file->getRealPath();

            // 上传文件
            $filename = 'upload/'.substr(md5($originalName),0,10) . '.' . $ext;

            Storage::disk('local')->put($filename, file_get_contents($path));

        }
        //接收表单数据
        $data=$request->input();
         $data['add_time']=time();
         $data['uid']=Auth::id();
         $data['firm_img']=$filename;
         $user_id=FirmUser::insertGetId($data);
         if($user_id){

                header('Refresh:2;url=/firm/my');
                echo "注册成功，等待审核";

         }else{
             die('注册失败');
         }

    }
    //个人中心
    public function my(){

        $key=DB::table('firm_user')->where('uid',Auth::id())->first();
        if($key->appid){
            return view('firm.my',['data'=>$key]);
        }else{
            echo '暂未通过审核，无法获取参数';
        }

     }
     //获取access_token
    public function getToken(Request $request){
        $key='token:num';
        $num=Redis::incr($key);
        if($num>20){
            $response=[
                'errno'=>40001,
                'msg'=>'请求次数过多，请稍后再试',

            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        Redis::expire($key,60);
        echo '请求次数：'.$num;
         $appid=$request->input('appid');
         $key=$request->input('key');
         if(empty($appid) || empty($key)){
             $response=[
               'errno'=>10001,
               'msg'=>'参数不全'
             ];
             die(json_encode($response,JSON_UNESCAPED_UNICODE));
         }
         $redis_key='token:uid:'.Auth::id();
         $token=Redis::get($redis_key);
        if(!$token){
            $token=Str::random(10);
            Redis::set($redis_key,$token);
            Redis::expire($redis_key,3600);
        }
        $response=[
            'errno'=>0,
            'msg'=>'获取token成功',
            'data'=>[
                'token'=>$token
            ]
        ];
        die(json_encode($response,JSON_UNESCAPED_UNICODE));
     }
     //获取用户ip
    public function userip(){
        $key='ip:num';
         $num=Redis::incr($key);
         if($num>20){
             $response=[
                 'errno'=>40001,
                 'msg'=>'请求次数过多，请稍后再试',

             ];
             die(json_encode($response,JSON_UNESCAPED_UNICODE));
         }
         Redis::expire($key,60);
         echo '请求次数：'.$num;
         $ip=$_SERVER['REMOTE_ADDR'];
        $response=[
            'errno'=>0,
            'msg'=>'获取ip成功',
            'data'=>[
                'ip'=>$ip
            ]
        ];
        die(json_encode($response,JSON_UNESCAPED_UNICODE));
    }
    //获取ua
    public function ua(){
        $key='ua:num';
        $num=Redis::incr($key);
        if($num>20){
            $response=[
                'errno'=>40001,
                'msg'=>'请求次数过多，请稍后再试',

            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        Redis::expire($key,60);
         $ua=$_SERVER['HTTP_USER_AGENT'];
        $response=[
            'errno'=>0,
            'msg'=>'获取成功',
            'data'=>[
                'ip'=>$ua
            ]
        ];
        die(json_encode($response,JSON_UNESCAPED_UNICODE));
    }

    public function userInfo(Request $request){
        $key='userinfo:num';
        $num=Redis::incr($key);
        if($num>20){
            $response=[
                'errno'=>40001,
                'msg'=>'请求次数过多，请稍后再试',

            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        Redis::expire($key,60);
         $uid=$request->input('uid');
         if(empty($uid)){
             $response=[
                 'errno'=>20002,
                 'msg'=>'用户不存在',

             ];
             die(json_encode($response,JSON_UNESCAPED_UNICODE));
         }
         $user_Info=DB::table('firm_user')->where('uid',$uid)->first();
         if($user_Info){
             $user_Info=json_encode($user_Info);
             $user_Info=json_decode($user_Info,true);
             $response=[
                 'errno'=>0,
                 'msg'=>'获取用户信息成功',
                 'userInfo'=>$user_Info
             ];
             die(json_encode($response,JSON_UNESCAPED_UNICODE));
         }else{
             $response=[
                 'errno'=>20001,
                 'msg'=>'没有查到该用户信息'
             ];
             die(json_encode($response,JSON_UNESCAPED_UNICODE));
         }

     }

}
