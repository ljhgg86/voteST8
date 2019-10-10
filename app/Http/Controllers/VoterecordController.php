<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Voterecord;
use Response;

class VoterecordController extends Controller
{
    /**
    *Create a new instance.
    */
    public function __construct()
    {
        $this->voterecord=new Voterecord();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeVote(Request $request)
    {
        $voterecords = $request->all();
        $tipid = $voterecords['tipid'];
        $browsertype = $voterecords['browsertype'];
        $localrecord = $voterecords['localrecord'];
        $wenick = $voterecords['wenick'];
        $voterate = $voterecords['voterate'];
        if($this->voterecord->userHasVoted($tipid,$browsertype,$localrecord,$wenick,$voterate)){
            return response()->json([
                'status'=>false,
                'message'=>'您已经投过票了!'
            ]);
        }
        $res = $this->voterecord->saveVoterecord($voterecords);
        if($res){
            return response()->json([
                'status'=>true,
                'message'=>'投票成功!'
            ]);
        }
        return response()->json([
            'status'=>false,
            'message'=>'投票失败!'
        ]);
    }

    public function store(Request $request){
        // $pos = strripos($request->url(),"/");
        // $str = substr($request->url(),$pos+1);
        $voterecords = $request->all();
        $tipid = $voterecords['tipid'];
        $browsertype = $voterecords['browsertype'];
        $localrecord = $voterecords['localrecord'];
        $wenick = $voterecords['wenick'];
        $voterecord = $voterecords['voterecord'];
        $voterate = $voterecords['voterate'];
        $votenum = $voterecords['votenum'];
        if($this->voterecord->recordOutOrExist($tipid,$browsertype,$localrecord,$wenick,$voterecord,$voterate,$votenum)){
            return response()->json([
                'status'=>false,
                'message'=>'您已经投过票了!'
            ]);
        }
        $res = $this->voterecord->saveVoterecord($voterecords);
        if($res){
            return response()->json([
                'status'=>true,
                'message'=>'投票成功!'
            ]);
        }
        return response()->json([
            'status'=>false,
            'message'=>'投票失败!'
        ]);
    }

    public function storeList($id,Request $request){
        $voterecords = $request->all();
        $voterecords['voterecord'] = array($id);
        $tipid = $voterecords['tipid'];
        $browsertype = $voterecords['browsertype'];
        $localrecord = $voterecords['localrecord'];
        $wenick = $voterecords['wenick'];
        $voterecord = $voterecords['voterecord'];
        $voterate = $voterecords['voterate'];
        $votenum = $voterecords['votenum'];
        if($this->voterecord->recordOutOrExist($tipid,$browsertype,$localrecord,$wenick,$voterecord,$voterate,$votenum)){
            return response()->json([
                'status'=>false,
                'message'=>'您已经投过票了!'
            ]);
        }
        $res = $this->voterecord->saveVoterecord($voterecords);
        if($res){
            return response()->json([
                'status'=>true,
                'message'=>'投票成功!'
            ]);
        }
        return response()->json([
            'status'=>false,
            'message'=>'投票失败!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
