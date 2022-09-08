<?php

namespace Src;

use Symfony\Component\Yaml\Yaml;
class Config
{
    private static $entries = [];

    public static function initial()
    {
        $values = Yaml::parseFile(ROOT_PATH . '/configs.yaml');
        self::$entries = array_merge_recursive(self::$entries, $values);
        
        $envValues = [];
        $files = glob(ROOT_PATH . './configs/*.php');
        foreach ($files as $file) :
            $name = basename($file, '.php');
            $envValues[$name] = require_once $file;
        endforeach;

        # merge and overide values
        self::$entries = array_replace_recursive(self::$entries, $envValues);
    }

    public static function all()
    {
        return self::$entries;
    }

    public static function get($key, $def = null)
    {
        return Arr::get(self::$entries, $key, $def);
        return arr_get_value(self::$entries, $key, $def);
    }
}
