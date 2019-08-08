<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Voteitem;
use DB;

class Voterecord extends Model
{
    protected $table= 'voterecord';
    protected $fillable = [
        'id',
        'tipid',
        'localrecord',
        'userip',
        'userphone',
        'votetime',
        'voterecord',
        'tempid',
        'uid',
        'uscore',
        'browsertype',
        'wenick'
    ];
    public $timestamps = false;
    public function chaosky(){
        return $this->belongsTo('App\Models\Chaosky','tipid','tipid');
    }
    /**
     * Save voterecord
     *
     * @param Array $voterecords
     * @return Boolean
     */
    public function saveVoterecord($voterecords){
        $votetime = date("Y-m-d H:i:s");
        $refuseTime = config('vote.refuseTime');
        $unIncreVoteArr = config('vote.unIncreVoteArray');
        //the below 5 rows code for voteST8 checksum
        $clientIp = $this->getClientIp();
        $str = $voterecords['localrecord']."abc";
        $checksum = md5($str);
        //if($clientIp != config('vote.clientIp') || $checksum != $voterecords['key']){
        if($checksum != $voterecords['key']){
            return false;
        }
        $voterecordsArr = array();
        foreach($voterecords['voterecord'] as $voterecordItemid){
            // $voterecordItem = Voteitem::find($voterecordItemid);
            //$voterecordInfo = "--".$voterecordItem->vtid."--".$voterecordItemid."--".$voterecordItem->itemcontent;
            // $voterecordItemid = $voterecords['voterecord'];
            $voterecordInfo = $voterecordItemid;
            //$voterecordInfo = "A".$voterecordItemid;
            $voterecordsArr[] = array('tipid'=>$voterecords['tipid'],
                                    'localrecord'=>$voterecords['localrecord'],
                                    'userip'=>$clientIp,
                                    'userphone'=>"A".$voterecords['userphone'],
                                    'votetime'=>$votetime,
                                    'voterecord'=>$voterecordInfo,
                                    'uscore'=>$voterecords['uscore'],
                                    'browsertype'=>$voterecords['browsertype'],
                                    'wenick'=>$voterecords['wenick']
                                );
        }
        DB::beginTransaction();
        try{
            DB::table('voterecord')->insert($voterecordsArr);
            //if(!(in_array($voterecords['voterecord'][0],$unIncreVoteArr) && strtotime($votetime)<strtotime($refuseTime))){
                DB::table('voteitem')->whereIn('id',$voterecords['voterecord'])->increment('votecount');
            //}
            //DB::table('voteitem')->where('id',$voterecordItemid)->increment('votecount');
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
            return false;
        }
        return true;
    }

    /**
     * 检查是否已经投票过或者投票数量已达上限
     *
     * @param int $tipid
     * @param int $browsertype
     * @param string $localrecord
     * @param string $wenick
     * @param array $voterecord
     * @param int $voterate
     * @param int $votenum
     * @return void
     */
    public function recordOutOrExist($tipid,$browsertype,$localrecord,$wenick,$voterecord,$voterate,$votenum){
        if($this->isVotenumsOut($tipid,$browsertype,$localrecord,$wenick,$voterate,$votenum)){
            return true;
        }
        return $this->recordExist($tipid,$browsertype,$localrecord,$wenick,$voterecord,$voterate);
    }
    /**
     * 判断当前用户已经投过票的选项数最大
     *
     * @param int $tipid
     * @param int $browsertype
     * @param string $localrecord
     * @param string $wenick
     * @param int $voterate
     * @param int $votenum
     * @return boolean
     */
    public function isVotenumsOut($tipid,$browsertype,$localrecord,$wenick,$voterate,$votenum){
        $WECHATTYPE = config('vote.weChatType');
        if($browsertype == $WECHATTYPE){
            return $votenum<=($this->werecordCounts($tipid,$wenick,$voterate));
        }
        else{
            return $votenum<=($this->localrecordCounts($tipid,$localrecord,$voterate));
        }
    }

