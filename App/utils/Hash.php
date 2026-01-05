<?php

declare(strict_types=1);

namespace App\utils;

class Hash
{
    public static function make($password, $algo = PASSWORD_DEFAULT, $options=[]):string
    {
        return password_hash((string) $password, $algo, $options);
    }

    public static function check(string $password, string $hash):bool{
        return password_verify($password, $hash);
    }

    public static function needsRehash(string $hash, string|int|null $algo, array $options = [])
    {
      return password_needs_rehash($hash, $algo, $options);   
    }
}