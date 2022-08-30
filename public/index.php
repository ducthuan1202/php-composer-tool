<?php

session_start();

# show all error
error_reporting(E_ALL);

# define variables
define('ROOT_PATH', dirname(__DIR__));
define('BREAK_LINE', '<br/>');

# autoload
include ROOT_PATH . './vendor/autoload.php';

# error handler
set_error_handler('error_handler');
set_exception_handler('exception_handler');

# load .env file
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(ROOT_PATH);
$dotenv->load();

# initial stackholders
Src\Config::initial();
Src\Database::initial();

# start application
$app = new Src\Application();
$app->start();
