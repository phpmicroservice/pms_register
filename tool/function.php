<?php
/**
 * 获取环境变量的方法
 * @param $name
 * @param string $default
 * @return array|false|string
 */
function get_env($name, $default = '')
{
    return getenv(strtoupper($name)) === false ? $default : getenv(strtoupper($name));
}

function output($data,$msg='info')
{
    echo '['.date('H:i:s').']['.$msg.']';
    if(is_string($data)){
        echo $data;
    }else{
        echo var_export($data,true);
    }
    echo " \n";

}

function dump()
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
 *
 * @param int $num
 * @return array|mixed
 */
function debug_24($num=-1)
{
    $arr = [];
    $debug = debug_backtrace();
    foreach ($debug as $k => $value) {
        $vattt = [
            'function' => $value['function'],
            'args' => func_get_args222($value['args'])
        ];
        if (isset($value['class'])) {
            $vattt['class'] = $value['class'];
        }
        if (isset($value['type'])) {
            $vattt['type'] = $value['type'];
        }
        if (isset($value['line'])) {
            $vattt['line'] = $value['line'];
        }
        if (isset($value['file'])) {
            $vattt['file'] = $value['file'];
        }
        $arr[] = $vattt;
    }
    if($num>-1){
        return $arr[$num];
    }
    return $arr;
}

function prl()
{
    $logger = \Phalcon\Di::getDefault()->get('logger');
    $logger->info(print_r(func_get_args(), true));

}

function func_get_args222($data)
{

    foreach ($data as &$v) {

        if (is_object($v)) {
            $v = [
                'class' => get_class($v)
            ];

        } else {

        }
    }
    return $data;
}

function prrr(){
    return json_encode(func_get_args());
}

/**
 * 计时停止
 * @param $val
 * @param int $number
 * @return bool
 */
function prn($val,$number=1){

    if (!\APP_DEBUG) {
        return false;
    }

    static $arfr=0;
    $arfr++;
// $argsNum = func_num_args(); //获取参数个数
    $args = $val;
    $debugArr = debug_backtrace();
    $timeArr = explode(' ', microtime());
    echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
    echo "<pre  style='color:red'><hr><hr>【调用文件】:", $debugArr [0] ['file'], '<br/>【调用行号】:', $debugArr [0] ['line'], '<br/>';
    echo '【调用时间】:', date('Y-m-d H:i:s ', $timeArr[1]), $timeArr[0], '<hr>';
    foreach ($args as $k => $v) {
        $getType = gettype($v);
        if ($getType == 'object') {
            echo '【变量序号】:', $k + 1, '<br/>【变量类型】:', $getType, ' 仅仅输出了公开属性<br/>';
            $string= print_r($v,true);

            echo substr($string,0,50) .'<br/><br/><br/>';;
            $v1=get_object_vars($v);
            var_dump($v1);

        } else {
            echo '【变量序号】:', $k + 1, '<br/>【变量类型】:', $getType, '<br/>';
            'boolean' == $getType ? var_dump($v) : var_dump($v);
            echo '<hr>';
        }

    }
    echo '<hr></pre>';
    if($arfr>$number){
        exit;
    }

}

/**
 * 测试函数 执行完退出 可以传入任意个参数,只在调试模试下执行
 * @author 李海涛 <QQ:596845798>
 */
function pre()
{
    if (!\APP_DEBUG) {
        return false;
    }

// $argsNum = func_num_args(); //获取参数个数
    $args = func_get_args();
    $debugArr = debug_backtrace();
    $timeArr = explode(' ', microtime());
    echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
    echo "<pre  style='color:red'><hr><hr>【Call the file】:", RUN_UNIQID . ' ', $debugArr [0] ['file'], '<br/>【调用行号】:', $debugArr [0] ['line'], '<br/>';
    echo '【调用时间】:', date('Y-m-d H:i:s ', $timeArr[1]), $timeArr[0], '<hr>';
    foreach ($args as $k => $v) {
        $getType = gettype($v);
        if ($getType == 'object') {
            echo '【变量序号】:', $k + 1, '<br/>【变量类型】:', $getType, ' 仅仅输出了公开属性<br/>';
            if (is_object($v)) {
                $string = '对象不予输出,name:' . get_class($v);
            } else {
                $string = print_r($v, true);
            }


            echo $string . '<br/><br/><br/>';;
            $v1=get_object_vars($v);
            var_dump($v1);

        } else {
            echo '【变量序号】:', $k + 1, '<br/>【变量类型】:', $getType, '<br/>';
            'boolean' == $getType ? var_dump($v) : var_dump($v);
            echo '<hr>';
        }

    }
    echo '<hr></pre>';
    exit;
}


/**
 * 测试函数 执行完退出 可以传入任意个参数,只在调试模试下执行
 * @author 李海涛 <QQ:596845798>
 */
function pre2()
{
    if (!\APP_DEBUG) {
        return false;
    }

// $argsNum = func_num_args(); //获取参数个数
    $args     = func_get_args();
    $timeArr  = explode(' ', microtime());
    $debugArr = debug_backtrace();
    echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
    echo "<pre  style='color:red'><hr><hr>【调用文件】:", RUN_UNIQID . ' ', $debugArr [0] ['file'], '<br/>【调用行号】:', $debugArr [0] ['line'], '<br/>';
    echo '【调用时间】:', date('Y-m-d H:i:s ', $timeArr[1]), $timeArr[0], '<hr>';
    foreach ($args as $k => $v) {
        $getType = gettype($v);
        echo '【变量序号】:', $k + 1, '<br/>【变量类型】:', $getType, '<br/>';
        'boolean' == $getType ? var_dump($v) : print_r($v);
        echo '<hr>';
    }
    echo '<hr></pre>';
    echo '<hr></pre>';
    exit;
}

/**
 * 测试函数 执行完退出 可以传入任意个参数,只在调试模试下执行
 * @author 李海涛 <QQ:596845798>
 */
function pre2d()
{
    if (!isset($_GET['d'])) {
        return false;
    }

// $argsNum = func_num_args(); //获取参数个数
    $args = func_get_args();
    $timeArr = explode(' ', microtime());
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
    echo '<hr></pre>';
    exit;
}


/**
 * 测试函数 执行完不退出 可以传入任意个参数,只在调试模试下执行
 * @author 李海涛 <QQ:596845798>
 */
function pr()
{
    if (!APP_DEBUG)
        return false;
// $argsNum = func_num_args(); //获取参数个数
    $args     = func_get_args();
    $timeArr  = explode(' ', microtime());
    $debugArr = debug_backtrace();
    echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
    echo "<pre  style='color:red'><hr><hr>【调用文件】:", RUN_UNIQID . ' ', $debugArr [0] ['file'], '<br/>【调用行号】:', $debugArr [0] ['line'], '<br/>';
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
function prw()
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
function praw()
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
function prew()
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
function svar(){
    return json_encode(func_get_args());
}
