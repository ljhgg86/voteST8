<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Chaosky;
use App\Models\Voteitem;
use App\Models\Voterecord;
use App\Models\Votetitle;
use Response;

class ChaoskyController extends Controller
{
    /**
    *Create a new instance.
    */
    public function __construct()
    {
        $this->chaosky=new Chaosky();
        $this->voteitem=new Voteitem();
        $this->voterecord=new Voterecord();
        $this->votetitle=new Votetitle();
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         $chaosky = $this->chaosky->getChaosky($id);
        // if(!empty(json_decode($chaosky,true))){
        if($chaosky){
            return response()->json([
                'status'=>true,
                'message'=>'success',
                'chaosky'=>$chaosky
            ]);
        }
        return response()->json([
            'status'=>false,
            'message'=>'fail',
            'chaosky'=>''
        ]);
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

    /**
     * update readnum
     */
    public function updateReadnum(Request $request){
        $tipid = $request->input('tipid');
        $this->chaosky->where('tipid',$tipid)->increment('readnum');
    }
}
