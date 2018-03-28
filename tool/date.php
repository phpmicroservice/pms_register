<?php

namespace tool;


/**
 * 辅助日期处理
 * Class date
 * @package tool
 */
class date
{
    /**
     * 时间比较 使用时间戳转换后比较  返回int 参考bccomp
     * @param $left_time 左比较值
     * @param $right_time 右比较值 空则使用当前时间
     * @return int 0为相等 1为左比右大 -1左比右小
     */
    public static function compare($left_time, $right_time = ''): int
    {
        if (empty($right_time)) {
            $right_time = self::mysql();
        }
        if (strtotime($left_time) == strtotime($right_time)) {
            return 0;
        } elseif (strtotime($left_time) > strtotime($right_time)) {
            return 1;
        } else {
            return -1;
        }

    }

    /**
     * 返回sql储存格式的日期
     * @param string $type
     * @return false|string
     */
    public static function mysql($type = 'datetime')
    {
        switch ($type) {
            case 'datetime':
                return date('Y-m-d H:i:s');
            default:
                return date('Y-m-d');
        }

    }

    /**
     * 周 间隔计算
     * @param $stime 旧的时间
     * @param string $new_date 新的时间
     * @return int
     */
    public static function weeksofnow($stime, $new_date = ''): int
    {
        if (!empty($new_date)) {
            $new_date = strtotime($new_date);
        } else {
            $new_date = time();
        }
        $ftime = strtotime($stime);
        $fweeks = date('w', $ftime);
        if ($fweeks == 0) $fweeks = 7;
        $nweeks = date('w', $new_date);
        if ($nweeks == 0) $nweeks = 7;
        $ftemp = strtotime(date('Y-m-d 00:00:00', $ftime)) - $fweeks * 60 * 60 * 24;
        $ntemp = strtotime(date('Y-m-d 00:00:00', $new_date)) + (7 - $nweeks) * 60 * 60 * 24;
        //echo date('w',$ftemp)."<br/>....<br/>".date('w',$ntemp)."<br/>";
        return ($ntemp - $ftemp) / 60 / 60 / 24 / 7;
    }

    /**
     * 天数计算
     * @param $stime 开始时间
     * @param string $new_date 结束时间
     * @return int
     */
    public static function daysofnow($stime, $new_date = ''): int
    {

        if (!empty($new_date)) {
            $new_date = strtotime($new_date);
        } else {
            $new_date = time();
        }

        $ftime = strtotime($stime);

        return ceil(abs(($new_date - $ftime) / (60 * 60 * 24)));
    }

    /**
     * 小时数计算
     * @param $stime 开始时间
     * @param string $new_date 结束时间
     * @return int
     */
    public static function hoursofnow($stime, $new_date = ''): int
    {

        if (!empty($new_date)) {
            $new_date = strtotime($new_date);
        } else {
            $new_date = time();
        }
        $ftime = strtotime($stime);
        return ceil(abs(bcdiv($new_date - $ftime, 3600)));
    }

    /**
     * 分钟计算
     * @param $stime 开始时间
     * @param string $new_date 结束时间
     * @return int
     */
    public static function minutesofnow($stime, $new_date = ''): int
    {

        if (!empty($new_date)) {
            $new_date = strtotime($new_date);
        } else {
            $new_date = time();
        }
        $ftime = strtotime($stime);
        return ceil(abs(bcdiv($new_date - $ftime, 60)));
    }

    /**
     * 间隔月份计算
     * @param $stime 开始时间
     * @param string $new_date 结束时间
     * @return int
     */
    public static function monthsofnow($stime, $new_date = ''): int
    {
        if (!empty($new_date)) {
            $new_date = strtotime($new_date);
        } else {
            $new_date = time();
        }

        $ftime = strtotime($stime);
        $fmonth = date('m', $ftime);
        $fyear = date('Y', $ftime);
        $nmonth = date('m', $new_date);
        $nyear = date('Y', $new_date);
        $result = ($nyear - $fyear) * 12 + $nmonth - $fmonth + 1;
        return $result;
    }

    /**
     * 年间隔时间计算
     * @param date_string $stime 开始时间
     * @param string $new_date 结束时间
     * @return int 数量
     */
    public static function yearsofnow($stime, $new_date = ''): int
    {
        if (!empty($new_date)) {
            $new_date = strtotime($new_date);
        } else {
            $new_date = time();
        }
        $ftime = strtotime($stime);
        $fyear = date('Y', $ftime);
        $new_year = date('Y', $new_date);
        return $new_year - $fyear + 1;
    }

}