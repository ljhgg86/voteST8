<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Codeimage;
use Illuminate\Support\Facades\Storage;

class CodeimgController extends Controller
{
    /**
    *Create a new instance.
    */
    public function __construct()
    {
        $this->codeimage = new Codeimage();
    }
    /**
     * 生成验证码图片
     *
     * @return void
     */
    public function codeImage(){
        $key = $this->codeimage->codeImage();
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => [
                'key' => $key,
                'codeImage' => env('CODE_IMAGE_URL').md5($key).'.png',
                //'codeImage' => Storage::disk("codeImages")->url(md5($key).'.png')
            ]
        ]);
    }

    /**
     * 验证收到的验证码
     */
    public function validateCode(Request $request){
        $value = $request->input("value");
        $key = $request->input("key");
        $result = $this->codeimage->validateCode($value, $key);
        if($result){
            return response()->json([
                'status' => true,
                'message' => 'success',
                'data' => ''
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'fail',
            'data' => ''
        ]);
    }
}
