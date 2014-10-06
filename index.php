<?php

use controller\NavigationController;
use view\HtmlView;

require_once("./ImportFiles.php");

session_start();

$htmlView = new HtmlView();
$navigationController = new NavigationController();
$htmlView->echoHTML($navigationController->renderView());