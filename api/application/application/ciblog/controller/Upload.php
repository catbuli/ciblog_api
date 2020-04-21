<?php

namespace app\ciblog\controller;

use think\Controller;
use app\common\Response;
use app\common\Session;
use think\Exception;
use app\ciblog\model\File;
use think\facade\Env;

class Upload extends Controller
{
    /**
     * 文件上传默认控制器 获取文件列表
     *
     * @param JSON $paging 分页信息
     * @return JSON 
     */
    public function index($paging)
    {
        try {
            $file = new File();
            $fileList = $file->getList($paging);
            $paging['total'] = File::Count($paging['typeName'], $paging['type']);
            return Response::result(201, "成功!", "文件列表获取成功!", $fileList, $paging);
        } catch (Exception $e) {
            $message = $e->getMessage() . PHP_EOL . $e->getLine() . PHP_EOL . $e->getFile();
            return Response::result(400, "请求失败!", $message);
        }
    }
    /**
     * 上传文件
     *
     * @param integer $aid 文章id 
     * @return JSON
     */
    public function add($aid = -1)
    {
        if (Session::get('uid') == 2) {
            return Response::result(400, "失败", "该账号没有此操作的权限!", []);
        }
        try {
            $files = request()->file();
            if (empty($files)) {
                return Response::result(400, "失败!", "请上传文件!");
            }
            // var_dump($files);
            foreach ($files as $file) {
                // 移动到框架应用根目录/public/uploads/ 目录下, 'ext' => 'jpg,png,gif'
                $file->validate(['size' => 1100000]);
                $uploads_path = Env::get('ROOT_PATH') . 'public' . DIRECTORY_SEPARATOR . 'uploads';
                $info = $file->move($uploads_path);
                if ($info) {
                    $file = new File();
                    $file->name = $info->getInfo()["name"];
                    $file->type = $info->getInfo()["type"];
                    $file->size = $info->getInfo()["size"];
                    $file->datetime = date('Y-m-d H:i:s');
                    $file->aid = $aid;
                    if ($aid == -1) {
                        $file->status = 1;
                    } else if ($aid == -2) {
                        $file->status = 2;
                    } else {
                        $file->status = 0;
                    }
                    $file->path = str_replace("\\", "/", $info->getSavename());
                    $file->url = 'http://' . $_SERVER['SERVER_NAME'] . "/api/public/uploads/" . str_replace("\\", "/", $info->getSavename());
                    $file->save();
                    $fileList = $file->getList(['typeName' => 'id', 'type' => $aid]);
                } else {
                    return Response::result(400, "失败!", $file->getError());
                }
            }
            return Response::result(201, "成功!", "上传成功!", ['file' => $file, 'fileList' => $fileList]);
        } catch (Exception $e) {
            $message = $e->getMessage() . PHP_EOL . $e->getLine() . PHP_EOL . $e->getFile();
            return Response::result(400, "请求失败!", $message);
        }
    }
    /**
     * 文件删除接口
     *
     * @param int $fid 文件id数组
     * @return JSON
     */
    public function del($fid)
    {
        if (Session::get('uid') == 2) {
            return Response::result(400, "失败", "该账号没有此操作的权限!", []);
        }
        try {
            foreach ($fid as $value) {
                $filename = str_replace("\\", "/", Env::get('ROOT_PATH') . 'public' . DIRECTORY_SEPARATOR . 'uploads/' . File::get($value)->path);
                File::destroy($value);
                if (file_exists($filename)) {
                    unlink($filename);
                    $info = Response::result(200, "成功!", "文件删除成功!");
                } else {
                    return Response::result(400, "成功!", "某个文件删除失败，请前往服务器目录清理!");
                }
            }
            return $info;
        } catch (Exception $e) {
            $message = $e->getMessage() . PHP_EOL . $e->getLine() . PHP_EOL . $e->getFile();
            return Response::result(400, "请求失败!", $message);
        }
    }
}