<?php
require_once("View/HtmlView.php");
require_once("View/CalendarView.php");
require_once("View/ErrorView.php");
require_once("Controller/EventController.php");

session_start();

$htmlView = new view\HtmlView();
$calendarView = new view\CalendarView();
$errorView = new view\ErrorView();

$eventController = new controller\EventController();

try {
    $htmlView->echoHTML($calendarView->renderCalendar());
} catch (Exception $e) {
    $htmlView->echoHTML($errorView->renderErrorPage());
}