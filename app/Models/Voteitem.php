<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voteitem extends Model
{
    protected $table= 'voteitem';
    protected $fillable = [
        'tipid',
        'itemcontent',
        'votecount',
        'itemimg',
        'itemvideo',
        'vtid',
        'rflag',
        'itembrief',
    ];
    public function chaosky(){
        return $this->belongsTo('App\Models\Chaosky','tipid','tipid');
    }
    public function votetitle(){
        return $this->belongsTo('App\Models\Votetitle','vtid','vtid');
    }
}
