<?php

namespace app\common;

use app\common\Session;
use app\ciblog\model\User;

class TokenManage
{
    /**
     * 签发app token
     * 
     * @param Int $uid
     * @return String token令牌
     */
    public static function setAppLoginToken($uid)
    {
        $str = md5(microtime(true));
        $str = sha1($uid . $str);
        Session::set('uid', $uid, 18000);
        Session::set('token', $str, 18000);
        return $str;
    }

    public static function checkToken()
    {
        $header = apache_request_headers();
        $uid = $header['uid'];
        $token = $header['token'];
        if (User::get($uid) && Session::get('uid') === (int) $uid && Session::get('token') === $token) {
            return true;
        } else {
            return false;
        }
    }
}