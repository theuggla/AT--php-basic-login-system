<?php

namespace site\persistance;

class MSQLConnector
{
    private static $connection;
    private static $host = 'localhost';
    private static $mysqlUsername = "MYSQL_USERNAME";
    private static $mysqlPassword = "MYSQL_PASSWORD";

    private static function connect(string $dbName)
    {
        $host = self::$host;
        $user = $_ENV[self::$mysqlUsername];
        $password = $_ENV[self::$mysqlPassword];
        self::$connection[$dbName] = mysqli_connect($host, $user, $password, $dbName);
    }

    public static function queryDB(string $query)
    {
        $result = mysqli_query(self::$connection, $query);
    }

    public static function getConnection(string $dbName)
    {
        if (self::$connection) {
            return self::$connection[$dbName];
        } else {
            self::connect($dbName);
            return self::$connection[$dbName];
        }
    }
}
