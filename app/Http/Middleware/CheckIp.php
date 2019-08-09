<?php

namespace App\Http\Middleware;

use Closure;

class CheckIp
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
        $refuseIpArray = config('vote.refuseIpArray');
        $requestIp = $this->getClientIp();
        if(in_array($requestIp,$refuseIpArray)){
            return false;
        }
        return $next($request);
    }
    /**
     * 获取客户端IP
     */
    public function getClientIp() {
        $ip = 'unknown';
        $unknown = 'unknown';
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], $unknown)) {
            // 使用透明代理、欺骗性代理的情况
           $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
       } elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], $unknown)) {
           // 没有代理、使用普通匿名代理和高匿代理的情况
           $ip = $_SERVER['REMOTE_ADDR'];
       }

       // 处理多层代理的情况
       if (strpos($ip, ',') !== false) {
           // 输出第一个IP
          $ip = reset(explode(',', $ip));
       }

       return $ip;
   }
}
