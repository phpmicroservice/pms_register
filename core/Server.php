<?php
/**
 * Created by PhpStorm.
 * User: Dongasai
 * Date: 2018/3/28
 * Time: 16:19
 */

namespace core;


class Server
{
    private $server;

    public function __construct()
    {

        $this->server = new \swoole_server('0.0.0.0', 9502, SWOOLE_BASE, SWOOLE_SOCK_TCP);

        # 设置运行参数
        $this->server->set(array(
            'daemonize' => false,
            'worker_num' => 4,
            'task_worker_num' => 10
        ));
        # 注册进程回调函数
        $this->workCall();
        # 注册链接回调函数
        $this->tcpCall();


    }

    /**
     * 启动服务
     */
    public function start()
    {
        $this->server->start();
    }

    private function tcpCall()
    {
        # 设置基本回调
        $this->server->on('Connect', '\core\App::connect');
        $this->server->on('Receive', '\core\App::receive');
        $this->server->on('Close', '\core\App::close');
        $this->server->on('Task', '\core\App::task');
        $this->server->on('Finish', '\core\App::finish');
    }

    private function workCall()
    {

        # 主进程启动
        $this->server->on('Start', function ($server) {
            echo "on Start \n";
        });
        # Work进行 启动
        $this->server->on('WorkerStart', function (\swoole_server $server, $worker_id) {
            echo "on WorkerStart \n";
            # 加载依赖注入器
            include_once ROOT_DIR.'/core/services.php';
            # 应用初始化
            $app = new \core\App();
            $app->init($server, $worker_id);
        });
    }



}