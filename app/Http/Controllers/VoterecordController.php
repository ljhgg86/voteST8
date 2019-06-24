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
    public function store(Request $request)
    {
        //$res = $this->voterecord->create($request->all());
       $voterecords = $request->all();
        $tipid = $voterecords['tipid'];
        $browsertype = $voterecords['browsertype'];
        $localrecord = $voterecords['localrecord'];
        $wenick = $voterecords['wenick'];
        if($this->voterecord->recordExist($tipid,$browsertype,$localrecord,$wenick)){
            return response()->json([
                'status'=>false,
                'message'=>'您已经投过票了!'
            ]);
        }
        $res = $this->voterecord->saveVoterecord($voterecords);
        if($res){
            return response()->json([
                'status'=>true,
                'message'=>'Vote success!'
            ]);
        }
        return response()->json([
            'status'=>false,
            'message'=>'Vote fail!'
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
