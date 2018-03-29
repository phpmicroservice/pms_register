<?php

use Phalcon\Db\Column as Column;
use Phalcon\Db\Index;

return [
    'tableName' => 'log',
    'schemaName' => null,
    'field' => [
        "columns" => [
            new Column(
                "id",
                [
                    "type" => Column::TYPE_INTEGER,
                    "size" => 11,
                    "notNull" => true,
                    "autoIncrement" => true,
                    "primary" => true,
                ]
                # 自增字段
            ),
            new Column(
                'content',
                [
                    "type" => Column::TYPE_TEXT,
                    "notNull" => true
                ]
            ),
            new Column(
                "type37",
                [
                    "type" => Column::TYPE_INTEGER,
                    "size" => 11,
                    "notNull" => true,
                ]
            ),
            new Column(
                "time",
                [
                    "type" => Column::TYPE_INTEGER,
                    "size" => 11,
                    "notNull" => true,
                    'default'=>999
                ]
            ),

        ],
        'indexes'=>[
            new Index (null, [null], 'UNIQUE'),
            ]
    ],
];