<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once('controller/LoggedOutUserController.php');
require_once('controller/LoggedInUserController.php');

$isLoggedIn = $_SESSION ? $_SESSION["isLoggedIn"] ? $_SESSION["isLoggedIn"] : false : false;

$loggedIn = new LoggedInUserController();
$loggedOut = new LoggedOutUserController();

if ($isLoggedIn) {
    $loggedIn->greetUser();
}
else {
    $loggedOut->greetUser();
}

?>