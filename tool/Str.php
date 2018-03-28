<?php
/**
 * Created by PhpStorm.
 * User: Dongasai
 * Date: 2017/5/4
 * Time: 13:16
 */

namespace tool;


class Str
{
    /**
     * 订单号生成 30位
     * 日期8位   商户号8位    微时间戳9位 随机数 类型
     * 2016 02 17 00000158     713861787    243     12
     * @param type $shopid
     * @return type
     */
    public static function out_trade_no($shopid = 0)
    {
        return date('Ymd') . sprintf('%08d', $shopid) . substr(microtime(true) * 10000, -9) . mt_rand(100, 999);
    }


    // 过滤掉emoji表情
    public static function filter_Emoji($str)
    {
        $str = preg_replace_callback(    //执行一个正则表达式搜索并且使用一个回调进行替换
            '/./u',
            function (array $match) {
                return strlen($match[0]) >= 4 ? '' : $match[0];
            },
            $str);

        return $str;
    }


    /**
     * +----------------------------------------------------------
     * 将一个字符串部分字符用*替代隐藏
     * +----------------------------------------------------------
     * @param string $string 待转换的字符串
     * @param int $bengin 起始位置，从0开始计数，当$type=4时，表示左侧保留长度
     * @param int $len 需要转换成*的字符个数，当$type=4时，表示右侧保留长度
     * @param int $type 转换类型：0，从左向右隐藏；1，从右向左隐藏；2，从指定字符位置分割前由右向左隐藏；3，从指定字符位置分割后由左向右隐藏；4，保留首末指定字符串
     * @param string $glue 分割符
     * +----------------------------------------------------------
     * @return string   处理后的字符串
     * +----------------------------------------------------------
     */
    public static function hideStr($string, $bengin = 1, $len = 4, $type = 0, $glue = "*")
    {
        if (empty($string))
            return false;
        $array = array();
        if ($type == 0 || $type == 1 || $type == 4) {
            $strlen = $length = mb_strlen($string);
            while ($strlen) {
                $array[] = mb_substr($string, 0, 1, "utf8");
                $string = mb_substr($string, 1, $strlen, "utf8");
                $strlen = mb_strlen($string);
            }
        }
        $length = count($array);
        if ($type == 0) {
            for ($i = $bengin; $i < ($bengin + $len); $i++) {
                if (isset($array[$i]))
                    $array[$i] = "*";
            }
            $string = implode("", $array);
        } else if ($type == 1) {
            $array = array_reverse($array);
            for ($i = $bengin; $i < ($bengin + $len); $i++) {
                if (isset($array[$i]))
                    $array[$i] = "*";
            }
            $string = implode("", array_reverse($array));
        } else if ($type == 2) {
            $array = explode($glue, $string);
            $array[0] = hideStr($array[0], $bengin, $len, 1);
            $string = implode($glue, $array);
        } else if ($type == 3) {
            $array = explode($glue, $string);
            $array[1] = hideStr($array[1], $bengin, $len, 0);
            $string = implode($glue, $array);
        } else if ($type == 4) {
            $left = $bengin >= $length ? floor(($bengin / $length)) : $bengin;
            $right = $len >= $length ? floor($right / $length) : $len;
            $tem = array();
            for ($i = 0; $i < ($length - $right); $i++) {
                if (isset($array[$i]))
                    $tem[] = $i >= $left ? "*" : $array[$i];
            }
            $array = array_chunk(array_reverse($array), $right);
            $array = array_reverse($array[0]);
            for ($i = 0; $i < $right; $i++) {
                $tem[] = $array[$i];
            }
            $string = implode("", $tem);
        }
        return $string;
    }

    /**
     *
     */
    public static function replace($str, $arr)
    {
        foreach ($arr as $yuan => $hou) {
            $str = str_replace($yuan, $hou, $str);
        }
        return $str;
    }

}