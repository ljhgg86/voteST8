<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chaosky extends Model
{
    protected $table= 'chaosky';
    protected $fillable = [
        'readnum',
    ];
    public function chaocomment(){
        return $this->hasMany('App\Models\Chaocomment','tipid','tipid');
    }
    public function voteitem(){
        return $this->hasMany('App\Models\Voteitem','tipid','tipid');
    }
    public function voterecord(){
        return $this->hasMany('App\Models\Voterecord','tipid','tipid');
    }
    public function votetitle(){
        return $this->hasMany('App\Models\Votetitle','tipid','tipid');
    }

    /**
     * get chaosky
     *
     * @param int $id
     * @return Chaosky
     */
    public function getChaosky($id){
        return $this->where('tipid',$id)
                    ->where('delflag',0)
                    ->where('draftflag',0)
                    ->with(['voteitem','voterecord','votetitle'])
                    ->first();
    }
}
