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
        $days = array("Måndag", "Tisdag", "Onsdag", "Torsdag", "Fredag", "Lördag", "Söndag");
        $dateBox="";

        for($i = 1; $i <= $numberOfDays; $i++){
            $dateBox .= "
            <div class='box'>
                <p class='center'>$i</p>
            </div>
            ";
        }
        $html = "


            <p class='centerMonth'>$this->htmlMonth $this->year</p>
            <div class='days'>
               <label>Måndag</label>
               <label class='day'>Tisdag</label>
               <label class='day'>Onsdag</label>
               <label class='day'>Torsdag</label>
               <label class='day'>Fredag</label>
               <label class='day'>Lördag</label>
               <label class='day'>Söndag</label>
            </div>
            $dateBox
        ";

        return $html;
    }
}