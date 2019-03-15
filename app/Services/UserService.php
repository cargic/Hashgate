<?php
/**
 * Created by PhpStorm.
 * User: Mxker
 * Date: 2018/7/30
 * Time: 15:17
 */

namespace App\Services;

use App\Models\User;

class UserService
{
    public function userExists($username)
    {
        if (empty($username)) return false;

        $user = null;
        if (str_contains($username, '@')) {
            $user = User::query()->where('email', $username)->first(['id']);
        } else if (is_numeric($username)) {
            $user = User::query()->where('phone', $username)->first(['id']);
        }

        return !empty($user);
    }
}