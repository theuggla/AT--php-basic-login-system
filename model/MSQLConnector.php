<?php

namespace model;

    class DBConnector {

        private static $connection;

        private function __construct() {
        }

        private static function connect(string $dbName) {
            $host = 'localhost';
            $user = $_ENV["MYSQL_USERNAME"];
            $password = $_ENV["MYSQL_PASSWORD"];
            self::$connection[$dbName] = mysqli_connect($host,$user,$password,$dbName);
        }

        public static function queryDB($query) {
            $result = mysqli_query(self::$connection, $query);
        }

        public static function getConnection($dbName) {
            if (self::$connection) {
                return self::$connection[$dbName];
            } else {
                self::connect($dbName);
                return self::$connection[$dbName];
            }
        }
    }