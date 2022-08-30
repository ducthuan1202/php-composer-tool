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
            '<p>%s:%s</p>',
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
        echo sprintf('Error (#%s): [%s]', $errno, $errstr) . BREAK_LINE;
        echo sprintf("File: <b>%s:%s</b>", $errfile, $errline) . BREAK_LINE;
        exit();
    }
}
