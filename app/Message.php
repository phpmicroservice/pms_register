<?php
namespace app;
/**
 * Created by PhpStorm.
 * User: saisai
 * Date: 17-6-28
 * Time: 下午2:52
 */
class Message
{
    public static function demo($ws, $frame)
    {
        echo "Message: {$frame->data}\n";
        static $to=1;
        $to++;
        $ws->push($frame->fd, "server-6-: {$frame->data}-".$to);
    }

}