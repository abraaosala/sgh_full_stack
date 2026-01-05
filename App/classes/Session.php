<?php

namespace App\classes;


class Session
{
    public static function set($key, $value)
    {
        $_SESSION['logado'][$key] = $value;
    }

    public static function multiSet($data)
    {
        $_SESSION['logado'] = $data;
    }

    public static function get($key)
    {
        return $_SESSION['logado'][$key];
    }

    public static function has()
    {
        return isset($_SESSION['logado']);
    }

    public static function dump()
    {
        dd($_SESSION['logado']);
    }

    public static function destroy()
    {
        return session_destroy();
    }

    public static function all()
    {
        return $_SESSION['logado'];
    }

    public function destruct()
    {
        session_destroy();
    }
}