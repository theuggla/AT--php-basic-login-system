<?php

namespace model;

    class DBConnector {
        public function connect(string $dbName) {
            $host = 'localhost';
            $user = $_ENV["MYSQL_USERNAME"];
            $password = $_ENV["MYSQL_PASSWORD"];
            $cxn = mysqli_connect($host,$user,$password, $dbName);
            $sql='SHOW tables';
            $result = mysqli_query($cxn,$sql);
        }
    }
?>