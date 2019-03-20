<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\UserMill;
use App\Repositories\UserMillRepository;
use App\Transformers\UserMillTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserMillController extends Controller
{

    public function mills(Request $request)
    {
        try{
            $user = Auth::user();
            $groupId = $request->input('group_id');
            $keywords = $request->input('keywords');
            if( !isset($groupId) ){
                if( isset($keywords) ){
                    $millList = UserMill::query()
                        ->where([
                            ['user_id', '=', $user->id],
                            ['mill_number', 'like', '%'.$keywords.'%']
                        ])
                        ->orWhere([
                            ['user_id', '=', $user->id],
                            ['ip', 'like', '%'.$keywords.'%']
                        ])->latest()->paginate(10);
                }else{
                    $millList = UserMill::query()
                        ->where('user_id',$user->id)
                        ->latest()
                        ->paginate(10);
                }
            }else{
                if( isset($keywords) ){
                    $millList = UserMill::query()
                        ->where([
                            ['user_id', '=', $user->id],
                            ['mill_group_id', '=', $groupId],
                            ['mill_number', 'like', '%'.$keywords.'%']
                        ])
                        ->orWhere([
                            ['user_id', '=', $user->id],
                            ['mill_group_id', '=', $groupId],
                            ['ip', 'like', '%'.$keywords.'%']
                        ])->latest()->paginate(10);
                }else{
                    $millList = UserMill::query()
                        ->where('user_id',$user->id)
                        ->where('mill_group_id', $groupId)
                        ->latest()
                        ->paginate(10);
                }
            }

            $millList = fractal($millList, new UserMillTransformer());
            return $this->responseSuccess('success',$millList);
        }catch (\Exception $e){
            return $this->responseError($e->getMessage());
        }

    }

    /**
     * 添加矿机
     *
     * @param Request $request
     * @param UserMillRepository $userMillRepository
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function createMill(Request $request, UserMillRepository $userMillRepository)
    {
        try{
            $this->validateRequest($request->input(),[
                'mill_number' => 'required',
                'vga_type' => 'required',
                'vga_number' => 'required',
                'ip' => 'required',
                'power' => 'required',
                'status' => 'required'
            ],[
                '*' => '参数有误'
            ]);

            $input = $request->input();
            $user = Auth::user();
            $input['user_id'] = $user->id;

            $result = $userMillRepository->createAndUpdateUserMill($input);
            if( !$result ){
                throw new \Exception('未知错误,稍后重试');
            }

            return $this->responseSuccess('success');
        }catch (\Exception $e){
            return $this->responseError($e->getMessage());
        }

    }

    /**
     * 修改矿机
     *
     * @param Request $request
     * @param UserMillRepository $userMillRepository
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function modifyMill(Request $request, UserMillRepository $userMillRepository)
    {
        try{
            $this->validateRequest($request->input(),[
                'user_mill_id' => 'required',
                'mill_number' => 'required',
                'vga_type' => 'required',
                'vga_number' => 'required',
                'ip' => 'required',
                'power' => 'required',
                'status' => 'required'
            ],[
                '*' => '参数有误'
            ]);

            $input = $request->input();
            $user = Auth::user();
            $input['user_id'] = $user->id;

            $result = $userMillRepository->createAndUpdateUserMill($input);
            if( !$result ){
                throw new \Exception('未知错误,稍后重试');
            }

            return $this->responseSuccess('success');
        }catch (\Exception $e){
            return $this->responseError($e->getMessage());
        }

    }
}
