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

            if($result == false)
{
    echo '<h4>Error: '.mysqli_error($cxn).'</h4>';
}
else
{
if(mysqli_num_rows($result) < 1)
{
    echo '<p>No current databases</p>';
}
else
{
    echo '<ol>';
while($row = mysqli_fetch_row($result))
{
    echo '<li>' . $row[0] . '</li>';
}
    echo '</ol>';
}
}
    echo '</body></html>';
        }
    }
?>