<?php
require "vendor/autoload.php";
safeEnv();

return
[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'production' => [
            'adapter' => 'mysql',
            'host' => 'localhost',
            'name' => 'production_db',
            'user' => 'root',
            'pass' => '',
            'port' => '3306',
            'charset' => 'utf8',
        ],
        /* 'development' => [
            'adapter' => 'mysql',
            'host' => 'localhost',
            'name' => 'db_sgh',
            'user' => 'root',
            'pass' => '',
            'port' => '3306',
            'charset' => 'utf8',
        ] */
         'development' => [
            'adapter' => env("DB_ADAPTER",'mysql'),
            'host' => env("DB_HOST",'localhost'),
            'name' => env("DB_NAME",'sgh'),
            'user' => env('DB_USER', 'root'),
            'pass' => env('DB_PASS',''),
            'port' => env('DB_PORT', '3306'),
            'charset' => env('DB_CHARSET','utf8'),
        ],
        'testing' => [
            'adapter' => 'mysql',
            'host' => 'localhost',
            'name' => 'testing_db',
            'user' => 'root',
            'pass' => '',
            'port' => '3306',
            'charset' => 'utf8',
        ]
    ],
    'version_order' => 'creation'
];
