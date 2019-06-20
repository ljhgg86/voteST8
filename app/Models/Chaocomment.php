<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chaocomment extends Model
{
    protected $table= 'chaocomment';
    protected $fillable = [
        'cid',
        'tipid',
        'comment',
        'localrecord',
        'userip',
        'ctime',
        'delflag',
        'verifyflag',
        'userphone',
        'uid',
    ];
    public function chaosky(){
        return $this->belongsTo('App\Models\Chaosky','tipid','tipid');
    }
    /**
     * get chaocomments
     *
     * @param int $tipid
     * @param int $startid
     * @param int $counts
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getComments($tipid,$startid,$counts){
        $comments = $this->where('tipid',$tipid)
                        ->where('delflag',0)
                        ->where('verifyflag',1)
                        ->where('cid','<',$startid)
                        ->orderBy('cid','desc')
                        ->take($counts)
                        ->get();
        return $comments;
    }
}
