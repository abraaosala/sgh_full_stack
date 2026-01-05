<?php

declare(strict_types=1);

namespace App\utils;

class Str
{
    public static function implode(array $array , string $separator= ''):string
    {
        return implode($separator, $array);
    }
}