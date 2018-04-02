<?php

namespace app\table;
/**
 * Class server
 */
class server extends \pms\bear\Table
{
    protected $size = 1024;# 表最大行数
    protected $column = [
        [
            'name' => 'cache_key',
            'type' => \Swoole\Table::TYPE_STRING,
            'size' => 32
        ],
        [
            'name' => 'number',
            'type' => \Swoole\Table::TYPE_INT,
            'size' => 8
        ]
    ];
    protected $swoole_table;

    /**
     * 注册一个服务
     * @param $name
     * @param $host
     * @param $port
     */
    public function reg($name, $host, $port)
    {

        $info=$this->create($name, $host, $port);
        # 保存信息到全局缓存
        $gCache =\Phalcon\Di::getDefault()->get('gCache');
        $cache_data=$gCache->get($info['cache_key']);
        if(empty($cache_data)){
            $cache_data=[];
        }
        $cache_data[\tool\Arr::array_md5($host,$port,$name)]=[
            'host'=>$host,
            'port'=>$port
        ];
        $gCache->set($cache_data);
    }

    /**
     * 创建,存在则读取返回
     * @param $name
     * @param $host
     * @param $port
     */
    private function create($name, $host, $port){
        if ($this->exist($name)) {
            # 存在
            $info=$this->get($name);
        }else{
            # 不存在
            $info=[
                'cache_key'=>\tool\Arr::array_md5(__FILE__,__LINE__,$name),
                'number'=>0
            ];
            $this->set($name,$info);
        }
        return $info;
    }

    /**
     * 注销
     * @param $name
     * @param $host
     * @param $port
     */
    public function logout($name, $host, $port)
    {
        $info = $this->create($name, $host, $port);
        $gCache = \Phalcon\Di::getDefault()->get('gCache');
        $cache_data = $gCache->get($info['cache_key']);
        if (empty($cache_data)) {
            $cache_data = [];
        }
        $key=\tool\Arr::array_md5($host, $port, $name);

        if(isset($cache_data['$key'])){
            unset($cache_data[$key]);
        }
        $gCache->set($cache_data);

    }
}