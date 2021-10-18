<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

use App\Models\Chaosky;
use App\Models\Voteitem;
use App\Models\Voterecord;
use App\Models\Votetitle;
use App\Models\Codeimage;
use Captcha;
use Carbon\Carbon;

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
        $this->codeimage = new Codeimage();
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
         $key = $this->codeimage->codeImage();
        // if(!empty(json_decode($chaosky,true))){
        if($chaosky){
            return response()->json([
                'status'=>true,
                'message'=>'success',
                'chaosky'=>$chaosky,
                'codeimage'=>[
                    'key' => $key,
                    'codeImage' => Storage::disk("codeImages")->url(md5($key).'.png')
                ]
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

    /**
     * 生成验证码图片
     *
     * @return void
     */
    public function codeImage(){
        $captcha = Captcha::create('default', true);
        $attr = \preg_split("/(,|;)/", $captcha['img']);//分解编码头部、内容
        $name = intval(Carbon::now()->getPreciseTimestamp(3));//取毫秒级时间戳作为图片名
        Storage::disk("codeImages")->put($name.'.png',base64_decode($attr[2]));
        dd($captcha);
        
    }

    /**
     * 验证收到的验证码
     */
    public function validateCode(Request $request){
        $value = $request->input("value");
        $key = $request->input("key");
        //$res = Captcha::check_api($value, $key);
        $res = captcha_api_check($value, $key);
        dd($res);
    }
}
