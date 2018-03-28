<?php

namespace tool;

/**
 * Description of Debug
 *
 * @author Dongasai
 */
class Debug
{

    /**
     * 测试函数 执行完退出 可以传入任意个参数,只在调试模试下执行
     * @author 李海涛 <QQ:596845798>
     */
    public static function pre()
    {
        if (!\APP_DEBUG) {
            return false;
        }

        // $argsNum = func_num_args(); //获取参数个数
        $args     = func_get_args();
        $debugArr = debug_backtrace();
        $timeArr  = explode(' ', microtime());
        echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
        echo "<pre  style='color:red'><hr><hr>【调用文件】:", $debugArr [0] ['file'], '<br/>【调用行号】:', $debugArr [0] ['line'], '<br/>';
        echo '【调用时间】:', date('Y-m-d H:i:s ', $timeArr[1]), $timeArr[0], '<hr>';
        foreach ($args as $k => $v) {
            $getType = gettype($v);
            echo '【变量序号】:', $k + 1, '<br/>【变量类型】:', $getType, '<br/>';
            'boolean' == $getType ? var_dump($v) : print_r($v);
            echo '<hr>';
        }
        echo '<hr></pre>';
        exit;
    }

    /**
     * 测试函数 执行完不退出 可以传入任意个参数,只在调试模试下执行
     * @author 李海涛 <QQ:596845798>
     */
    public static function pr()
    {
        if (!APP_DEBUG)
            return false;
        // $argsNum = func_num_args(); //获取参数个数
        $args     = func_get_args();
        $timeArr  = explode(' ', microtime());
        $debugArr = debug_backtrace();
        echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
        echo "<pre  style='color:red'><hr><hr>【调用文件】:", $debugArr [0] ['file'], '<br/>【调用行号】:', $debugArr [0] ['line'], '<br/>';
        echo '【调用时间】:', date('Y-m-d H:i:s ', $timeArr[1]), $timeArr[0], '<hr>';
        foreach ($args as $k => $v) {
            $getType = gettype($v);
            echo '【变量序号】:', $k + 1, '<br/>【变量类型】:', $getType, '<br/>';
            'boolean' == $getType ? var_dump($v) : print_r($v);
            echo '<hr>';
        }
        echo '<hr></pre>';
    }

    /**
     * [prw 将数组(任意维度)写入一个HTML文件],只在调试模试下执行
     * @author 李海涛 <QQ:596845798>
     * @return [type]           [返回一个字窜]
     */
    public static function prw()
    {
        if (!APP_DEBUG) {
            return false;
        }
        $args     = func_get_args();
        $debugArr = debug_backtrace();

        $filename = 'cbg.html';
        //如果最后一个参数为*.html,则将其作为写入文件的文件名
        if (is_string($args[count($args) - 1])) {
            $fileArr = explode('.html', $args[count($args) - 1]);
            if (2 == count($fileArr) && 0 == strlen($fileArr[1])) {
                if (is_numeric($fileArr[0]) && (int) ($fileArr[0]) == $fileArr[0] && $fileArr[0] < 900) {
                    $fileArr[0] += 1000;
                    $fileArr[0] = substr($fileArr[0], 1);
                }
                $filename = 'cbg' . $fileArr[0] . '.html';
                unset($args[count($args) - 1]);
            }
        }

        $timeArr  = explode(' ', microtime());
        $debugArr = debug_backtrace();
        $laststr  = "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
        $laststr  .= "<pre  style='color:red'>【调用文件】:" . $debugArr [0] ['file'] . '<br/>【调用行号】:' . $debugArr [0] ['line'] . '<br/>';
        $laststr  .= '【调用时间】:' . date('Y-m-d H:i:s ', $timeArr[1]) . $timeArr[0] . '<hr/>';
        foreach ($args as $k => $v) {
            $getType = gettype($v);
            $laststr .= '【变量序号】:' . ($k + 1) . '<br/>【变量类型】:' . $getType . '<br/>';
            $laststr .= 'boolean' == $getType ? ( $v ? 'bool( true )' : 'bool( false )' ) : print_r($v, true);
            $laststr .= '<hr>';
        }
        $laststr .= '</pre>';
        file_put_contents($filename, $laststr);
    }

