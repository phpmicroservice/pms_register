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
        echo  (int)$server->taskworker." - $worker_id taskworker  \n";
        # task 测试  5
        # 自动加载
        require ROOT_DIR.'/start/filemonitor.php';
        if($worker_id == 1){
            # 配置初始化
            self::$ConfigInit=new ConfigInit($server);
        }
        if(!$server->taskworker){
            # work进程

            swoole_timer_tick(5000,function (){
                # 从缓存更新配置
                ConfigInit::updata_cache();
            });
        }

    }

    public static function task(\swoole_server $server, int $task_id, int $src_worker_id, $data)
    {
        echo "  --task --".$data;

        return 1;

    }

    /**
     * @param swoole_server $serv
     * @param int $task_id
     * @param string $data
     */
    public static function finish(swoole_server $server, int $task_id, string $data)
    {

    }

    /**
     * 产生链接的回调函数
     */
    public function connect(\swoole_server $server, int $fd, int $reactorId)
    {
        output([$fd, $reactorId], 'connect');
    }

    /**
     * 数据接收 回调函数
     */
    public function receive(\swoole_server $server, int $fd, int $reactor_id, string $data)
    {
        $data = \swoole_serialize::unpack(rtrim($data, PACKAGE_EOF));
        output($data, 'receive');
        $router = new Router($server, $fd, $reactor_id, $data);
        $router->handle($server, $fd, $reactor_id, $data);
    }


    /**
     * 链接关闭 的回调函数
     */
    public function close(\swoole_server $server, int $fd, int $reactorId)
    {
        echo "\n close:" . $fd;
    }
}