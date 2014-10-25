<?php

namespace view;

class CalendarView {

    private $firstDayInMonth;
    private $dayOfTheWeek;
    private $events;
    private $currentDay;
    private $dateHelper;

    public function __construct(){
        $this->dateHelper = new DateHelper();
        $this->dayOfTheWeek = 1;
        $this->firstDayInMonth = date('w', mktime(0, 0, 0, $this->dateHelper->getMonthToShow(),
            0, $this->dateHelper->getYearToShow()));
        $this->currentDay = date("j");
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
        $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $this->dateHelper->getMonthToShow(),
            $this->dateHelper->getYearToShow());
        $dayCounter = 0;
        $ret = "";

        for ($i = 1; $i <= $numberOfDays; $i++) {
            $eventBox = $this->getEvents($i);
            if($i == $this->currentDay && $this->dateHelper->getMonthToShow() == date("n") &&
                $this->dateHelper->getYearToShow() == date("Y")){

                $ret .= '<td class="currentDay">';

            } else {
                $ret .= '
                    <td class="calendarDay">';
            }

            $ret .=  '<div class="dayNumber">
                    <label class="right"><a class="quickAdd" href="?action='.NavigationView::$actionShowEventForm.
                '&'.NavigationView::$actionDateToShow.'='.$i.'&'.NavigationView::$actionMonthToShow.'='.
                $this->dateHelper->getMonthToShow().
                '&'.NavigationView::$actionYearToShow.'='.$this->dateHelper->getYearToShow().'">+</a>
                    </label>
            ' . $i . '
                      <p class="event">' . $eventBox . '</p>
                    </div>
                    </a>
                    </td>
            ';

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
        $this->dateHelper->setAction(NavigationView::$actionShowCalendar);

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
          '.$this->getMenu().'
          '.$this->dateHelper->getMonthNavigation().'
             ' .
            $calendar .'
        ';

        return $html;
    }

    private function getMenu(){
        $ret = ' <div id="menu">
        <a class="right" href="?action=logOut">Logga Ut</a>
           <a class="addEvent" href="?action='.NavigationView::$actionShowEventForm .'&'.
            NavigationView::$actionMonthToShow.'='.$this->dateHelper->getMonthToShow().'&'.
            NavigationView::$actionYearToShow.'='. $this->dateHelper->getYearToShow(). '">
           Lägg till händelse
           </a>

           <a href="?action='.NavigationView::$actionShowEventList.'&'.NavigationView::$actionMonthToShow.'='.
            $this->dateHelper->getMonthToShow().'&'.NavigationView::$actionYearToShow.'='.
            $this->dateHelper->getYearToShow().'">
            Ändra en händelse
            </a>

             <a href="?action='.NavigationView::$actionShowEventList.'&'.NavigationView::$actionMonthToShow.'='.
            $this->dateHelper->getMonthToShow().'&'.NavigationView::$actionYearToShow.'='.$this->dateHelper->getYearToShow().'">
            Ta bort en händelse
            </a>

             <label class="centerMonth">'.$this->dateHelper->getMonthInText()
            ." ". $this->dateHelper->getYearToShow() . '
                </label>' . '

          <p></p>
          </div>';

        return $ret;
    }

    private function getEvents($currentDay){
        $eventBox = "";
        foreach ($this->events as $event) {
            if ($event->getDay() == $currentDay && $event->getMonth() == $this->dateHelper->getMonthToShow() &&
                $event->getYear() === $this->dateHelper->getYearToShow()) {
                $eventBox .= "<div class='eventBox'><a class='event' href='?action="
                    .NavigationView::$actionCalendarEvent . "&".
                    NavigationView::$actionShowEvent ."=". $event->getTitle() . '&'.
                    NavigationView::$actionMonthToShow.'='.$this->dateHelper->getMonthToShow().'&'.
                    NavigationView::$actionYearToShow.'='. $this->dateHelper->getYearToShow(). "'>
                           <h4 class='event'>'" . $event->getTitle() . "'</h4></a></div>";
            }
        }
        return $eventBox;

    }

    public function setEvents(Array $events){
        $this->events = $events;

    }

}