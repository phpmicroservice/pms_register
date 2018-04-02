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
class guidance  extends \Phalcon\Di\Injectable
{

    /**
     * 启动事件
     * @param Event $event
     * @param \pms\Server $pms_server
     * @param \Swoole\Server $server
     */
    public function onWorkerStart(Event $event,\pms\Server $pms_server,\Swoole\Server $server)
    {
        $this->dConfig->ready=true;
        output(19,'guidance');
    }

    /**
     * 开始之前
     * @param Event $event
     * @param \pms\Server $pms_server
     * @param \Swoole\Server $server
     */
    public function beforeStart(Event $event,\pms\Server $pms_server,\Swoole\Server $server)
    {
        output('beforeStart  beforeStart','beforeStart');
        # 写入依赖注入
        $this->di->setShared('server_table',function(){
            return new table\server();
        });

        $this->server_table;

    }

}