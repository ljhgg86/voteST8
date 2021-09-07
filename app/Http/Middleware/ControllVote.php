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
        //$voterecord = $request->input('voterecord');
        $voterecords = $request->input('voterecords');
        $voterecord = $voterecords[0]['voteItems'];
        //$votenum = $request->input('votenum');
        $votenum = config('vote.voteNum');
        $tipid = $request->input('tipid');
        $tipidsArr = config('vote.tipidsArr');
        $controllCounts = config('vote.controllCounts');
        $limitCounts = config('vote.limitCounts');
        $limitVoteArr = config('vote.limitVoteArr');
        $voterecordModel = new Voterecord();
        //$voterecordCounts = $voterecordModel->getrecordCounts($tipid);//统计整个投票的票数
        $voterecordCounts = $voterecordModel->getItemRecordCounts($tipid, $voterecord[0]);//单选时，统计单个选项票数
        // if(count($voterecord) != count(array_unique($voterecord)) || $votenum != count(array_intersect($voterecord,$tipidsArr))){
        //     return false;
        // }
        if(count($voterecord) != count(array_unique($voterecord))){//限制选择多个投票时提交同一个id
            return false;
        }
        if(!empty(array_intersect($voterecord,$limitVoteArr)) && $limitCounts < $voterecordCounts) {//限制指定组limitVoteArr在过去controllTime时间段内最大数不超过limitCounts
            return false;
        }
        if($controllCounts < $voterecordCounts){//限制所有投票选项在过去controllTime时间段内最大数不超过limitCounts
        
            return false;
        }

        return $next($request);
    }
}
