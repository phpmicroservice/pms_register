<?php
namespace core;
/**
 * App类,主管应用的产生调度
 */
class App{


    /**
     * 产生链接的回调函数
     */
    public static function connect()
    {
        echo "connect:".var_export(func_get_args());

    }
    /**
     * 数据接收 回调函数
     */
    public static function receive()
    {
        echo "receive:".var_export(func_get_args());
    }
    /**
     * 链接关闭 的回调函数
     */
    public static function close()
    {
        echo "close:".var_export(func_get_args());
    }
}