<?php

namespace app\index\controller;

use think\Controller;
use think\Exception;
use app\common\Response;
use think\Config;
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
        header('content-type:text/html;charset=utf8');
        try {
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
                    // // header('location: //' . $_SERVER['HTTP_HOST'] . '/api/public/backups/' . $name);
                    // // exit();
                    // // header('location:http://' . $_SERVER['HTTP_HOST'] . $file_path.);
                    // // 打开文件
                    // $open_file = fopen($file_path, "r");
                    // //输入文件标签
                    // header("Content-type: application/octet-stream");
                    // header("Accept-Ranges: bytes");
                    // header("Accept-Length: " . filesize($file_path));
                    // header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
                    // // // 清除缓存
                    // // // ob_clean();
                    // // // flush();
                    // // // 输出文件内容
                    // echo fread($open_file, filesize($file_path));
                    // // // readfile($file_path);
                    // // 关闭文件
                    // fclose($open_file);
                    // exit();
                    // // // return Response::result(201, "备份成功！");
                }
                return Response::result(200, "备份成功！", $_SERVER['HTTP_HOST'] . '/api/public/backups/' . $name);
            } else {
                return Response::result(400, "备份失败！", $mess);
            }
        } catch (Exception $e) {
            $message = $e->getMessage() . PHP_EOL . $e->getLine() . PHP_EOL . $e->getFile();
            return Response::result(400, "请求失败!", $message);
        }
    }
}