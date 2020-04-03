<?php

namespace app\index\model;

use think\Model;
use think\Db;
use think\Exception;

class Meta extends Model
{
    public function getMetaList($type)
    {
        return Meta::all(['type' => $type]);
    }
    public static function count($type)
    {
        return count(Meta::all(['type' => $type]));
    }
    public static function getMeta($mid)
    {
        return Meta::get($mid);
    }
}