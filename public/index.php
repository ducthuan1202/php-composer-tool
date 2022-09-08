<?php

use Src\Config;

session_start();

# show all error
error_reporting(E_ALL);

# check version
if(version_compare(PHP_VERSION, '7.0.0', '<')){
    exit('upgrade php version');
}

# check mode
if(PHP_SAPI === 'cli'){
    exit('php sapi invalid');
}

# define variables
define('ROOT_PATH', dirname(__DIR__));

# autoload
include ROOT_PATH . './vendor/autoload.php';

# error handler
set_error_handler('error_handler');
set_exception_handler('exception_handler');

# load .env file
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(ROOT_PATH);
$dotenv->load();

# initial stakeholders
Src\Config::initial();
Src\Database::initial();
dd(Config::all());

date_default_timezone_set(config('app.timezone'));

# start application
$app = new Src\Application();
$app->start();
