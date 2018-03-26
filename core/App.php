<?php

namespace core;
/**
 * App类,主管应用的产生调度
 */
class App
{

    /**
     * 应用初始化,进行配置初始话,配置依赖注入器
     */
    public static function init(\swoole_server $server, int $worker_id)
    {
        # 配置初始化
        \core\ConfigInit::init();

    }

    /**
     * 产生链接的回调函数
     */
    public function connect()
    {
        echo "connect:" . var_export(func_get_args());

    }

    /**
     * 数据接收 回调函数
     */
    public function receive()
    {
        echo "receive:" . var_export(func_get_args());
    }

    /**
     * 链接关闭 的回调函数
     */
    public function close()
    {
        echo "close:" . var_export(func_get_args());
    }
}