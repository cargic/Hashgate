<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{

            $userInfo = Auth::user();

            return $this->responseSuccess('success',$userInfo);
        }catch (\Exception $e){
            return $this->responseError($e->getMessage());
        }
    }

    /**
     * 更改手机号码
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function modifyPhone(Request $request)
    {
        try{
            $this->validateRequest($request->all(),[
                'old_verify_code_key' => 'required',
                'old_verify_code' => 'required',
                'new_phone' => 'required',
                'new_verify_code_key' => 'required',
                'new_verify_code' => 'required'
            ],[
                '*' => '参数错误.'
            ]);

            $input = $request->input();

            $oldVerifyCode = Redis::get( $input['old_verify_code_key'] );
            if( $input['old_verify_code'] != $oldVerifyCode  ){
                throw new \Exception( '旧手机号码验证失败.' );
            }

            $userInfo = Auth::user();
            if( $userInfo->phone == $input['new_phone'] ){
                throw new \Exception('新旧手机号码不能相同.');
            }

            $newVerifyCode = Redis::get( $input['new_verify_code_key'] );
            if( $input['new_verify_code'] != $newVerifyCode  ){
                throw new \Exception( '新手机号码验证失败.' );
            }

            $userInfo->phone = $input['new_phone'];
            if( !$userInfo->update() ){
                throw new \Exception('手机号码修改失败,请稍后重试.');
            }

            return $this->responseSuccess('success');
        }catch (\Exception $e){
            return $this->responseError($e->getMessage());
        }
    }

    /**
     * 修改用户头像
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function modifyAvatar(Request $request)
    {
        try{
            $user = Auth::user();
            $avatar = $request->file('avatar');
            $user->avatar = $this->uploadImg($avatar, 'AVATAR');

            if(!$user->update())
                throw new \Exception('头像修改失败，请稍后重试');

            return $this->responseSuccess('success');

        }catch (\Exception $e){
            return $this->responseError($e->getMessage());
        }
    }

    /**
     * 绑定和修改邮箱
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function modifyEmail(Request $request)
    {
        try{

            $this->validateRequest($request->all(),[
                'email' => 'required',
            ],[
                '*' => '参数错误'
            ]);

            $input = $request->input();

            // 绑定邮箱
            if( !empty($input['verify_code']) ){
                $verifyCode = Redis::get( $input['verify_code_key'] );
                if( $input['verify_code'] != $verifyCode  ){
                    throw new \Exception( '验证码有误.' );
                }
            }

            // 修改邮箱
            if( !empty($input['new_verify_code']) ){
                $newVerifyCode = Redis::get( $input['new_verify_code_key'] );
                if( $input['new_verify_code'] != $newVerifyCode  ){
                    throw new \Exception( '新邮箱验证码有误.' );
                }
            }

            // 解绑邮箱
            $email = $request->input('email');
            if( !empty($input['remove']) ){
                $email = '';
            }

            $user = Auth::user();
            User::query()->updateOrCreate([
                'id' => $user->id
            ],[
                'email' => $email
            ]);

            return $this->responseSuccess('success');

        }catch (\Exception $e){
            return $this->responseError($e->getMessage());
        }
    }

    /**
     * 设置邮箱通知开关
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function modifyEmailNotify(Request $request)
    {
        try{

            $this->validateRequest($request->all(),[
                'email_notify' => 'required'
            ],[
                '*' => '参数错误'
            ]);

            $user = Auth::user();
            User::query()->updateOrCreate([
                'id' => $user->id
            ],[
                'email_notify' => $request->input('email_notify')
            ]);

            return $this->responseSuccess('success');

        }catch (\Exception $e){
            return $this->responseError($e->getMessage());
        }
    }

    /**
     * 修改账户昵称
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function modifyName(Request $request)
    {
        try{

            $this->validateRequest($request->all(),[
                'name' => 'required'
            ],[
                '*' => '参数错误'
            ]);

            $user = Auth::user();
            User::query()->updateOrCreate([
                'id' => $user->id
            ],[
                'name' => $request->input('name')
            ]);

            return $this->responseSuccess('success');

        }catch (\Exception $e){
            return $this->responseError($e->getMessage());
        }
    }

    /**
     * 修改钱包地址
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function modifyAddress(Request $request)
    {
        try{
            $this->validateRequest($request->all(),[
                'verify_code_key' => 'required',
                'verify_code' => 'required',
                'address' => 'required'
            ],[
                '*' => '参数错误'
            ]);

            $input = $request->input();
            $verifyCode = Redis::get( $input['verify_code_key'] );
            if( $input['verify_code'] != $verifyCode  ){
                throw new \Exception( '验证码有误.' );
            }

            $user = Auth::user();
            User::query()->updateOrCreate([
                'id' => $user->id
            ],[
                'address' => $request->input('address')
            ]);

            return $this->responseSuccess('success');

        }catch (\Exception $e){
            return $this->responseError($e->getMessage());
        }
    }

    /**
     * 修改设置单位电价
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function modifyElectricityPrice(Request $request)
    {
        try{

            $this->validateRequest($request->all(),[
                'electricity_price' => 'required',
            ],[
                '*' => '参数错误'
            ]);

            $user = Auth::user();
            User::query()->updateOrCreate([
                'id' => $user->id
            ],[
                'electricity_price' => $request->input('electricity_price')
            ]);

            return $this->responseSuccess('success');

        }catch (\Exception $e){
            return $this->responseError($e->getMessage());
        }
    }

    /**
     * 修改设置电费损耗
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function modifyElectricityLoss(Request $request)
    {
        try{

            $this->validateRequest($request->all(),[
                'electricity_loss' => 'required',
            ],[
                '*' => '参数错误'
            ]);

            $user = Auth::user();
            User::query()->updateOrCreate([
                'id' => $user->id
            ],[
                'electricity_loss' => $request->input('electricity_loss')
            ]);

            return $this->responseSuccess('success');

        }catch (\Exception $e){
            return $this->responseError($e->getMessage());
        }
    }

}
