<?php

if (!function_exists('exception_handler')) {
    function exception_handler(Exception $exception)
    {
        echo sprintf(
            '<b>Exception (#%s)</b>: [%s]',
            $exception->getCode(),
            $exception->getMessage()
        ) . BREAK_LINE;
        exit();
    }
}

if (!function_exists('error_handler')) {
    function error_handler($errno, $errstr, $errfile, $errline)
    {
        echo sprintf('Error (#%s): [%s]', $errno, $errstr) . BREAK_LINE;
        echo sprintf("File: <b>%s:%s</b>", $errfile, $errline) . BREAK_LINE;
        exit();
    }
}