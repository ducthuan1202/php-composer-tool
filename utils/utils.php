<?php

if (!function_exists('is_prod')) {
    function is_prod()
    {
        return in_array(strtolower(getenv('APP_ENV')), ['prod', 'production']);
    }
}

if (!function_exists('exception_handler')) {
    function exception_handler(Exception $exception)
    {
        if (is_prod()) {
            exit('Ooops, something went wrong!');
        }

        echo sprintf(
            '<h3>Exception (#%s): [%s]</h3>',
            $exception->getCode(),
            $exception->getMessage()
        );

        echo sprintf(
            '<p>File: %s at line %s</p>',
            $exception->getFile(),
            $exception->getLine()
        );

        echo '<kbd>' . $exception->getTraceAsString() . '</kbd>';

        exit();
    }
}

if (!function_exists('error_handler')) {
    function error_handler($errno, $errstr, $errfile, $errline)
    {
        if (is_prod()) {
            exit('Ooops, something went wrong!');
        }

        echo sprintf('<h3>Error (#%s): [%s]</h3>', $errno, $errstr);

        echo sprintf("<p>File: %s at line %s</p>", $errfile, $errline);

        exit();
    }
}

if (!function_exists('arr_get_value')) {
    function arr_get_value(array $arr, string $key, $def = null)
    {
        if (array_key_exists($key, $arr)) {
            return $arr[$key];
        }

        if (is_numeric(strpos($key, '.'))) {

            $keys = explode('.', $key);

            $firstKey = current($keys);
            $lastKey = $keys[count($keys) - 1];

            if (!array_key_exists($firstKey, $arr)) {
                return $def;
            }

            $tmp = $arr[$firstKey];

            foreach ($keys as $k) :

                if ($k === $firstKey) {
                    continue;
                }

                if ($k === $lastKey) {
                    return $tmp[$k];
                }

                if (!array_key_exists($k, $tmp)) {
                    return $def;
                }

                $tmp = $tmp[$k];

            endforeach;

            return $tmp;
        }

        return $def;
    }
}

if (!function_exists('config')) {
    function config(string $key, $def = null)
    {
        return arr_get_value(Src\Config::all(), $key, $def);
    }
}
