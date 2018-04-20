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
    public function initialize()
    {
        $this->logicServer = new \app\logic\Service();
    }

    /**
     * 心跳
     */
    public function ping()
    {

        $data = $this->connect->getData();
        $this->logicServer->ping($data);
        $this->connect->send_succee([],'收到ping!');
    }


    /**
     * 注册
     */
    public function reg()
    {
        $data = $this->connect->getData();
        $this->logicServer->addService($data['name']);
        $this->logicServer->addServiceMachine($data['name'],$data);
        $this->connect->send_succee([],'注册成功!');
    }

    /**
     * 获取一个
     */
    public function getone()
    {
        $data = $this->connect->getData();
        $info = $this->logicServer->getOneInfo($data['name']);
        $this->connect->send_succee($info);
    }

    /**
     * 获取所有
     */
    public function getall()
    {
        $data = $this->connect->getData();
        $info = $this->logicServer->getall();
        $this->connect->send_succee($info);
    }


}