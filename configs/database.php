<?php

return [
    'driver' => getenv('DB_DRIVER'),
    'host' => getenv('DB_HOST'),
    'dbname' => getenv('DB_NAME'),
    'user' => getenv('DB_USER'),
    'password' => getenv('DB_PASS'),
    'port' => getenv('DB_PORT'),
    'charset' => getenv('DB_CHARSET'),
];
