<?php
/**
 * Created by PhpStorm.
 * User: Dongasai
 * Date: 2018/3/27
 * Time: 16:59
 */

use Phalcon\Db\Column as Column;
use Phalcon\Db\Index;

return [
    'tableName' => 'z_1',
    'schemaName' => null,
    'field' => [
        "columns" => [
            new Column(
                "id",
                [
                    "type" => Column::TYPE_INTEGER,
                    "size" => 10,
                    "notNull" => true,
                    "autoIncrement" => true,
                    "primary" => true,
                ]
            ),
            new Column(
                'id_re',
                [
                    "type" => Column::TYPE_INTEGER,
                    "size" => 10,
                    "notNull" => true
                ]
            ),
            new Column(
                "name",
                [
                    "type" => Column::TYPE_VARCHAR,
                    "size" => 70,
                    "notNull" => true,
                ]
            ),
            new Column(
                "year",
                [
                    "type" => Column::TYPE_INTEGER,
                    "size" => 11,
                    "notNull" => true,
                ]
            ),
            new Column(
                "years",
                [
                    "type" => Column::TYPE_INTEGER,
                    "size" => 11,
                    "notNull" => true,
                ]
            ),
            new Column(
                "year2",
                [
                    "type" => Column::TYPE_INTEGER,
                    "size" => 11,
                    "notNull" => true,
                    'default'=>999
                ]
            ),
            new Column(
                "year3",
                [
                    "type" => Column::TYPE_INTEGER,
                    "size" => 11,
                    "notNull" => true,
                    'default'=>999
                ]
            ),
        ],
        'indexes' => [
            new Index('name', ['name'], 'UNIQUE'),
        ],
    ],
];