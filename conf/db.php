<?php

// array de de Constante de MYsql
define('MY', [
    'HOST' => env('DATABASE_HOST'),
    'NAME' => env('DATABASE_NAME'),
    'USER' => env('DATABASE_USER'),
    'PASS' => env('DATABASE_PASSWORD'),
]);



/* 
define('MY', [
    'HOST' => env('DATABASE_HOST','localhost')  ,
    'NAME' => env('DATABASE_NAME', 'school')  ,
    'USER' => env('DATABASE_USER', 'root')  ,
    'PASS' => env('DATABASE_PASSWORD', '')
]);
*/
const DATA_LAYER_CONFIG = [
    "driver" => "mysql",
    "host" => MY['HOST'],
    "port" => "3306",
    "dbname" => MY['NAME'],
    "username" => MY['USER'],
    "passwd" => "",
    "options" => [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ]
];
