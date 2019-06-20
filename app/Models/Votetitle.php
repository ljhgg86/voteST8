<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Votetitle extends Model
{
    protected $table= 'votetitle';
    protected $fillable = [
        'votenum',
    ];
    public function chaosky(){
        return $this->belongsTo('App\Models\Chaosky','tipid','tipid');
    }
    public function voteitem(){
        return $this->hasMany('App\Models\Voteitem','vtid','vtid');
    }
}
