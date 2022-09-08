<?php

namespace Src;

use Doctrine\DBAL\DriverManager;

class Database
{
    private static $conn;

    public static function initial()
    {
        $dbConfig = config('database');
        self::$conn = DriverManager::getConnection($dbConfig);
    }

    public static function getConnect()
    {
        if (!self::$conn) {
            self::initial();
        }
        return self::$conn;
    }

    public static function getQueryBuilder()
    {
        return self::getConnect()->createQueryBuilder();
    }
}
