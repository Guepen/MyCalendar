<?php

namespace controller;

use view\CalendarView;

class CalendarController{
    private $calendarView;

    public function __construct(){
        $this->calendarView = new CalendarView();
    }

    public function render(){
        return $this->calendarView->renderCalendar();
    }

}