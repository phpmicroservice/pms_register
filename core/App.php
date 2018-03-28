<?php

namespace core;
/**
 * App类,主管应用的产生调度
 */
class App extends \Phalcon\Di\Injectable
{

    private static $ConfigInit;
    /**
     * 应用初始化,进行配置初始话,配置依赖注入器
     */
    public function init(\swoole_server $server,$worker_id)
    {
        if($worker_id == 1){
            # 配置初始化
            self::$ConfigInit=new ConfigInit($server);
        }
        # 配置更新
    }

    public static function task()
    {

    }

    public static function finish(){

    }

    /**
     * 产生链接的回调函数
     */
    public static function connect()
    {
        echo "connect:" . var_export(func_get_args());

    }

    /**
     * 数据接收 回调函数
     */
    public static function receive()
    {
        echo "receive:" . var_export(func_get_args());
    }

    /**
     * 链接关闭 的回调函数
     */
    public static function close()
    {
        echo "close:" . var_export(func_get_args());
    }
}