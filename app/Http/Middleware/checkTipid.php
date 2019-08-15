<?php

namespace App\Http\Middleware;

use Closure;

class checkTipid
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
        $voterecord = $request->input('voterecord');
        $unIncreVoteArray = config('vote.unIncreVoteArray');
        $votetime = date("Y-m-d H:i:s");
        $refuseTime = config('vote.refuseTime');
        // $pos = strripos($request->url(),"/");
        // $str = substr($request->url(),$pos+1);
        if(!empty(array_intersect($voterecord,$unIncreVoteArray)) && strtotime($votetime)<strtotime($refuseTime)){
            return false;
        }
        // if(!in_array($str,$voterecord)){
        //     return false;
        // }
        return $next($request);
    }
}