    /**
     * 判断当前用户（localstorage或者phone或者微信昵称）是否已经有投票过
     *
     * @param int $tipid
     * @param int $browsertype
     * @param string $localrecord
     * @param string $wenick
     * @return voterecord
     */
    public function recordExist($tipid,$browsertype,$localrecord,$wenick,$voterecord,$voterate){
        $WECHATTYPE = config('vote.weChatType');
        $record = NULL;
        foreach($voterecord as $voterecordid){
            if($browsertype == $WECHATTYPE){
                $record = $this->werecordExist($tipid,$wenick,$voterecordid,$voterate);
            }
            else{
                $record = $this->localrecordExist($tipid,$localrecord,$voterecordid,$voterate);
            }
            if($record){
                return $record;
            }
            else{
                continue;
            }
        }
        return $record;
        // if($browsertype == $WECHATTYPE){
        //     return $this->werecordExist($tipid,$wenick,$voterecord,$voterate);
        // }
        // else{
        //     return $this->localrecordExist($tipid,$localrecord,$voterecord,$voterate);
        // }
    }

    /**
     * 指定非微信用户关于指定tipid的投票记录
     *
     * @param int $tipid
     * @param string $localrecord
     * @return voterecord
     */
    public function localrecordExist($tipid,$localrecord,$voterecord,$voterate){
        $WECHATTYPE = config('vote.weChatType');
        if($voterate == 0){
            return $this->where('tipid',$tipid)
                        ->where('browsertype','<>',$WECHATTYPE)
                        ->where('localrecord',$localrecord)
                        ->where('voterecord',$voterecord)
                        ->first();
        }
        else{
            return $this->where('tipid',$tipid)
                        ->where('browsertype','<>',$WECHATTYPE)
                        ->where('localrecord',$localrecord)
                        ->where('voterecord',$voterecord)
                        ->whereDate('votetime',date('Y-m-d'))
                        ->first();
        }

    }

    /**
     * 指定微信用户关于指定tipid的投票记录
     *
     * @param int $tipid
     * @param string $wenick
     * @return voterecord
     */
    public function werecordExist($tipid,$wenick,$voterecord,$voterate){
        $WECHATTYPE = config('vote.weChatType');
        if($voterate == 0){
            return $this->where('tipid',$tipid)
                        ->where('browsertype',$WECHATTYPE)
                        ->where('wenick',$wenick)
                        ->where('voterecord',$voterecord)
                        ->first();
        }
        else{
            return $this->where('tipid',$tipid)
                        ->where('browsertype',$WECHATTYPE)
                        ->where('wenick',$wenick)
                        ->where('voterecord',$voterecord)
                        ->whereDate('votetime',date('Y-m-d'))
                        ->first();
        }

    }

    /**
     * 指定非微信用户关于指定tipid的已经投票记录数
     *
     * @param int $tipid
     * @param string $localrecord
     * @param int $voterate
     * @return int
     */
    public function localrecordCounts($tipid,$localrecord,$voterate){
        $WECHATTYPE = config('vote.weChatType');
        if($voterate == 0){
            return $this->where('tipid',$tipid)
                        ->where('browsertype','<>',$WECHATTYPE)
                        ->where('localrecord',$localrecord)
                        ->count();
        }
        else{
            return $this->where('tipid',$tipid)
                        ->where('browsertype','<>',$WECHATTYPE)
                        ->where('localrecord',$localrecord)
                        ->whereDate('votetime',date('Y-m-d'))
                        ->count();
        }
    }

    /**
     * 指定微信用户关于指定tipid的已经投票记录数
     *
     * @param int $tipid
     * @param string $wenick
     * @param int $voterate
     * @return int
     */
    public function werecordCounts($tipid,$wenick,$voterate){
        $WECHATTYPE = config('vote.weChatType');
        if($voterate == 0){
            return $this->where('tipid',$tipid)
                        ->where('browsertype',$WECHATTYPE)
                        ->where('wenick',$wenick)
                        ->count();
        }
        else{
            return $this->where('tipid',$tipid)
                        ->where('browsertype',$WECHATTYPE)
                        ->where('wenick',$wenick)
                        ->whereDate('votetime',date('Y-m-d'))
                        ->count();
        }

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
