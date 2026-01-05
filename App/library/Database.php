<?php

namespace App\library;

use Illuminate\Database\Capsule\Manager as Capsule;

class Database
{
    public function init(): void
    {
        $capsule = new Capsule;

        $capsule->addConnection([
            'driver'    => env('DB_ADAPTER', 'mysql'),
            'host'      => env('DB_HOST', 'localhost'),
            'database'  => env('DB_NAME', 'sgh'),
            'username'  => env('DB_USER', 'root'),
            'password'  => env('DB_PASS', ''),
            'charset'   => env('DB_CHARSET', 'utf8'),
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'port'      => env('DB_PORT', '3306'),
        ]);

        // Make this Capsule instance available globally via static methods... (optional)
        $capsule->setAsGlobal();

        // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
        $capsule->bootEloquent();
    }
}
