<?php
namespace controller;

require_once("./View/HtmlView.php");
require_once("./View/CalendarView.php");
require_once("./View/ErrorView.php");


class CalendarController{
    private $htmlView;
    private $calendarView;
    private $errorView;
    public function __construct(){
        $this->htmlView = new \view\HtmlView();
        $this->calendarView = new \view\CalendarView();
        $this->errorView = new\view\ErrorView();
    }

    public function doController(){
        $this->render();
    }

    public function render(){
        try{
            $this->htmlView->echoHTML($this->calendarView->renderCalendar());
        }catch (\Exception $e){
            $this->errorView->renderErrorPage();
        }
    }

}