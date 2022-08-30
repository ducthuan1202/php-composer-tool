<?php

namespace Src;

class Config
{
    private static $entries = [];

    public static function initial()
    {
        $files = glob(ROOT_PATH . './configs/*.php');
        foreach ($files as $file) :
            $name = basename($file, '.php');
            self::$entries[$name] = require_once $file;
        endforeach;
    }

    public static function get($key, $def = null)
    {
        if (array_key_exists($key, self::$entries)) {
            return self::$entries[$key];
        }
        return $def;
    }
}
