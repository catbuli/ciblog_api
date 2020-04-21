<?php

namespace app\common;

class Response
{
    /**
     * 返回响应信息
     *
     * @param int $code 响应码
     * @param string $title 响应标题
     * @param string $message 响应信息
     * @param array $data 返回数据
     * @return JSON
     */
    public static function result(int $code, string $title = "", string $message = "", $data = [], $paging = [])
    {
        if ($paging) {
            return [
                'code' => $code,
                'title' => $title,
                'message' => $message,
                'data' => $data,
                'paging' => $paging
            ];
        } else {
            return [
                'code' => $code,
                'title' => $title,
                'message' => $message,
                'data' => $data
            ];
        }
    }
}