    /**
     * [prw 将数组(任意维度)写入一个HTML文件],如果文件存在,就追加,只在调试模试下执行
     * @author 李海涛 <QQ:596845798>
     * @return [type]           [返回一个字窜]
     */
    public static function praw()
    {
        if (!APP_DEBUG)
            return false;
        $args     = func_get_args();
        $debugArr = debug_backtrace();

        $filename = 'cbg.html';
        //如果最后一个参数为*.html,则将其作为写入文件的文件名
        if (is_string($args[count($args) - 1])) {
            $fileArr = explode('.html', $args[count($args) - 1]);
            if (2 == count($fileArr) && 0 == strlen($fileArr[1])) {
                if (is_numeric($fileArr[0]) && (int) ($fileArr[0]) == $fileArr[0] && $fileArr[0] < 900) {
                    $fileArr[0] += 1000;
                    $fileArr[0] = substr($fileArr[0], 1);
                }
                $filename = 'cbg' . $fileArr[0] . '.html';
                unset($args[count($args) - 1]);
            }
        }
        $timeArr  = explode(' ', microtime());
        $debugArr = debug_backtrace();
        $laststr  = "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
        $laststr  .= "<pre  style='color:red'>【调用文件】:" . $debugArr [0] ['file'] . '<br/>【调用行号】:' . $debugArr [0] ['line'] . '<br/>';
        $laststr  .= '【调用时间】:' . date('Y-m-d H:i:s ', $timeArr[1]) . $timeArr[0] . '<hr/>';
        foreach ($args as $k => $v) {
            $getType = gettype($v);
            $laststr .= '【变量序号】:' . ($k + 1) . '<br/>【变量类型】:' . $getType . '<br/>';
            $laststr .= 'boolean' == $getType ? ( $v ? 'bool( true )' : 'bool( false )' ) : print_r($v, true);
            $laststr .= '<hr>';
        }
        $laststr .= '</pre>';
        file_put_contents($filename, $laststr, FILE_APPEND | LOCK_EX);
    }

    /**
     * [prw 将数组(任意维度)写入一个HTML文件],只在调试模试下执行,并退出
     * @author 李海涛 <QQ:596845798>
     */
    public static function prew()
    {
        if (!APP_DEBUG)
            return false;
        $args     = func_get_args();
        $debugArr = debug_backtrace();

        $filename = 'cbg.html';
        //如果最后一个参数为*.html,则将其作为写入文件的文件名
        if (is_string($args[count($args) - 1])) {
            $fileArr = explode('.html', $args[count($args) - 1]);
            if (2 == count($fileArr) && 0 == strlen($fileArr[1])) {
                if (is_numeric($fileArr[0]) && (int) ($fileArr[0]) == $fileArr[0] && $fileArr[0] < 900) {
                    $fileArr[0] += 1000;
                    $fileArr[0] = substr($fileArr[0], 1);
                }
                $filename = 'cbg' . $fileArr[0] . '.html';
                unset($args[count($args) - 1]);
            }
        }
        $timeArr  = explode(' ', microtime());
        $debugArr = debug_backtrace();
        $laststr  = "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
        $laststr  .= "<pre  style='color:red'>【调用文件】:" . $debugArr [0] ['file'] . '<br/>【调用行号】:' . $debugArr [0] ['line'] . '<br/>';
        $laststr  .= '【调用时间】:' . date('Y-m-d H:i:s ', $timeArr[1]) . $timeArr[0] . '<hr/>';
        foreach ($args as $k => $v) {
            $getType = gettype($v);
            $laststr .= '【变量序号】:' . ($k + 1) . '<br/>【变量类型】:' . $getType . '<br/>';
            $laststr .= 'boolean' == $getType ? ( $v ? 'bool( true )' : 'bool( false )' ) : print_r($v, true);
            $laststr .= '<hr>';
        }
        $laststr .= '</pre>';
        file_put_contents($filename, $laststr);
        exit;
    }

}
