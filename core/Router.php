<?php

namespace core;

/**
 * 路由器
 * Class Router
 * @property \core\Counnect $connect
 * @package core
 */
class Router extends \Phalcon\Di\Injectable
{
    private $connect;

    public function __construct(\swoole_server $server, int $fd, int $reactor_id, array $data)
    {
        $this->connect = new Counnect($server, $fd, $reactor_id, $data);
    }


    /**
     * 处理
     * @param \swoole_server $server
     * @param int $fd
     * @param int $reactor_id
     * @param string $data
     */
    public function handle(\swoole_server $server, int $fd, int $reactor_id, array $data)
    {
        $router_string = $this->connect->getRouter();
        $arr = explode('_', $router_string);

        $controller_name = $arr[0];
        $action_name = $arr[1];
        $this->handleCall($controller_name, $action_name);
    }


    /**
     * 处理
     * @param $controller_name 控制器名字
     * @param $action_name 动作名字
     */
    private function handleCall($controller_name, $action_name)
    {
        $class_name = '\\app\\controller\\' . ucfirst($controller_name);

        output($class_name, 'class_name');
        $faultcontroller = 'app\controller\Fault';
        if (class_exists($class_name)) {
            $controller = new $class_name($this->connect);
            if (method_exists($controller, $action_name)) {
                $controller->$action_name($this->connect->getData());
            } else {
                $controller->action($this->connect->getData());
            }
        } else {
            # 不合法的控制器
            $controller = new $faultcontroller($this->connect);
            $controller->controller($this->connect->getData());
        }
    }


    public function __destruct()
    {
//        echo "销毁一个路由";
        // TODO: Implement __destruct() method.
    }

}