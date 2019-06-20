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
}
