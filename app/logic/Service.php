<?php

namespace app\logic;

use app\Controller;

/**
 * 服务处理 逻辑层
 *
 */
class Service extends Controller
{
    /**
     * 获取名字列表
     * @return array|mixed|null
     */
    public function getListName()
    {
        $list=$this->gCache->get('server_list');
        if(empty($list)){
            $this->gCache->save('server_list',[]);
            return [];
        }
        return $list;
    }

    public function addService($name)
    {
        $list=$this->getListName();
        $list[]=$name;
        $list =array_unique($list);
        return $this->gCache->save('server_list',$list);
    }


}