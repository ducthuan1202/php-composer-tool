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
        return Src\Arr::get(Src\Config::all(), $key, $def);
        # return arr_get_value(Src\Config::all(), $key, $def);
    }
}

if (!function_exists('value')) {
    /**
     * Return the default value of the given value.
     *
     * @param  mixed  $value
     * @return mixed
     */
    function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
}

if (!function_exists('data_get')) {
    /**
     * Get an item from an array or object using "dot" notation.
     *
     * @param  mixed  $target
     * @param  string|array|int|null  $key
     * @param  mixed  $default
     * @return mixed
     */
    function data_get($target, $key, $default = null)
    {
        if (is_null($key)) {
            return $target;
        }

        $key = is_array($key) ? $key : explode('.', $key);

        foreach ($key as $i => $segment) {
            unset($key[$i]);

            if (is_null($segment)) {
                return $target;
            }

            if ($segment === '*') {
                if (!is_array($target)) {
                    return value($default);
                }

                $result = [];

                foreach ($target as $item) {
                    $result[] = data_get($item, $key);
                }

                return in_array('*', $key) ? Src\Arr::collapse($result) : $result;
            }

            if (Src\Arr::accessible($target) && Src\Arr::exists($target, $segment)) {
                $target = $target[$segment];
            } elseif (is_object($target) && isset($target->{$segment})) {
                $target = $target->{$segment};
            } else {
                return value($default);
            }
        }

        return $target;
    }
}
