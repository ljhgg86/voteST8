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
        $res = $this->voterecord->saveVoterecord($request->input('voterecords');)
        if($res){
            return response()->json([
                'status'=>true,
                'message'=>'success'
            ]);
        }
        return response()->json([
            'status'=>false,
            'message'=>'fail'
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
