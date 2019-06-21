<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Chaocomment;
use Response;

class ChaocommentController extends Controller
{
    /**
    *Create a new instance.
    */
    public function __construct()
    {
        $this->chaocomment=new Chaocomment();
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
        $res = $this->chaocomment->create($request->all());
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

    /**
     * return comments of counts from startid
     *
     * @param int $tipid
     * @param int $startid
     * @param int $counts
     * @return Response json
     */
    public function getComments($tipid,$startid,$counts){
        $comments = $this->chaocomment->getComments($tipid,$startid,$counts);
        if(!empty(json_decode($comments,true))){
            return response()->json([
                'status'=>true,
                'message'=>'success',
                'comments'=>$comments
            ]);
        }
        return response()->json([
            'status'=>false,
            'message'=>'fail',
            'comments'=>''
        ]);
    }
}
