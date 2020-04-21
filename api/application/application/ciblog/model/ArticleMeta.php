<?php

namespace app\ciblog\model;

use think\Model;
use think\Db;
use think\Exception;

class ArticleMeta extends Model
{
    protected $pk = "id";
    public function addArticleMeta()
    {
        $this->save();
    }
    public static function addMetaList($data, $aid, $type)
    {
        foreach ($data as $value) {
            $ArticleMeta = new ArticleMeta([
                'aid'  =>  $aid,
                'mid' =>  $value,
                'type' => $type
            ]);
            $ArticleMeta->addArticleMeta();
        };
    }
    public static function getMetaByArticle($aid, $type, $getName)
    {
        $list = ArticleMeta::all(['aid' => $aid, 'type' => $type]);
        if ($getName) {
            $flag = [];
            foreach ($list as $value) {
                array_push($flag, Meta::getMeta($value->mid));
            }
            return $flag;
        } else {
            return $list;
        }
    }
    public static function delMetaByArticle($mid)
    {
        ArticleMeta::destroy(['mid' => $mid]);
    }
    public static function delAllMetaByArticle($aid, $type)
    {
        ArticleMeta::destroy(['aid' => $aid, 'type' => $type]);
    }
}