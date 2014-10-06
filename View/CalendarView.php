<?php

namespace view;

class CalendarView{
    private $month;
    private $year;
    private $htmlMonth;
    private $firstDayInMonth;
    private $dayOfTheWeek;

    public function __construct(){
        $this->month = date("n");
        $this->year = date("Y");
        $this->htmlMonth = date("F");
        $this->firstDayInMonth = date('w',mktime(0,0,0,$this->month,1,$this->year));
        $this->dayOfTheWeek = 1;
    }

    /**
     * @return string HTML td columns with the days of a week
     */
    public function getCalendarDays(){
        $days = array("Måndag", "Tisdag", "Onsdag", "Torsdag", "Fredag", "Lördag", "Söndag");
        $ret="";

        for($i = 0; $i < count($days); $i++){
            $ret .= '<td class="day">'.$days[$i].'</td>';
        }
        return $ret;
    }

    /**
     * @return string HTML td columns for first days without a date
     */
    public function getEmptyDays(){
        $ret="";
        for($i = 0; $i < $this->firstDayInMonth; $i++){
            $ret.= '<td class="emptyDay"> </td>';
            $this->dayOfTheWeek++;
        }
        return $ret;
    }

    /**
     * @return string HTML td columns for last days without a date
     */
    public function getRemainingDays(){
        $ret="";
        for($i = 1; $i <= (8 - $this->dayOfTheWeek); $i++){
            $ret .= '<td class="emptyDay"> </td>';
        }
        return $ret;
    }

    /**
     * @return string HTML with date columns/td and date boxes/div
     */
    public function getDates(){
        $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year);
        $dayCounter = 0;
        $ret="";

        for($i = 1; $i <= $numberOfDays; $i++){
            $ret.= '
                    <td class="calendarDay">
                     <a href="?action='.NavigationView::$actionShowCalendar.'&'.
                                        NavigationView::$actionCalendarDay.'='.$i.'">

                    <div class="dayNumber">'.$i.'</div>
                    </a>
                    </td>
                    ';

            //new row in table if we are on the last day
            //and reset day variables
            if($this->firstDayInMonth === 6){
                $ret .= '<tr class="calendar-row">';
                $this->firstDayInMonth = -1;
                $this->dayOfTheWeek = 0;
            }
            $this->dayOfTheWeek++;
            $this->firstDayInMonth++;
            $dayCounter++;
        }
        return $ret;
    }

    public function renderCalendar(){

        $calendar = "<table cellpadding='0' cellspacing='0' class='calendar'>";
        $calendar .= '<tr class="row">'.$this->getCalendarDays().'</tr>';
        $calendar .= '<tr class="row">'.$this->getEmptyDays();
        $calendar .= $this->getDates();

        if($this->dayOfTheWeek < 8){
          $calendar .= $this->getRemainingDays();
        }

        $calendar.= '</tr>';
        $calendar.= '</table>';

        //if user has clicked a date
        if(isset($_GET[NavigationView::$actionCalendarDay]) === true){
            $this->renderModal();
        }

        $html = '
            <p class="centerMonth">'.$this->htmlMonth. $this->year.'</p>'.
            $calendar.'
        ';

        return $html;
    }

    public function renderModal(){
        $modal = "
                 <div class='modal'>
                    <div class='day'>
                      <p>dag</p>
                      </div>
                      </div>
        ";

        return $modal;
    }
}