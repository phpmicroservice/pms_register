<?php

namespace app\table;
/**
 * Class server
 */
class serverPing extends \pms\bear\Table
{
    protected $size = 4096;# 表最大行数
    protected $column = [
        [
            'name' => 'number',
            'type' => \Swoole\Table::TYPE_INT,
            'size' => 8
        ]
    ];
    protected $swoole_table;
}