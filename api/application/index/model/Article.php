<?php

namespace app\index\model;

use think\Model;
use app\index\model\ArticleMeta;
use think\Db;

class Article extends Model
{
    protected $pk = "aid";
    /**
     * 根据条件返回文章列表
     *
     * @param Array $paging pageSize-每页数量 currentPage-当前页码 type-文章类型value typeName-文章类型名称 total-文章总数
     * @return Array 返回的文章列表
     */
    public function getArticleList($paging)
    {
        //根据分页 typeName type 进行数据获取
        if (!$paging) return [];
        $pagingDate = ($paging['currentPage'] - 1) * $paging['pageSize'];
        switch ($paging['typeName']) {
            case 'all':
                if ($paging['type'] == 0) {
                    $list = $this->order('create_date desc')
                        ->where('status', "<", 2)
                        ->limit($pagingDate, $paging['pageSize'])
                        ->field('aid,title,create_date,pv,comment_count,cover_url,description,status')
                        ->select();
                    $total = $this->where('status', "<", 2)->count();
                    $paging["total"] = $total;
                    return array("list" => $list, "paging" => $paging);
                } else {
                    $list = $this->order('create_date desc')
                        ->limit($pagingDate, $paging['pageSize'])
                        ->field('aid,title,create_date,pv,comment_count,cover_url,description,status,draft')
                        ->select();
                    $total = $this->count();
                    $paging["total"] = $total;
                    return array("list" => $list, "paging" => $paging);
                }
                // 关键字搜索
            case 'keyword':
                $list =  $this->order('create_date desc')
                    ->limit($pagingDate, $paging['pageSize'])
                    ->where('title', 'like', '%' . $paging['type'] . '%')
                    ->whereOr('text', 'like', '%' . $paging['type'] . '%')
                    ->field('aid,title,create_date,pv,comment_count,cover_url,description,status')
                    ->select();
                $total = $this->where('title', 'like', '%' . $paging['type'] . '%')
                    ->whereOr('text', 'like', '%' . $paging['type'] . '%')
                    ->count();
                $paging["total"] = $total;
                return array("list" => $list, "paging" => $paging);
            case 'category':
                $list = Db::name('article_meta')
                    ->where("mid", $paging['type'])
                    ->where("type", "category")
                    ->limit($pagingDate, $paging['pageSize'])
                    ->select();
                $dataList = [];
                foreach ($list as $value) {
                    array_unshift($dataList, Db::name("article")
                        ->where('aid', $value['aid'])
                        ->field('aid,title,create_date,pv,comment_count,cover_url,description,status')
                        ->find());
                }
                $total = Db::name('article_meta')
                    ->where("mid", $paging['type'])
                    ->where("type", "category")
                    ->count();
                $paging["total"] = $total;
                return array("list" => $dataList, "paging" => $paging);
            case 'tag':
                $list = Db::name('article_meta')
                    ->where("mid", $paging['type'])
                    ->where("type", "tag")
                    ->limit($pagingDate, $paging['pageSize'])
                    ->select();
                $dataList = [];
                foreach ($list as $value) {
                    array_unshift($dataList, Db::name("article")
                        ->where('aid', $value['aid'])
                        ->field('aid,title,create_date,pv,comment_count,cover_url,description,status')
                        ->find());
                }
                $total = Db::name('article_meta')
                    ->where("mid", $paging['type'])
                    ->where("type", "tag")
                    ->count();
                $paging["total"] = $total;
                return array("list" => $dataList, "paging" => $paging);
            case 'hot':
                $list = $this->order('pv desc')
                    ->field('aid,title,create_date,pv,comment_count,cover_url,description')
                    ->limit($pagingDate, $paging['pageSize'])
                    ->select();
                $total = $this->count();
                $paging["total"] = $total;
                return array("list" => $list, "paging" => $paging);
            default:
                $str = $paging['typeName'];
                $pattern = "/^\d+$/";
                if (preg_match($pattern, $str)) {
                    $date = $paging['typeName'] . "-" . $paging['type'];
                    $maxDate = date("Y-m", strtotime("+1 month", strtotime($date)));
                    // $maxDate = $paging['typeName'] . "-" . ((int) $paging['type'] + 1);
                    $list = $this->order('pv desc')
                        ->whereTime('create_date', ">", $date)
                        ->whereTime('create_date', "<", $maxDate)
                        ->field('aid,title,create_date,pv,comment_count,cover_url,description')
                        ->limit($pagingDate, $paging['pageSize'])
                        ->select();
                    $total = $this->whereTime('create_date', ">", $date)
                        ->whereTime('create_date', "<", $maxDate)
                        ->count();
                    $paging["total"] = $total;
                    return array("list" => $list, "paging" => $paging);
                } else {
                    return Article::all();
                }
        }
    }
    /**
     * 根据条件获取文章数量
     *
     * @param string $typeName-类型名称
     * @param string $type-类型value
     * @return Array
     */
    public static function count($typeName = "all", $type = "")
    {
        $count = 0;
        $article = new Article();
        switch ($typeName) {
            case 'all':
                if ($type == 0) {
                    $count = count($article->order('create_date desc')->where('status', "<", 2)->select());
                } else {
                    $count = count(Article::all());
                }
                break;
            case 'keyword':
                $count = count($article->where('title', 'like', '%' . $type . '%')
                    ->whereOr('text', 'like', '%' . $type . '%')
                    ->select());
                break;
            case 'category':
                $count = count(Db::name('article_meta')->where("mid", $type)->where("type", "category")->select());
                break;
            case 'tag':
                $count = count(Db::name('article_meta')->where("mid", $type)->where("type", "category")->select());
                break;
            case 'status':
                // if ($value == -1) {
                //     $count = count(Article::all());
                // } else {
                //     $count = count(Article::all([$field => $value]));
                // }
                break;
            default:
                return count(Article::all());
        }
        return $count;
    }
    public function getArticleMeta($aid, $type)
    {
        return ArticleMeta::all(['aid' => $aid, 'type' => $type]);
    }
    public function editArticle()
    {
        return $this->save();
    }
    public function addArticle()
    {
        return $this->save();
    }
    public function delArticle($aid)
    {
        return Article::destroy($aid);
    }
}