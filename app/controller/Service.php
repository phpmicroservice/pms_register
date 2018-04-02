<?php

namespace app\controller;
use pms\bear\Counnect;

/**
 * 服务处理
 * @property \app\logic\Service $logicServer
 */
class Service extends \app\Controller
{
    private $logicServer;

    /**
     * 初始化
     */
    public function onInitialize( )
    {
        $this->logicServer=new \app\logic\Service();
    }

    /**
     * 心跳
     */
    public function ping()
    {


    }

    /**
     * 注册
     */
    public function reg($data)
    {
        output(func_get_args(),'reg');
        $server_list =$this->logicServer->getListName();
        $this->logicServer->addService($data['name']);


    }

    /**
     * 获取一个
     */
    public function getone()
    {

    }

    /**
     * 获取所有
     */
    public function getall()
    {

    }


}