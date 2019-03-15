<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 数据验证
     *
     * @param array $data
     * @param array $rules
     * @param array $message
     * @throws \Exception
     */
    public function validateRequest(array $data = [], array $rules = [], array $message = [])
    {
        $validator = validator($data, $rules, $message);

        if ($validator->fails()) {
            throw new \Exception($validator->messages()->first());
        }
    }

    /**
     * 成功响应
     *
     * @param string $message
     * @param null $data
     * @param array $extraData
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function responseSuccess($message = 'success', $data = null, $extraData = [])
    {
        $response = [
                'status' => Response::HTTP_OK,
                'message' => $message,
                'data' => $data
            ] + $extraData;

        return response($response);
    }

    /**
     * 错误响应
     *
     * @param null $message
     * @param null $code
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function responseError($message = null, $code = null)
    {
        $response = [
            'status' => empty($code) ? Response::HTTP_BAD_REQUEST : $code,
            'message' => !empty($message) ? $message : 'Unknown Error',
        ];

        return response($response);
    }

    /**
     * 生成验证码
     *
     * @return int
     */
    public function createVerify()
    {
        $verify = rand(100000, 999999);
        return $verify;
    }

    /**
     * 上传图片
     *
     * @param $img
     * @param null $type
     * @return bool|string
     */
    public function uploadImg($img, $type = null)
    {
        $name = $img->getClientOriginalName();//得到图片名；img
        $ext = $img->getClientOriginalExtension();//得到图片后缀；
        $fileName = md5(uniqid($name));
        $fileName = $fileName . '.' . $ext;//生成新的的文件名

        if($type == 'AVATAR'){
            $directory = 'user';
        } else if( $type == 'AD' ){
            $directory = 'ads';
        }else if( $type == 'GOODS' ){
            $directory = 'goods';
        }else{
            $directory = 'icon';
        }

        $bool = Storage::disk($directory)->put($fileName, file_get_contents($img->getRealPath()));
        if (!$bool){
            return false;
        }

        return env('STATIC_DOMAIN') . '/storage/photo/'. $directory .'/' . $fileName;
    }
}
