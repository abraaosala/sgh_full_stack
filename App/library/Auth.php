<?php

namespace App\library;

class Auth
{
    public static $name = 'auth';

    protected static $user_auth ;

    protected static $permitions = [

    ];



    private static function init()
    {
        if (isset($_SESSION[self::$name])) {
            self::$user_auth = $_SESSION[self::$name];
        }
    }

    public static function set(string $key, string $value)
    {
        //init
        self::init();
        self::$user_auth[$key]= $value;

        $_SESSION[self::$name]= self::$user_auth;



    }

    public static function get($key){
        self::init();
        return self::$user_auth[$key];
    }

    public static function has(){
        self::init();
        return isset(self::$user_auth);
    }

    public static function clean (){
        unset($_SESSION[self::$name]);
    }

    public static function forget(string $key){


        unset($_SESSION[self::$name][$key]);

    }

    public static function  can($acao){
        //perfil
        $perfil = self::$user_auth['level'] ??[];

        return in_array($acao, self::$permitions[$perfil]??[]);
    }


}
