<?php

namespace app\index\controller;

use think\Controller;
use app\index\model\User;
use think\Exception;
use app\common\TokenManage;
use app\common\Session;
use app\common\Response;

class Login extends Controller
{
    /**
     * 控制器默认方法  后台登陆
     *
     * @param String $name 用户名
     * @param String $password 密码
     * @return JSON $message 返回的json信息
     */
    public function index($name, $password)
    {
        try {
            $data =  User::login($name, md5($password));
            if ($data) {
                return Response::result(200, "欢迎", "管理员-" . $data->nickname, [
                    'uid' => $data->uid,
                    'name' => $data->nickname,
                    'token' => TokenManage::setAppLoginToken($data->uid),
                ]);
            } else {
                return Response::result(400, "错误", "账号或密码错误");
            }
        } catch (Exception $e) {
            return Response::result(400, "请求失败", $e->getMessage());
        }
    }
    /**
     * 注销登陆
     *
     * @return JSON $message 返回的json信息
     */
    public function logout()
    {
        try {
            Session::clear('uid');
            Session::clear('token');
            return Response::result(200, "成功", "注销成功");
        } catch (Exception $e) {
            return Response::result(400, "请求失败", $e->getMessage());
        }
    }
    /**
     * 修改密码
     *
     * @param string $password 密码
     * @param string $repassword 重复密码
     * @return JSON
     */
    public function alterpass($password, $repassword)
    {
        if (Session::get('uid') == 2) {
            return Response::result(400, "失败", "该账号没有此操作的权限!", []);
        }
        try {
            if (TokenManage::checkToken()) {
                if ($password == $repassword) {
                    User::editPassword(Session::get("uid"), md5($password));
                    return Response::result(200, "成功", "修改成功！");
                }
                return Response::result(400, "失败", "修改失败！");
            } else {
                return Response::result(402, "失败", "账号登陆失效！");
            }
        } catch (Exception $e) {
            return Response::result(400, "请求失败", $e->getMessage());
        }
    }

    /**
     * 登陆状态检查
     *
     * @return JSON
     */
    public function check()
    {
        try {
            if (TokenManage::checkToken()) {
                return Response::result(201, "成功", "当前已登录");
            } else {
                return Response::result(402, "登录失效", "请重新登陆");
            }
        } catch (Exception $e) {
            return Response::result(400, "请求失败", $e->getMessage());
        }
    }
}