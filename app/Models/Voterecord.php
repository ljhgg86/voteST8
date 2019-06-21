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
        $this->fill($voterecords);
        return $this->save();
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
        if($browsertype == 2){
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
        return $this->where('tipid',$tipid)
                    ->where('browsertype','<>',2)
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
        return $this->where('tipid',$tipid)
                    ->where('browsertype',2)
                    ->where('wenick',$wenick)
                    ->first();
    }
}
