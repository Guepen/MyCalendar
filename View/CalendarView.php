<?php

namespace view;

class CalendarView{
    private $month = 9;
    private $year = 2014;

    public function __construct(){}

    public function renderCalendar(){
        $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year);
        $dateBox="";

        for($i = 1; $i <= $numberOfDays; $i++){
            $dateBox .= "
            <div class='box'>
                <p class='center'>$i</p>
            </div>
            ";
        }
        $html = "
        <div id='Container'>
            <h1 class='center'>MyCalendar</h1>
            $dateBox
        </div>
        ";

        return $html;
    }
}