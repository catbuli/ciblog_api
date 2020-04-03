<?php

namespace app\index\controller;

use think\Controller;
use app\index\model\Article;
use app\index\model\ArticleMeta;
use app\index\model\Comment;
use think\Exception;
use app\common\Response;
use app\common\Session;
use think\Db;

class Articlec extends Controller
{
    /**
     * 控制器默认方法 获取文章列表
     *
     * @return JSON 返回状态码 报错信息 数据
     */
    public function index($paging)
    {
        try {
            $article = new Article();
            $list = $article->getArticleList($paging);
            foreach ($list["list"] as $value) {
                Db::table('ciblog_article')->where('aid', $value['aid'])->update(['comment_count' => count(Comment::getCommentById($value['aid']))]);
            }
            $list = $article->getArticleList($paging);
            foreach ($list["list"] as &$value) {
                $value['category'] = ArticleMeta::getMetaByArticle($value['aid'], "category", true);
                $value['tag'] = ArticleMeta::getMetaByArticle($value['aid'], "tag", true);
            }
            return Response::result(201, "成功", "数据获取成功!", $list["list"], $list["paging"]);
        } catch (Exception $e) {
            $message = $e->getMessage() . PHP_EOL . $e->getLine() . PHP_EOL . $e->getFile();
            return Response::result(400, "请求失败!", $message);
        }
    }
    /**
     * 发布文章
     *
     * @param object $data 文章内容
     * @return JSON 返回状态码 报错信息 数据
     */
    public function publish($data)
    {
        if (Session::get('uid') == 2) {
            return Response::result(400, "失败", "该账号没有此操作的权限!", []);
        }
        try {
            if ($data['aid']) {
                $article = Article::get(-1);
                if ($article) {
                    if ($article->draft == $data['aid']) {
                        Article::destroy(-1);
                    }
                }
                $article = new Article();
                $article = Article::get($data["aid"]);
                $article->html = $data["html"];
                $article->title = $data["title"];
                $article->text = $data["text"];
                $article->cover_url = $data["cover_url"];
                $article->create_date = $data["create_date"] ? $data["create_date"] : date('Y-m-d H:i:s');
                $article->allow_comment = $data["allow_comment"];
                $article->modify_date = date('Y-m-d H:i:s');
                $article->description = $data['description'];
                $article->status = 0;
                $article->draft = null;
                $article->editArticle();
                ArticleMeta::delAllMetaByArticle($article->aid, "category");
                ArticleMeta::addMetaList($data['categoryList'], $article->aid, "category");
                ArticleMeta::delAllMetaByArticle($article->aid, "tag");
                ArticleMeta::addMetaList($data['tagList'], $article->aid, "tag");
                return Response::result(200, "成功", "文章发布成功!");
            } else {
                $article = Article::get(-1);
                if ($article) {
                    if ($article->draft == -1) {
                        Article::destroy(-1);
                    }
                }
                $article = new Article();
                $article->data([
                    'html' => $data["html"],
                    'title' => $data["title"],
                    'text' => $data["text"],
                    'cover_url' => $data["cover_url"],
                    'create_date' => $data["create_date"] ? $data["create_date"] : date('Y-m-d H:i:s'),
                    'allow_comment' => $data['allow_comment'] == true ? 1 : 0,
                    'author_id' => 1,
                    'status' => 0,
                    'modify_date' => date('Y-m-d H:i:s'),
                    'description' => $data['description'],
                    'draft' => null,
                ]);
                $article->addArticle();
                $aid = $article->getLastInsID();
                foreach ($data['fileList'] as $value) {
                    Db::name('file')
                        ->where('aid', -1)
                        ->update(['aid' => $aid]);
                }
                ArticleMeta::addMetaList($data['categoryList'], $aid, "category");
                ArticleMeta::addMetaList($data['tagList'], $aid, "tag");
                return Response::result(200, "成功", "文章发布成功!");
            }
        } catch (Exception $e) {
            $message = $e->getMessage() . PHP_EOL . $e->getLine() . PHP_EOL . $e->getFile();
            return Response::result(400, "请求失败!", $message);
        }
    }
    /**
     * 删除文章
     *
     * @param array $aid 文章id 或者 文章id数组 
     * @return JSON 返回状态码 报错信息 数据
     */
    public function del($aid)
    {
        if (Session::get('uid') == 2) {
            return Response::result(400, "失败", "该账号没有此操作的权限!", []);
        }
        try {
            foreach ($aid as $value) {
                Article::destroy($value);
                Comment::where("aid", $value)->delete();
            }
            return Response::result(200, "成功", "文章删除成功!");
        } catch (Exception $e) {
            $message = $e->getMessage() . PHP_EOL . $e->getLine() . PHP_EOL . $e->getFile();
            return Response::result(400, "请求失败!", $message);
        }
    }
    /**
     * 获取某种类型标签mid列表
     *
     * @param int $aid 文章id
     * @param string $type 标签类型
     * @return JSON 返回状态码 报错信息 数据
     */
    private function getMetaIdList($aid, $type)
    {
        $list = [];
        foreach (ArticleMeta::getMetaByArticle($aid, $type, false) as $value) {
            array_push($list, $value->mid);
        }
        return $list;
    }
    /**
     * 根据id获取文章内容
     *
     * @param int $aid 文章id
     * @return JSON 返回状态码 报错信息 数据
     */
    public function byid($aid)
    {
        try {
            Db::table('ciblog_article')->where('aid', $aid)->setInc('pv');
            $article = Article::get($aid);
            if ($article) {
                $article->allow_comment = $article->allow_comment == 0 ? false : true;
                $article->tagList = self::getMetaIdList($aid, "tag");
                $article->categoryList = self::getMetaIdList($aid, "category");
                $article->category = ArticleMeta::getMetaByArticle($aid, "category", true);
                $article->tag = ArticleMeta::getMetaByArticle($aid, "tag", true);
                $list = [];
                $list["next"] = Db::name('article')
                    ->where('create_date', '<', $article->create_date)
                    ->where('status', '<', 2)
                    ->order("create_date desc")
                    ->limit(0, 1)
                    ->find();
                $list["present"] = $article;
                $list["previous"] = Db::name('article')
                    ->where('create_date', '>', $article->create_date)
                    ->where('status', '<', 2)
                    ->order("create_date asc")
                    ->limit(0, 1)
                    ->find();
                if ($article->status > 0) {
                    $data = json_decode($article->draft);
                    $data->aid = (int) $aid;
                    $list["present"] = $data;
                }
                return Response::result(201, "成功", "文章信息获取成功!", $list);
            } else {
                return Response::result(404, "失败", "文章没有找到，或已被删除!");
            }
        } catch (Exception $e) {
            $message = $e->getMessage() . PHP_EOL . $e->getLine() . PHP_EOL . $e->getFile();
            return Response::result(400, "请求失败!", $message);
        }
    }
    /**
     * 保存草稿功能
     *
     * @param JSON $data 保存草稿的文章信息
     * @return void
     */
    public function draft($data)
    {
        if (Session::get('uid') == 2) {
            return Response::result(400, "失败", "该账号没有此操作的权限!", []);
        }
        try {
            $article = new Article();
            if ($data['aid']) {
                $article = Article::get($data['aid']);
                if ($article->status != 2) {
                    $article->status = 1;
                }
                $article->draft = json_encode($data);
                $article->save();
            } else {
                $article->data([
                    'title' => $data["title"],
                    'text' => $data["text"],
                    'cover_url' => $data["cover_url"],
                    'create_date' => date('Y-m-d H:i:s'),
                    'allow_comment' => $data['allow_comment'] == true ? 1 : 0,
                    'author_id' => 1,
                    'status' => 2,
                    'modify_date' => date('Y-m-d H:i:s'),
                    'description' => $data['description'],
                    'draft' => json_encode($data),
                ]);
                $article->save();
            }
            $article->categoryList = $data['categoryList'];
            $article->tagList = $data['tagList'];
            $list["present"] = $article;
            return Response::result(200, "成功", "草稿保存成功!", $list);
        } catch (Exception $e) {
            $message = $e->getMessage() . PHP_EOL . $e->getLine() . PHP_EOL . $e->getFile();
            return Response::result(400, "请求失败!", $message);
        }
    }
    /**
     * 归档数据
     *
     * @param JSON $data 保存草稿的文章信息
     * @return void
     */
    public function log()
    {
        try {
            $list = Db::name("article")->order('create_date asc')
                ->field('create_date')
                ->select();
            $monthList = [];
            foreach ($list as &$item) {
                // var_dump($item);
                array_unshift($monthList, date("Y-m", strtotime($item['create_date'])));
            }
            $monthList = array_values(array_unique($monthList));
            $timeline = [];
            foreach ($monthList as $item) {
                $list = array("date" => $item);
                $date = $item;
                $maxDate = date("Y-m", strtotime("+1 month", strtotime($date)));
                // $maxDate = $paging['typeName'] . "-" . ((int) $paging['type'] + 1);
                $articleList = Db::name("article")
                    ->order('create_date desc')
                    ->whereTime('create_date', ">", $date)
                    ->whereTime('create_date', "<", $maxDate)
                    ->field('aid,title,create_date')
                    ->select();
                $list["articleList"] = $articleList;
                array_push($timeline, $list);
            }
            return Response::result(201, "成功", "数据获取成功!", $timeline);
        } catch (Exception $e) {
            $message = $e->getMessage() . PHP_EOL . $e->getLine() . PHP_EOL . $e->getFile();
            return Response::result(400, "请求失败!", $message);
        }
    }
}