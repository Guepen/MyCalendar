<?php

require_once("Controller/CalendarController.php");

session_start();

$eventController = new controller\CalendarController();
$eventController->doController();
