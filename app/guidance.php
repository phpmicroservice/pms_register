<?php
# 引导文件,初始化文件
namespace app;

use Phalcon\Events\Event;

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

}