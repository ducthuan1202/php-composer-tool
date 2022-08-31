<?php

return [
    'env' => getenv('APP_ENV'),
    'timezone' => getenv('TIMEZONE'),
    'cookie_account' => [
        'name' => getenv('COOKIE_NAME'),
        'value' => getenv('COOKIE_VALUE'),
    ]
];
