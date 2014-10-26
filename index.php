<?php

use controller\NavigationController;
use view\HtmlView;

require_once("./ImportFiles.php");

session_start();
setlocale(LC_ALL, "sv_SE.utf8");

$htmlView = new HtmlView();
$navigationController = new NavigationController();
$htmlView->echoHTML($navigationController->renderView());