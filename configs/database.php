<?php

return [
    'driver' => 'pdo_mysql',
    'host' => getenv('DB_HOST'),
    'dbname' => getenv('DB_NAME'),
    'user' => getenv('DB_USER'),
    'password' => getenv('DB_PASS'),
];
