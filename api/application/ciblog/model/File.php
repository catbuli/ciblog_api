<?php

namespace app\ciblog\model;

use think\Model;
use think\Db;


class File extends Model
{
    protected $pk = "fid";
    /**
     * 根据条件返回文件列表
     *
     * @param Array $paging pageSize-每页数量 currentPage-当前页码 type-文章类型value typeName-文章类型名称 total-文章总数
     * @return Array 返回的文件列表
     */
    public function getList($paging)
    {
        switch ($paging['typeName']) {
            case 'id':
                return $this->order('datetime esc')->where("aid", $paging['type'])->select();
            case 'status':
                if ($paging['type'] == -1) {
                    return $this->order('datetime desc')->limit(($paging['currentPage'] - 1) * $paging['pageSize'], $paging['pageSize'])->select();
                } else {
                    return $this->order('datetime desc')->limit(($paging['currentPage'] - 1) * $paging['pageSize'], $paging['pageSize'])->where("status", $paging['type'])->select();
                }
            default:
                return $this->order('datetime desc')->limit(($paging['currentPage'] - 1) * $paging['pageSize'], $paging['pageSize'])->select();
        }
    }
    /**
     * 根据条件获取文件数量
     *
     * @param string $typeName-类型名称
     * @param string $type-类型value
     * @return Array
     */
    public static function Count($typeName = "all", $type = "")
    {
        $count = 0;
        $file = new File();
        switch ($typeName) {
            case 'status':
                if ($type == -1) {
                    $count = count(File::all());
                } else {
                    $count = count($file->where('status', $type)->select());
                }
                break;
            case 'id':
                $count = count($file->where('aid', $type)->select());
                break;
            default:
                return count(Article::all());
        }
        return $count;
    }
}