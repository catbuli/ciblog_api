<?php

namespace app\ciblog\controller;

use think\Controller;
use think\Exception;
use app\common\Response;
use app\common\Session;
use app\common\TokenManage;
use think\facade\Config;
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
        if (Session::get('uid') == 2) {
            return Response::result(400, "失败", "该账号没有此操作的权限!", []);
        }
        try {
            if (TokenManage::checkToken()) {
                $doc_root = $_SERVER['DOCUMENT_ROOT'];
                $file_path_name = $doc_root . '/api/public/backups'; //保存到的路径
                $name = 'backup_' . date('YmdHis') . ".sql";
                if (!file_exists($file_path_name)) {
                    mkdir($file_path_name, 0777);
                }
                $mysqldump_url = PHP_OS == 'Linux' ? 'mysqldump' : 'C:\wamp64\bin\mariadb\mariadb10.4.10\bin\mysqldump.exe'; //mysqldump.exe的绝对路径，安装mysql自带的有，可以搜索一下路径
                $hostname = Config::get('database.hostname'); //数据库所在的服务器地址
                $username = Config::get('database.username'); //数据库用户名
                $password = Config::get('database.password'); //数据库密码
                $database = Config::get('database.database'); //数据库名
                $process = $mysqldump_url . " -h" . $hostname . " -u" . $username . "  -p" . $password . "  " . $database . " > " . $file_path_name . "/" . $name;
                system($process, $mess); //system()执行外部程序，并且显示输出
                if ($mess <= 0) {
                    $file_path = $file_path_name . "/" . $name;
                    if (file_exists($file_path)) {
                        // $download =  new \think\response\Download($file_path);
                        return Response::result(201, "备份成功！", $_SERVER['HTTP_HOST'] . '/api/public/backups/' . $name);
                    }
                } else {
                    return Response::result(400, "备份失败！", $mess);
                }
            } else {
                return Response::result(402, "失败", "账号登陆失效！");
            }
        } catch (Exception $e) {
            $message = $e->getMessage() . PHP_EOL . $e->getLine() . PHP_EOL . $e->getFile();
            return Response::result(400, "请求失败!", $message);
        }
    }
}