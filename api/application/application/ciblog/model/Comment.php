<?php

namespace app\ciblog\model;

use think\Model;
use think\Db;
use think\Exception;

class Comment extends Model
{
    protected $pk = "cid";
    public function getCommentList($paging)
    {
        switch ($paging['typeName']) {
            case 'status':
                if ($paging['type'] == -1) {
                    return $this->order('create_date desc')->limit(($paging['currentPage'] - 1) * $paging['pageSize'], $paging['pageSize'])->select();
                } else {
                    return $this->where("status", $paging['type'])->order('create_date desc')->limit(($paging['currentPage'] - 1) * $paging['pageSize'], $paging['pageSize'])->select();
                }
            case 'aid':
                return $this->where('aid', $paging['type'])->where('status', 1)->order('create_date desc')->select();
            default:
                return $this->order('create_date desc')->select();;
        }
    }
    public static function count($field = '', $value = -1)
    {
        $count = 0;
        switch ($field) {
            case 'status':
                if ($value == -1) {
                    $count = count(Comment::all());
                } else {
                    $count = count(Comment::all([$field => $value]));
                }
                break;
            case 'aid':
                $count = count(Comment::all(["aid" => $value]));
                break;
            default:
                $count = count(Comment::all());
                break;
        }
        return $count;
    }
    public function editStutas($cid, $status)
    {
        return $this->save([
            'status'  => $status,
        ], ['cid' => $cid]);
    }
    public static function getCommentById($aid)
    {
        return Comment::all(['aid' => $aid, 'status' => 1]);
    }
}