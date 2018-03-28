<?php

namespace tool;


/**
 * 数组处理
 *
 * @author saisai
 */
class Arr
{
    /**
     * array_column 变更版本,返回一个一维数组
     * @param array $array
     * @param string $index
     */
    public static function column(array $array, string $index): array
    {
        $listre=[];
        foreach ($array as $valuu){
            $listre[]=$valuu[$index];
        }
        return $listre;
    }

    /**
     * 获取数组的md5散列值
     * @param $array
     * @return string
     */
    public static function array_md5($array): string
    {
        return md5(serialize($array));
    }

    /**
     * 递归处理数据库读出来的数组格式化为无限级分类格式数组
     */
    public static function recursion($array, $p = 'parent_id', $ai = 'id', $start = 0, $lv = 0, $type = 1)
    {
        $re = array();
        $lv1 = $lv++;
        foreach ($array as $k => $v) {
            if ($v[$p] == $start) {
                $re[$v[$ai]] = $v;
                $re[$v[$ai]]['lv'] = $lv;
                unset($array[$k]);
                if ($type != 1) {
                    $re = $re + self::recursion($array, $p, $ai, $v[$ai], $lv1, $type);
                } else {
                    $re[$v[$ai]]['sub'] = self::recursion($array, $p, $ai, $v[$ai], $lv, $type);
                }
            }
        }
        return $re;
    }

    /**
     * 改变二维数组的索引形式
     */
    public static function array_change_index(array $array, string $index_name)
    {
        $new = [];
        foreach ($array as $val) {
            $new[$val[$index_name]] = $val;
        }
        return $new;
    }


    /**
     * 常用的遍历结构 01
     * @param $array 进行处理的数组
     * @param $indexs 这个数组的索引
     * @param callable $call 处理这个索引集合的方法
     * @param bool $int 是否为数字
     * @param bool $as 索引赋值映射
     * @return mixed
     */
    public static function for_index($array, $indexs, $call, $int = false, string $as = '')
    {
        if (!is_callable($call)) {
            return false;
        }

        if (!is_array($indexs)) {
            $indexs = [$indexs];
        }
        foreach ($indexs as $index) {
            $list = [];
            foreach ($array as $value) {

                if ($index === null) {
                    $index78 = $int ? (int)$value : $value;

                } else {
                    $index78 = $int ? (int)$value[$index] : $value[$index];
                }
                $list[$index78] = $index78;
            }
            $list = array_unique($list);
            $array2 = call_user_func($call, $list);
            foreach ($array as $k => &$value2) {
                if ($index === null) {
                    $value2 = $array2[$value2] ?? null;
                } else {
                    if (isset($array2[$value2[$index]])) {
                        if ($as) {
                            $value2[$as] = $array2[$value2[$index]];
                        } else {
                            $value2[$index . '_info'] = $array2[$value2[$index]];
                        }
                    }
                }
            }
        }
        return $array;
    }


    /**
     * 用回调函数,来处理数组的值
     * @param array $array 数组
     * @param array $indexs 要处理的索引集合
     * @param callable $call 回调函数
     * @param bool $as 赋值映射
     * @param array $pas 传给回调函数的额外参数
     * @return array 处理过的数组
     */
    public static function for_value(array $array, array $indexs, callable $call, $ass = false, array $pas = [])
    {
        foreach ($indexs as $ki => $index) {
            foreach ($array as $k => &$value) {

                if (isset($pas[$ki])) {
                    $pa = $pas[$ki];
                } else {
                    $pa = null;
                }
                if (isset($ass[$ki])) {
                    $as = $ass[$ki];
                } else {
                    $as = false;
                }
                if ($index == null) {
                    # 直接引用值
                    $value = $call($value, $pa);
                } else {
                    # 二维数组,使用索引
                    if ($as) {
                        # 赋值的时候使用,映射
                        $value[$as] = $call($value[$index], $pa);
                    } else {
                        $value[$index] = $call($value[$index], $pa);
                    }
                }
            }
        }
        return $array;

    }


//put your code here
}
