<?php
# 引导文件,初始化文件
namespace app;

use Phalcon\Events\Event;

/**
 *
 * Class guidance
 * @property \app\table\server $server_table
 * @package app
 */
class Guidance extends \Phalcon\Di\Injectable
{
    /**
     * 构造函数
     * guidance constructor.
     */
    public function __construct()
    {

    }

    /**
     * 开始之前
     * @param Event $event
     * @param \pms\Server $pms_server
     * @param \Swoole\Server $server
     */
    public function beforeStart(Event $event, \pms\Server $pms_server, \Swoole\Server $server)
    {
        output('beforeStart  beforeStart', 'beforeStart');
        # 写入依赖注入

        $this->di->setShared('server_table', function () {
            return new \app\table\server();
        });
        $this->di->setShared('server_ping_table', function () {
            return new \app\table\serverPing();
        });

        $this->server_table;

    }

    /**
     * 启动事件
     * @param Event $event
     * @param \pms\Server $pms_server
     * @param \Swoole\Server $server
     */
    public function onWorkerStart(Event $event, \pms\Server $pms_server, \Swoole\Server $server)
    {
        output($server->taskworker, 'guidance');
        # 绑定一个权限验证
        $this->eventsManager->attach('Router:handleCall', $this);
        # 判断是否已经初始化完毕
        swoole_timer_tick(3000, function ($timeid) {
            # 没有初始化完毕
            $config=\Phalcon\Di::getDefault()->get('config');
            $dConfig=\Phalcon\Di::getDefault()->get('dConfig');
            output($config->database, 'init63');
            if($config->database){
                $dConfig->ready=true;
                output('初始化完成', 'init');
                swoole_timer_clear($timeid);
            }
        });
    }

    /**
     * 路由事件
     * @param Event $event
     * @param \pms\Router $router
     * @param $data
     */
    public function handleCall(Event $event, \pms\Router $router, $data)
    {
        output($data, 'handleCall');
        $new_key=md5(md5(APP_SECRET_KEY) . md5($data['name']));
        $old_key=$data['k'];
        if (\hash_equals($new_key, $old_key)) {
            return true;
        }
        $router->connect->send_error('没有权限', [], 403);
        return false;
    }


}