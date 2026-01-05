<?php

namespace App\library;

class PostOld
{

    public static array $data;

    public static function init()
    {
        if (isset($_SESSION['old'])) {
            self::$data = $_SESSION['old'];
        }
    }

    public static function set(array $value)
    {
        $_SESSION['old'] = $value;
    }

    public static function get(string|array $key): string|array
    {
        self::init();
        if (is_array($key)) {
            return  array_map(self::get(...), $key);
        }

        return self::$data[$key];
    }

    public static function has(?string $key = null): bool
    {
        self::init();
        if (!in_array($key, [null, '', '0'], true)) {
            # code...
            return isset(self::$data[$key]);
        }

        return isset(self::$data);
    }

    public static function all()
    {
        self::init();
        if (PostOld::has()) {
            return self::$data;
        }

        return [];
    }

    public static function clean()
    {
        // self::init();

        unset($_SESSION['old']);
    }
}
