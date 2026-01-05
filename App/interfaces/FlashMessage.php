<?php

namespace App\interfaces;

interface FlashMessage
{
    public function set($key, $value): never;

    public function get($key):string|array;

    public function dump():array;

    public function display();

    public function has():bool;

    public function haskey():bool;

}
