<?php

namespace tool;

/**
 * Description of Json
 *
 * @author Dongasai
 */
class Json
{

    public static function toArray($json_string){
        return json_decode($json_string,true);
    }

    /**
     * 过滤器
     * @param $data
     * @param array $Filters
     * @return string
     */
    public static function tostrFilters($data, $Filters = [])
    {
        if ($Filters) {
            foreach ($Filters as $v) {
                if (is_object($data)) {
                    $data->$v = null;
                } else {
                    unset($data[$v]);
                }
            }
        }
        return json_encode($data);
    }

    /**
     * @param $data
     */
    public static function json_en4html($data)
    {
        $str= json_encode($data) ;
        $str =preg_replace('/\s/', " ",$str);
         return $str;
    }

}
