<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone', 'email', 'email_notify', 'password','address','electricity_price','electricity_loss'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','deleted_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * 配合passport做API登录方式的切换（邮箱或手机）
     *
     * @param $username
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function findForPassport($username)
    {
        $param = match_email_phone($username);

        return User::query()->where($param, $username)->first();
    }

    /**
     * passport 验证密码
     *
     * @param $password
     * @return bool
     */
    public function validateForPassportPasswordGrant($password)
    {
        $isWeChat = request()->input('wechat');
        if( isset($isWeChat) && $isWeChat == 1 ){
            return $this->access_token == $password;
        }else{
            return Hash::check($password, $this->password);
        }
    }
}
