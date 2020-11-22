<?php

    namespace Core;

    use Illuminate\Database\Capsule\Manager;

    class Database
    {
        public function __construct(){
            require_once "config/database.php";

            $capsule = new Manager();
            $capsule->addConnection([
                'driver'    => $database['driver'],
                'host'      => $database['host'],
                'database'  => $database['basename'],
                'username'  => $database['username'],
                'password'  => $database['password'],
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix'    => '',
            ]);

            $capsule->bootEloquent();
        }
    }