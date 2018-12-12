<?php

session_start();

error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once("controller/PlayGame.php");
require_once("view/HTMLPage.php");
require_once("model/LastStickGame.php");
require_once("model/StickGameObserver.php");
require_once("view/GameView.php");
require_once("model/StickSelection.php");
require_once("model/AIPlayer.php");
require_once("model/PersistantSticks.php");

$controller = new controller\PlayGame();

$body = $controller->runGame();

$page = new view\HTMLPage();

echo $page->getPage("Game of sticks", $body);




