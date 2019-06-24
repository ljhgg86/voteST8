<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
        $clientIp = $this->getClientIp();
        $voterecordsArr = array();
        foreach($voterecords['voterecord'] as $voterecordItemid){
            $voterecordItem = DB::table('voteitem')->where('id',$voterecordItemid)->first();
            $voterecordInfo = "--".$voterecordItemid."--".$voterecordItem->itemcontent;
            $voterecordsArr[] = array('tipid'=>$voterecords['tipid'],
                                    'localrecord'=>$voterecords['localrecord'],
                                    'userip'=>$clientIp,
                                    'userphone'=>$voterecords['userphone'],
                                    'votetime'=>$votetime,
                                    'voterecord'=>$voterecordInfo,
                                    'browsertype'=>$voterecords['browsertype'],
                                    'wenick'=>$voterecords['wenick']
                                );
        }
        DB::beginTransaction();
        try{
            DB::table('voterecord')->insert($voterecordsArr);
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
            return false;
        }
        return true;
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
    public function recordExist($tipid,$browsertype,$localrecord,$wenick){
        $WECHATTYPE = config('vote.weChatType');
        if($browsertype == $WECHATTYPE){
            return $this->werecordExist($tipid,$wenick);
        }
        else{
            return $this->localrecordExist($tipid,$localrecord);
        }
    }

    /**
     * 指定非微信用户关于指定tipid的投票记录
     *
     * @param int $tipid
     * @param string $localrecord
     * @return voterecord
     */
    public function localrecordExist($tipid,$localrecord){
        $WECHATTYPE = config('vote.weChatType');
        return $this->where('tipid',$tipid)
                    ->where('browsertype','<>',$WECHATTYPE)
                    ->where('localrecord',$localrecord)
                    ->first();
    }

    /**
     * 指定微信用户关于指定tipid的投票记录
     *
     * @param int $tipid
     * @param string $wenick
     * @return voterecord
     */
    public function werecordExist($tipid,$wenick){
        $WECHATTYPE = config('vote.weChatType');
        return $this->where('tipid',$tipid)
                    ->where('browsertype',$WECHATTYPE)
                    ->where('wenick',$wenick)
                    ->first();
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
