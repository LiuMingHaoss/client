<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $token=$request->input('token');
        if(empty($token)){
            $response=[
                'errno'=>30001,
                'msg'=>'缺少参数'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        $key='token:uid:'.Auth::id();
        $access_token=Redis::get($key);
        if(!$access_token){
            $response=[
                'errno'=>30002,
                'msg'=>'参数已过期'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }else if($access_token!=$token){
            $response=[
                'errno'=>30003,
                'msg'=>'参数不正确'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        return $next($request);
    }
}
