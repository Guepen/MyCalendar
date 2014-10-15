<?php

namespace view;

class CalendarView {

    private $month;
    private $year;
    private $htmlMonth;
    private $firstDayInMonth;
    private $dayOfTheWeek;
    private $events;

    public function __construct(){
        $this->year = date("Y");
        $this->dayOfTheWeek = 1;
        $this->setMonth();
        $this->htmlMonth = date("F");
        $this->firstDayInMonth = date('w', mktime(0, 0, 0, $this->month, 0, $this->year));
    }

    private function setMonth(){
        if(isset($_GET[NavigationView::$actionMonthToShow])){
            $this->month = $_GET[NavigationView::$actionMonthToShow];
            if ($this->month <= 12){
                var_dump($this->month);
            } else{
                var_dump("esfdx");
                $this->month = 1;
            }
        } else{
            $this->month = date("n");
        }
    }

    private function getNextMonth(){
        if ($this->month <= 12) {
            return $this->month + 1;
        } else {
            $this->year = date("Y",strtotime("+1 year"));
            var_dump($this->year);
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
            $ret .= '
                    <td class="calendarDay">
                    <div class="dayNumber">' . $i . '
                      <p class="event">'.$eventBox . '</p>
                    </div>
                    </a>
                    </td>
                    ';

            //new row in table if we are on the last day
            //and reset day variables
            if ($this->firstDayInMonth === 6) {
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
        <a class="right" href="?action=logOut">Logga Ut</a>
           <a class="addEvent" href="?action='.NavigationView::$actionShowEventForm . '">
           Lägg till händelse
           </a>
           <a href="?action='.NavigationView::$actionShowEventList.'">Ändra en händelse</a>
           <a href="?action='.NavigationView::$actionShowEventList.'">Ta bort en händelse</a>
            <a href="?action='.NavigationView::$actionShowCalendar."&".
                               NavigationView::$actionMonthToShow."=".$this->getNextMonth().'">Nästa månad</a>
                               <a href="?action='.NavigationView::$actionShowCalendar."&".
            NavigationView::$actionPreviousMonth."=".$this->getPreviousMonth().'">Nästa månad</a>
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
            if ($event->getDay() == $currentDay) {
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