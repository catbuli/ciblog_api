<?php

namespace app\ciblog\model;

use think\Model;
use think\Db;


class User extends Model
{
    protected $pk = "uid";
    public function getUserById($id)
    {
        return User::get($id);
    }
    public static function login($name, $password)
    {
        return User::get(['name' => $name, 'password' => $password]);
    }
    public static function editPassword($uid, $password)
    {
        $user = new User;
        // save方法第二个参数为更新条件
        return $user->save([
            'password'  => $password,
        ], ['uid' => $uid]);;
    }
}