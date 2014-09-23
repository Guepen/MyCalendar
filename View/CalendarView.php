<?php

namespace view;

class CalendarView{
    private $month;
    private $year;
    private $htmlMonth;

    public function __construct(){
        $this->month = date("n");
        $this->year = date("Y");
        $this->htmlMonth = date("F");
    }

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
            <p class='center'>$this->htmlMonth $this->year</p>
            $dateBox
        </div>
        ";

        return $html;
    }
}