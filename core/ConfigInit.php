<?php

namespace core;

/**
 * 配置初始化
 * Class Config
 * @property \swoole_client $config_client
 * @package core
 */
class ConfigInit extends Base
{
    private $server;
    public static $config_client;
    private $config_ip;
    private $config_port;

    /**
     * 配置初始化
     */
    public function __construct(\swoole_server $server)
    {
        $this->config_ip = get_env('CONFIG_ADDRESS', 'pms_config');
        $this->config_port = get_env('CONFIG_PORT', '9502');
        $this->server = $server;
        $this->init();
        $ConfigInit = $this;

        swoole_timer_tick(5000, function ($id) use ($ConfigInit, $server) {
            echo "config server judge \n";
            $cache = \Phalcon\Di::getDefault()->get('cache');
            # 确认初始化已经完成,更新配置信息
            if (!$cache->get('cache_init')) {
                # 没有初始化完毕
                $ConfigInit->init();
            } else {
                # 完成初始化了
                $ConfigInit->update();
            }
        });

    }

    private function init()
    {
        echo "ConfigInit -> init \n";
        $this->get_swoole_client();
        echo $this->config_ip . ':' . $this->config_port . " \n";

        if (self::$config_client->isConnected()) {
            $this->send([
                'r'=>'config_acquire',
                'd'=>'register'
            ]);
        } else {
            self::$config_client->connect($this->config_ip, $this->config_port);
        }
        echo "ConfigInit -> init end \n";


    }

    private function get_swoole_client()
    {
        echo "get_swoole_client \n";
        if (self::$config_client instanceof \swoole_client) {
        } else {
            self::$config_client = new \swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);
        }
        self::$config_client->set([
            'open_eof_check' => true, //打开EOF检测
            'package_eof' => PACKAGE_EOF, //设置EOF
        ]);

        self::$config_client->on("connect", [$this, 'connect']);
        self::$config_client->on("receive", [$this, 'receive']);
        self::$config_client->on("error", [$this, 'error']);
        self::$config_client->on("close", [$this, 'close']);
    }

    /**
     * 发送数据
     * @param $data
     */
    public function send($data)
    {
        self::$config_client->send(\swoole_serialize::pack($data).PACKAGE_EOF);
    }


    /**
     * 链接成功
     * @param \swoole_client $cli
     */
    public function connect(\swoole_client $cli)
    {
        echo "config server connect \n";

    }


    /**
     * 收到值
     * @param \swoole_client $cli
     * @param $data
     */
    public function receive(\swoole_client $cli, $data)
    {
        echo "Receive:---- \n";
        $data_arr=explode(PACKAGE_EOF,rtrim($data,PACKAGE_EOF));
        foreach ($data_arr as $value){
            $this->receive_true($value);
        }

    }

    private function receive_true($data){
        echo "Receive: ". var_export(\swoole_serialize::unpack($data),true) ." \n";
    }

    /**
     * 链接出错的
     * @param \swoole_client $cli
     */
    public function error(\swoole_client $cli)
    {
        echo "config server error \n";

    }

    public function close(\swoole_client $cli)
    {
        echo "config server close \n";

    }


    /**
     * 配置更新
     */
    public function update()
    {
        echo "ConfigInit update ... \n";
        $this->send([
            'r'=>'config_renewal',
            'd'=>'register'
        ]);
    }

    public function ping()
    {
        echo "ConfigInit ping ... \n";
        $this->send([
            'r'=>'ping_ping',
            'd'=>''
        ]);
    }

}