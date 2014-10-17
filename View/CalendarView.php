<?php

namespace view;

class CalendarView {

    private $month;
    private $year;
    private $htmlMonth;
    private $firstDayInMonth;
    private $dayOfTheWeek;
    private $events;
    private $currentDay;

    public function __construct(){
        $this->dayOfTheWeek = 1;
        $this->setMonth();
        $this->setYear();
        $this->firstDayInMonth = date('w', mktime(0, 0, 0, $this->month, 0, $this->year));
        $this->currentDay = date("j");
    }

    private function setYear(){
        if(isset($_GET[NavigationView::$actionYearToShow])){
            $this->year = $_GET[NavigationView::$actionYearToShow];
        } else{
            $this->year = date("Y");
        }
    }

    private function getNextYear(){
        if ($this->month == 12) {
            return $this->year + 1;
        }
        return $this->year;
    }

    private function getPreviousYear(){
        if($this->month == 1){
            return $this->year - 1;
        }
        return $this->year;
    }


    private function setMonth(){
        if(isset($_GET[NavigationView::$actionMonthToShow])){
            $this->month = $_GET[NavigationView::$actionMonthToShow];
            //$this->htmlMonth = date("F",mktime(0,0,0,$this->month));
        } else{
            $this->month = date("n");
        }
        $this->htmlMonth = strftime("%B",mktime(0,0,0,$this->month));
        $this->htmlMonth = ucfirst($this->htmlMonth);
    }

    private function getNextMonth(){
        if ($this->month < 12) {
            return $this->month + 1;
        } else {
            return 1;
        }
    }

    private function getPreviousMonth(){
        if($this->month > 1){
            return $this->month - 1;
        } else{
            return 12;
        }
    }

    /**
     * @return string HTML td columns with the days of a week
     */
    private function getWeekDays(){
        $days = array("Måndag", "Tisdag", "Onsdag", "Torsdag", "Fredag", "Lördag", "Söndag");
        $ret = "";

        for ($i = 0; $i < count($days); $i++) {
            $ret .= '<td class="day">' . $days[$i] . '</td>';
        }
        return $ret;
    }

    /**
     * @return string HTML td columns for first days without a date
     */
    private function getEmptyDays(){
        $ret = "";
        for ($i = 0; $i < $this->firstDayInMonth; $i++) {
            $ret .= '<td class="emptyDay"> </td>';
            $this->dayOfTheWeek++;
        }
        return $ret;
    }

    /**
     * @return string HTML td columns for last days without a date
     */
    private function getRemainingDays(){
        $ret = "";
        for ($i = 1; $i <= (8 - $this->dayOfTheWeek); $i++) {
            $ret .= '<td class="emptyDay"> </td>';
        }
        return $ret;
    }

    /**
     * @return string HTML with date columns/td and date boxes/div
     */
    private function getDates(){
        $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year);
        $dayCounter = 0;
        $ret = "";
        for ($i = 1; $i <= $numberOfDays; $i++) {
            $eventBox = $this->getEvents($i);
            if($i == $this->currentDay && $this->month == date("n")){
                $ret .= '<td class="currentDay">
                    <div class="dayNumber">' . $i . '
                      <p class="event">'.$eventBox . '</p>
                    </div>
                    </a>
                    </td>';
            } else {
                $ret .= '
                    <td class="calendarDay">
                    <div class="dayNumber">' . $i . '
                      <p class="event">' . $eventBox . '</p>
                    </div>
                    </a>
                    </td>
                    ';
            }

            //new row in table if we are on the last day
            //and reset day variables
            if ($this->firstDayInMonth >= 6) {
                $ret .= '</tr>';
                if ($dayCounter + 1 !== $numberOfDays) {
                    $ret .= '<tr class="row">';
                    $this->firstDayInMonth = -1;
                    $this->dayOfTheWeek = 0;
                }
            }
            $this->dayOfTheWeek++;
            $this->firstDayInMonth++;
            $dayCounter++;
        }
        return $ret;
    }

    /**
     * @return string with HTML containing the calendar
     */
    public function renderCalendar(){

        $calendar = "<table class='table'>";
        $calendar .= '<tr class="row">' . $this->getWeekDays() . '</tr>';
        $calendar .= '<tr class="row">' . $this->getEmptyDays();
        $calendar .= $this->getDates();

        if ($this->dayOfTheWeek < 8) {
            $calendar .= $this->getRemainingDays();
        }

        $calendar .= '</tr>';
        $calendar .= '</table>';

        $html = '
       <div id="menu">
        <a class="right" href="?action=logOut">Logga Ut</a>
           <a class="addEvent" href="?action='.NavigationView::$actionShowEventForm . '">
           Lägg till händelse
           </a>
           <a href="?action='.NavigationView::$actionShowEventList.'">Ändra en händelse</a>

           <a href="?action='.NavigationView::$actionShowEventList.'">Ta bort en händelse</a>
           <p></p>
           </div>
           <div id="navigation">
            <a class="right" href="?action='.NavigationView::$actionShowCalendar."&".
            NavigationView::$actionMonthToShow."=".$this->getNextMonth()."&".
            NavigationView::$actionYearToShow."=".$this->getNextYear().'">Nästa månad</a>

                <a class="left" href="?action='.NavigationView::$actionShowCalendar."&".
            NavigationView::$actionMonthToShow."=".$this->getPreviousMonth()."&".
            NavigationView::$actionYearToShow."=".$this->getPreviousYear().
            '">Föregående månad</a>
            </div>
           <div class="centerMonth">
           <div>
            <label>' . $this->year . '</label>' . '
             <label>' . $this->htmlMonth . '</label>' . '
             </div>
             </div>' .
            $calendar .'
        ';

        return $html;
    }

    private function getEvents($currentDay){
        $eventBox = "";
        foreach ($this->events as $event) {
            //var_dump($event->getDay());
            if ($event->getDay() == $currentDay && $event->getMonth() == $this->month) {
                $eventBox .= "<div class='eventBox'><a class='event' href='?action="
                    .NavigationView::$actionCalendarEvent . "&".
                    NavigationView::$actionShowEvent ."=". $event->getTitle() . "'>
                           <h4 class='event'>'" . $event->getTitle() . "'</h4></a></div>";
            }
        }
        return $eventBox;

    }

    public function setEvents($events){
        $this->events = $events;

    }

}