<?php

namespace app\ciblog\controller;

use think\Controller;
use app\ciblog\model\Meta;
use app\ciblog\model\Article;
use app\ciblog\model\ArticleMeta;
use think\Exception;
use app\common\Response;
use app\common\Session;
use think\Db;

class Category extends Controller
{
    /**
     * 控制器默认方法获取分类列表
     *
     * @return JSON
     */
    public function index()
    {
        try {
            $meta = new Meta();
            $meta = $meta->getMetaList('category');
            foreach ($meta as &$value) {
                $value["count"] = Article::count("category", $value['mid']);
            }
            return Response::result(201, "成功", "分类列表获取成功!", $meta);
        } catch (Exception $e) {
            $message = $e->getMessage() . PHP_EOL . $e->getLine() . PHP_EOL . $e->getFile();
            return Response::result(400, "请求失败!", $message);
        }
    }
    /**
     * 添加分类
     *
     * @param string $name 分类名
     * @param string $description 分类描述
     * @return JSON
     */
    public function add($name, $description)
    {
        if (Session::get('uid') == 2) {
            return Response::result(400, "失败", "该账号没有此操作的权限!", []);
        }
        try {
            if (Meta::get(['name' => $name, 'type' => 'category'])) {
                return Response::result(400, "失败", "已存在同名分类!");
            } else {
                $meta = new Meta();
                $meta->data([
                    'name'  =>  $name,
                    'description' =>  $description,
                    'type' => 'category'
                ]);
                $meta->save();
                return Response::result(200, "成功", "分类添加成功!");
            }
        } catch (Exception $e) {
            $message = $e->getMessage() . PHP_EOL . $e->getLine() . PHP_EOL . $e->getFile();
            return Response::result(400, "请求失败!", $message);
        }
    }
    /**
     * 删除分类
     *
     * @param int $mid 分类mid
     * @return 响应信息
     */
    public function del($mid)
    {
        if (Session::get('uid') == 2) {
            return Response::result(400, "失败", "该账号没有此操作的权限!", []);
        }
        try {
            if (Meta::count("category") <= count($mid)) {
                return Response::result(400, "失败", "不允许删除全部分类，至少保留一个");
            }
            foreach ($mid as $value) {
                $list = Db::name('article_meta')->where("mid", $value)->where("type", "category")->select();
                foreach ($list as $item) {
                    Article::destroy($item['aid']);
                }
                Meta::destroy($value);
                ArticleMeta::delMetaByArticle($value);
            }
            return Response::result(200, "成功", "分类删除成功!");
        } catch (Exception $e) {
            $message = $e->getMessage() . PHP_EOL . $e->getLine() . PHP_EOL . $e->getFile();
            return Response::result(400, "请求失败!", $message);
        }
    }
    /**
     * 修改分类
     *
     * @param int $category 分类信息
     * @return 响应信息
     */
    public function edit($category)
    {
        if (Session::get('uid') == 2) {
            return Response::result(400, "失败", "该账号没有此操作的权限!", []);
        }
        try {
            $meta  = Meta::get($category['mid']);
            $meta->name = $category['name'];
            $meta->description = $category['description'];
            $meta->save();
            return Response::result(200, "成功", "分类修改成功!");
        } catch (Exception $e) {
            $message = $e->getMessage() . PHP_EOL . $e->getLine() . PHP_EOL . $e->getFile();
            return Response::result(400, "请求失败!", $message);
        }
    }
    /**
     * 根据文章aid获取分类列表
     *
     * @param int $aid 文章aid
     * @return 响应信息
     */
    public function byid($aid)
    {
        try {
            $list = ArticleMeta::getMetaByArticle($aid, "category", true);
            return Response::result(201, "成功", "分类信息获取成功!", $list);
        } catch (Exception $e) {
            $message = $e->getMessage() . PHP_EOL . $e->getLine() . PHP_EOL . $e->getFile();
            return Response::result(400, "请求失败!", $message);
        }
    }
    /**
     * 根据标签mid获取分类信息
     *
     * @param int $mid mateID
     * @return 响应信息
     */
    public function bymid($mid)
    {
        try {
            $data = Meta::get($mid);
            return Response::result(201, "成功", "数据获取成功!", $data);
        } catch (Exception $e) {
            $message = $e->getMessage() . PHP_EOL . $e->getLine() . PHP_EOL . $e->getFile();
            return Response::result(400, "请求失败!", $message);
        }
    }
}
