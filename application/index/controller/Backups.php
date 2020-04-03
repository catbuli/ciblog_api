<?php

namespace app\index\controller;

use think\Controller;
use think\Exception;
use app\common\Response;
use think\Db;

class Backups extends Controller
{
    /**
     * 控制器默认方法 备份
     *
     * @return JSON
     */
    public function index()
    {
        try {
            $cmd = 'sudo pwd';
            exec($cmd, $result, $var);
            var_dump($result);
            var_dump($var);
            // return Response::result(201, "成功", "数据获取成功!", $a);
        } catch (Exception $e) {
            $message = $e->getMessage() . PHP_EOL . $e->getLine() . PHP_EOL . $e->getFile();
            return Response::result(400, "请求失败!", $message);
        }
    }
}
