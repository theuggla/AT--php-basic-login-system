<?php
session_start();
$isLoggedIn = $_SESSION ? $_SESSION["isLoggedIn"] : false;

//INCLUDE THE FILES NEEDED...
require_once('loginiew/Loginloginiew.php');
require_once('loginiew/DateTimeloginiew.php');
require_once('loginiew/Layoutloginiew.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//CREATE OBJECTS OF THE VIEWS
$loggedInView = new LoggedInView();
$dateTime = new DateTimeView();
$layout = new LayoutView();

if ($isLoggedIn) {
    $layout->render($loggedInView, $dateTime);
}
else {
    $layout->render($loggedOutView, $dateTime);
}

?>