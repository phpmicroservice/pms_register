<?php
/**
 * Created by PhpStorm.
 * User: Dongasai
 * Date: 2018/1/29
 * Time: 11:50
 */

namespace tool;

/**
 * bc函数的增强版 支持进一法
 * Class BcPro
 * @package tool
 */
class BcPro
{


    public static function div($l, $r, $s = 2, $ceil = true)
    {
        if ($ceil) {

            $value = bcdiv($l, $r, $s + 1);
            $cheng = bcpow(10, $s);
            $value2 = bcmul($value, $cheng,1);
            return bcdiv(ceil($value2), $cheng, $s);
        }
        return bcdiv($l, $r, $s);
    }
}