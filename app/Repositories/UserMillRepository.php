<?php
/**
 * Created by PhpStorm.
 * User: Mxker
 * Date: 2019/3/14
 * Time: 18:34
 */

namespace App\Repositories;


use App\Models\UserMill;

class UserMillRepository
{
    /**
     * 创建或者更新矿机
     *
     * @param $data
     * @return bool
     * @throws \Exception
     */
    public function createAndUpdateUserMill( $data )
    {
        try{

            if( !isset($data['user_mill_id']) ){
                $userMillId = 0;
            }else{
                $userMillId = $data['user_mill_id'];
            }

            UserMill::query()->updateOrCreate([
                'id' => $userMillId
            ],[
                'user_id'       =>      $data['user_id'],
                'mill_number'   =>      $data['mill_number'],
                'vga_type'      =>      $data['vga_type'],
                'vga_number'    =>      $data['vga_number'],
                'ip'            =>      $data['ip'],
                'power'         =>      $data['power'],
                'status'        =>      $data['status'],
                'remark'        =>      $data['remark'],
            ]);

            return true;
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
}