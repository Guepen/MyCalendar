<?php

require_once("./ImportFiles.php");

session_start();

$htmlView = new \view\HtmlView();
$navigationController = new \controller\NavigationController();
$htmlView->echoHTML($navigationController->renderView());