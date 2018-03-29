<?php
define('ROOT_DIR', __DIR__);
//注册自动加载;采用Phalcon的自动加载
$loader = new \Phalcon\Loader();
$loader->registerNamespaces(
    [
        'app' => ROOT_DIR . '/app/',
        'core' => ROOT_DIR . '/core/',
    ]
);
include_once './core/services.php';
$loader->register();
# 进行数据库初始化
$iuu=new \core\Dbcu();
$iuu->testUpdate();
echo "初始化完毕!";
