<?php

namespace App\Http\Controllers\Index;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use App\Goods;
use App\Admin;
use App\Brand;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
class IndexController extends Controller
{
    //前台首页
    public function index()
    {
        // Cache::flush();
        // $aa=Cache::get('aa');
        // if(!$aa){
            $aa=Goods::leftjoin('brand','goods.b_id','=','brand.b_id')->get();
            // dd($aa);
            // Cache::put('aa',$aa,60*60*24);
        // }
        return view('index/index',['aa'=>$aa]);
        //第一种获取
        // echo request()->cookie('name');die;
    }
    //执行登录
    public function logindo(Request $request)
    {
        $data=$request->except('_token');
        $where=[
            ['u_name','=',$data['u_name']],
            ['u_pwd','=',$data['u_pwd']],
        ];
        $res=Admin::where($where)->first();
        if($res){
            return redirect('/');
        }else{
            return redirect('/login');
        }
    }
    //执行注册
    public function regdo()
    {
        $data=request()->except('_token');
        $code=session('code');
        //判断验证码
        if($code!=$data['code']){
            return redirect('/reg')->with('msg','验证码错误');
        }
        //判断两次密码
        if($data['u_pwd']!=$data['u_pwds']){
            return redirect('/reg')->with('msg','两次密码不一致');
        }
        //入库
        $user=[
           'u_tel'=>$data['u_tel'],
           'u_pwd'=>$data['u_pwd'],
        ];
        $res=Admin::create($user);
        if($res){
            return redirect('/login');
        }
    }
    //发送短信
    public function ajaxsend()
    {
        //接收注册页面的手机号
        $moblie='17636021531';
        // $moblie=request()->g_tel;
        $code=rand(100000,999999);
        $res=$this->sendSms($moblie,$code);
        if( $res['Code']=='OK'){
            session(['code'=>$code]);
            request()->session()->save();
            echo "发送成功";
        }
    }
    //发送验证码
    public function sendSms($moblie,$code)
    {
        AlibabaCloud::accessKeyClient('LTAI4Fx671vEewVZA9gobN9g', 'MtWumZqkrQeKrVTdrw0FiMEakDaA1N')
                                ->regionId('cn-hangzhou')
                                ->asDefaultClient();

        try {
            $result = AlibabaCloud::rpc()
                                  ->product('Dysmsapi')
                                  // ->scheme('https') // https | http
                                  ->version('2017-05-25')
                                  ->action('SendSms')
                                  ->method('POST')
                                  ->host('dysmsapi.aliyuncs.com')
                                  ->options([
                                                'query' => [
                                                  'RegionId' => "cn-hangzhou",
                                                  'PhoneNumbers' => $moblie,
                                                  'SignName' => "一品学堂",
                                                  'TemplateCode' => "SMS_184110102",
                                                  'TemplateParam' => "{code:$code}",
                                                ],
                                            ])
                                      ->request();
                return $result->toArray();
            } catch (ClientException $e) {
                return $e->getErrorMessage();
            } catch (ServerException $e) {
                return $e->getErrorMessage();
            }
    }
    //cookie
    public function setCookie()
    {
        //第一种
        // return response('cookie测试')->cookie('name','12331',2);
    }
    //商品详情
    public function proinfo($id)
    {
        $count=Redis::setnx('num_'.$id,1);

        if(!$count){
            $count=Redis::incr('num_'.$id);
            // dd($count);
        }
        $info=Cache::get('info');
        if(!$info){
            $info=Goods::find($id);
            // dd($info);
            Cache::put('info',$info,60*60);
        }

        return view('index/proinfo',['info'=>$info,'count'=>$count]);
    }
    //商品列表
    public function prolist()
    {
        phpinfo();
    }
}
