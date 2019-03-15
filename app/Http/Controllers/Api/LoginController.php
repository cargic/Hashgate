<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\MailService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;
use Mrgoon\AliSms\AliSms;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    public function index(Request $request, UserService $userService)
    {
        try {

            $this->validateRequest($request->input(),[
                'phone' => 'required',
                'verify_code_key' => 'required',
                'verify_code' => 'required'
            ],[
                '*' => '参数错误.'
            ]);

            $phone = $request->input('phone');
            if ( !$userService->userExists($phone) ) {
                $this->register($phone);
            }

            $user = User::query()->where('phone',$phone)->first();

            $loginVerifyCode = Redis::get( $request->input('verify_code_key') );
            if( empty($loginVerifyCode) ){
                throw new \Exception('验证码已失效.');
            }

            if( $request->input('verify_code') != $loginVerifyCode ){
                throw new \Exception('验证码有误.');
            }

            $token =  $user->createToken('Hashgate')->accessToken;

            if( empty($user->avatar) ){
                $user->avatar = env('STATIC_DOMAIN') . '/storage/photo/default_avatar.png';
            }

            // 登录时间更新，用户数据统计使用
            User::query()->where('id','=',$user->id)->update([
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

            return $this->responseSuccess('登录成功.',null,[
                'name' => $user->name,
                'username' => hide_special_string($phone),
                'token' => $token,
                'avatar' => $user->avatar
            ]);

        } catch (\Exception $e) {

            return $this->responseError($e->getMessage());
        }
    }


    /**
     * 快捷注册
     *
     * @param $phone
     * @return bool
     * @throws \Exception
     */
    protected function register( $phone )
    {
        try{
            User::query()->create([
                'phone' => $phone
            ]);

            return true;
        }catch ( \Exception $e ){
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * 发送短信验证码（登录 和 修改手机号）
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function sendVerifyCode(Request $request)
    {
        try{
            $phone = $request->input('phone');
            switch ($request->input('type')){
                case 1:
                    $type = 'Login';
                    break;
                case 2:
                    $type = 'Reset';
                    break;
                case 3:
                    $type = 'ModifyAddress';
                    break;
                default:
                    $type = 'Login';
            }

            $verifyCode = $this->createVerify();
            $key = $type.'VerifyCode-'.$phone;
            Redis::setex($key, 300, $verifyCode);

//            $aliSms = new AliSms();
//            $response = $aliSms->sendSms($phone, 'SMS_117513195', ['code'=> $verifyCode]);
//            if(!$response)
//                throw new \Exception('短信验证码发送失败，请稍后重试');

            return $this->responseSuccess('短信验证码发送成功', ['verifyCodeKey'=>$key] );

        }catch (\Exception $e){
            return $this->responseError($e->getMessage());
        }
    }

    /**
     * 发送邮箱验证码
     *
     * @param Request $request
     * @param MailService $mailService
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function mailVerifyCode(Request $request, MailService $mailService)
    {
        try{
            $email = $request->input('email');
            if(empty($email)){
                throw new \Exception('邮箱不能为空');
            }

            $user = User::query()->where('email', $email)->first();
            if (!empty($user)) {
                throw new \Exception('该邮箱已被占用，请重新填写');
            }

            $mailCode = $this->createVerify();
            $mailKey = 'EmailVerifyCode_'.$mailCode.time();
            Redis::setex($mailKey, 600, $mailCode);
            $content = '您申请绑定的邮箱验证码为：'.$mailCode.'，请在3分钟之内前往填写绑定。谢谢合作。';
            //$mailService->sendTo($email, '邮箱验证码', $content);

            return $this->responseSuccess('验证码发送成功，请前往查看',null,['emailCodeKey' => $mailKey ]);

        }catch (\Exception $e){

            return $this->responseError($e->getMessage());
        }
    }
}
