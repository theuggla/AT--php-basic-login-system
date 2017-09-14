<?php
session_start();
$_SESSION['isLoggedIn'] = true;
//Set session variable
$isLoggedIn = $_SESSION ? $_SESSION["isLoggedIn"] : false;

//INCLUDE THE FILES NEEDED...
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//CREATE OBJECTS OF THE VIEWS
$v = new LoginView();
$dtv = new DateTimeView();
$lv = new LayoutView();


$lv->render($isLoggedIn, $v, $dtv);

echo '<html><head><title>Test MySQL</title></head><body>';
var_dump($_ENV);
var_dump($_SERVER);
$host = 'localhost';
$user = $_ENV["MYSQL_USERNAME"];
$password = $_ENV["MYSQL_PASSWORD"];
$cxn = mysqli_connect($host,$user,$password);
$sql='SHOW DATABASES';
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
?>