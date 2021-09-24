<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Captcha;
use Carbon\Carbon;

class Codeimage extends Model
{
    /**
     * 生成验证码图片
     *
     * @return void
     */
    public function codeImage(){
        $captcha = Captcha::create('default', true);
        $attr = \preg_split("/(,|;)/", $captcha['img']);//分解编码头部、内容
        //$name = intval(Carbon::now()->getPreciseTimestamp(3));//取毫秒级时间戳作为图片名
        $name = md5($captcha['key']);
        Storage::disk("codeImages")->put($name.'.png',base64_decode($attr[2]));
        return $captcha['key'];
    }

    /**
     * 验证收到的验证码
     */
    public function validateCode($value, $key){
        $res = captcha_api_check($value, $key);
        if($res){
            Storage::disk("codeImages")->delete(md5($key).'.png');
        }
        return $res;
    }
}
