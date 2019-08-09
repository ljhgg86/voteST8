<?php

namespace App\Http\Middleware;

use Closure;

class RefuseVote
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
        $refuseMinTime = config('vote.refuseMinTime');
        $refuseMaxTime = config('vote.refuseMaxTime');
        $nowTime = date("H:i:s");
        if(strtotime($nowTime)>strtotime($refuseMinTime) && strtotime($nowTime)<strtotime($refuseMaxTime)){
            return false;
        }
        return $next($request);
    }
}
