<?php

namespace App\helpers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory;

class ValidatorHelper
{
    private static $factory;

    public static function make(array $data, array $rules, array $messages = [], array $customAttributes = [])
    {
        if (!self::$factory) {
            self::init();
        }

        return self::$factory->make($data, $rules, $messages, $customAttributes);
    }

    private static function init()
    {
        $filesystem = new Filesystem();
        $loader = new FileLoader($filesystem, __DIR__ . '/../../lang');
        $translator = new Translator($loader, 'pt_BR');

        self::$factory = new Factory($translator);
    }
}
