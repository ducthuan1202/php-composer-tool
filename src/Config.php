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

    public static function all()
    {
        return self::$entries;
    }

    public static function get($key, $def = null)
    {
        return arr_get_value(self::$entries, $key, $def);
    }
}
