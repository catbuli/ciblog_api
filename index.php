<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET,POST,OPTIONS');
header('Access-Control-Allow-Origin:http://127.0.0.1:80');
session_start();
// 定义应用目录
define('APP_PATH', __DIR__ . '/application/');
// 入口绑定到index控制器
define('BIND_MODULE', 'index');
// 加载框架引导文件
require __DIR__ . '/thinkphp/start.php';