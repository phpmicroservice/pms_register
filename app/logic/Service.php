<?php

namespace app\logic;

use funch\date;


/**
 * 服务处理 逻辑层
 *
 */
class Service extends \app\Base
{
    /**
     * 心跳检查
     */
    public function pingExamine()
    {
        output('pingExamine','pingExamine');
        $name_list=$this->getListName();
        foreach ($name_list as $name){
            $list=$this->getServiceMachine($name);
            foreach ($list as $sm){
                $pingInfo=$this->getPingInfo($sm);
                $last_time=array_pop($pingInfo);
                output([\date('Y-m-d H:i:s', $last_time), date('Y-m-d H:i:s'), time() - $last_time, $this->dConfig->overtime], 'pingExamine_lasttime');
                if((time() - $last_time) >$this->dConfig->overtime){
                    # 长时间无心跳,超时删除
                    $this->delServiceMachine($name,$sm);
                }
            }
        }
    }

    /**
     * 获取名字列表
     * @return array|mixed|null
     */
    public function getListName()
    {
        $list = $this->gCache->get('server_list');
        if (empty($list)) {
            $this->gCache->save('server_list', []);
            return [];
        }
        return $list;
    }

    /**
     * 增加一个服务
     * @param $name
     * @return bool
     */
    public function addService($name)
    {
        $list = $this->getListName();
        $list[] = $name;
        $list = array_unique($list);
        return $this->gCache->save('server_list', $list);
    }

    /**
     * 给服务增加一个机器
     */
    public function addServiceMachine($name, $data)
    {
        $key = \funch\Arr::array_md5($data);
        $key_cache = 'server_machine_' . $name;
        $list = $this->getServiceMachine($name);
        $list[$key] = $data;
        return $this->gCache->save($key_cache, $list);
    }

    /**
     * 获取一个服务的信息
     * @param $name
     */
    public function getOneInfo($name)
    {
        $data = [];
        $info = $this->getServiceMachine($name);
        output($info, 'getOneInfo');
        foreach ($info as $sm) {
            if (isset($data[$sm['name']])) {
            } else {
                $data[$sm['name']] = [];
            }
            $data[$sm['name']][] = $sm;
        }
        return $data;

    }

    /**
     * 获取全部
     * @return array
     */
    public function getall()
    {
        $data = [];
        $name_list = $this->getListName();
        foreach ($name_list as $key => $name) {
            $list = $this->getServiceMachine($name);
            foreach ($list as $sm) {
                if (isset($data[$sm['name']])) {

                } else {
                    $data[$sm['name']] = [];
                }

                $data[$sm['name']][] = $sm;
            }
        }

        return $data;
    }

    /**
     * 从机器组中删除一条机器
     * @param $name
     * @param $data
     * @return bool
     */
    public function delServiceMachine($name, $data)
    {
        output([$data, $name], 'delServiceMachine');
        $key = \funch\Arr::array_md5($data);
        $key_cache = 'server_machine_' . $name;
        $list = $this->getServiceMachine($name);
        if(empty($list)){
           #空的了
            return 0;
        }
        if(isset($list[$key])){
            unset($list[$key]);
        }
        return $this->gCache->save($key_cache, $list);
    }

    /**
     * 获取服务的机器列表
     * @param $name
     */
    private function getServiceMachine($name)
    {
        $key_cache = 'server_machine_' . $name;
        $list = $this->gCache->get($key_cache);
        if (empty($list)) {
            $this->gCache->save($key_cache, []);
            return [];
        }
        return $list;
    }

    /**
     * ping 保持活力
     * @param $data
     */
    public function ping($data)
    {
        $this->addServiceMachine($data['name'], $data);
        $info = $this->getPingInfo($data);
        if (\count($info) > 10) {
            array_shift($info);
        }
        array_push($info, time() - 1);
        return $this->setPingInfo($data, $info);
    }

    /**
     * 获取ping 信息
     * @param $data
     */
    private function getPingInfo($data)
    {
        $key = \funch\Arr::array_md5([$data, 'ping']);
        $list = $this->gCache->get($key);
        if (empty($list)) {
            $this->gCache->save($key, [], 20);
            return [];
        }
        return $list;
    }

    /**
     * 设置ping信息
     * @param $data
     * @param $info
     * @return bool
     */
    private function setPingInfo($data, $info)
    {
        $key = \funch\Arr::array_md5([$data, 'ping']);
        return $this->gCache->save($key, $info, 20);
    }


}