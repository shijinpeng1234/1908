<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Admin;


use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
class LoginController extends Controller
{
    public function logindo(Request $request){
        $user=$request->except('_token');
        // dd($user);
        $user['u_pwd']=md5(md5($user['u_pwd']));
        $admin=Admin::where($user)->first();
        // dd($admin);
        if($admin){
            //讲此用户存入session
            session(['adminuser'=>$admin]);
            $request->session()->save();

            return redirect('article');
        }
        return redirect('/login')->with('msg','没有此用户');

    }
    //发送短信
    public function ajaxsend()
    {
        //接收注册页面的手机号
        // $moblie='17636021531';
        $moblie=request()->u_tel;
        // echo $moblie;die;
        $code=rand(100000,999999);
        // echo $code;die;
        $res=$this->sendSms($moblie,$code);
        if( $res['Code']=='OK'){
            session(['code'=>$code]);
            request()->session()->save();
            echo json_encode(['code'=>'00000','msg'=>'ok']);die;
        }
        echo json_encode(['code'=>'00001','msg'=>'短信发送失败']);die;
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
}