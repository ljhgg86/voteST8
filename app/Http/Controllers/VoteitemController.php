<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Voteitem;
use Response;

class VoteitemController extends Controller
{
    /**
    *Create a new instance.
    */
    public function __construct()
    {
        $this->voteitem=new Voteitem();
    }

    /**
     * Get voteitem
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getVoteitem($id){
        $voteitem = $this->voteitem->getVoteitem($id);
        if($voteitem){
            return response()->json([
                'status'=>true,
                'message'=>'success',
                'voteitem'=>$voteitem
            ]);
        }
        return response()->json([
            'status'=>false,
            'message'=>'fail',
            'voteitem'=>''
        ]);
    }
}
