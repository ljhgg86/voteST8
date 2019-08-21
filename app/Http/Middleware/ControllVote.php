<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Voterecord;

class ControllVote
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
        //$votenum = $request->input('votenum');
        $votenum = config('vote.voteNum');
        $tipid = $request->input('tipid');
        $tipidsArr = config('vote.tipidsArr');
        $controllCounts = config('vote.controllCounts');
        $limitCounts = config('vote.limitCounts');
        $limitVoteArr = config('vote.limitVoteArr');
        $voterecordModel = new Voterecord();
        $voterecordCounts = $voterecordModel->getrecordCounts($tipid);
        if(count($voterecord) != count(array_unique($voterecord)) || $votenum != count(array_intersect($voterecord,$tipidsArr))){
            return false;
        }
        if(!empty(array_intersect($voterecord,$limitVoteArr)) && $limitCounts < $voterecordCounts) {
            return false;
        }
        if($controllCounts < $voterecordCounts){
            return false;
        }

        return $next($request);
    }
}
