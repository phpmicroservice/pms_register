<?php

use Phalcon\Db\Column as Column;
use Phalcon\Db\Index;

return  [
    'tableName' => 'z_qqqq',
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
        ],
        'indexes' => [
            new Index('name', ['name'], 'UNIQUE'),
        ],
        'references' => [
            new \Phalcon\Db\Reference(
                "z_21_id_re_z_1_id",
                [
                    "referencedSchema" => "wugengji",
                    "referencedTable" => "z_1",
                    "columns" => [
                        "id_re",
                    ],
                    "referencedColumns" => [
                        "id",
                    ],
                ]),
        ],
    ],
];