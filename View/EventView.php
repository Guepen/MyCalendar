<?php
/**
 * Created by PhpStorm.
 * User: Tobias
 * Date: 2014-10-16
 * Time: 20:42
 */

namespace View;


class EventView{
    private $events;

    public function renderEvent() {
        $dateHelper = new DateHelper();
        $ret = "";
        $title = $this->getEventTitle();
        foreach ($this->events as $event) {
            $htmlMonth = strftime("%B", mktime(0, 0, 0, $event->getMonth()));
            $htmlMonth = ucfirst($htmlMonth);
            if ($event->getTitle() === $title) {
                $ret = "
                <div class='eventModal'>
                 <a class='orange' href='?action=" . NavigationView::$actionShowCalendar .'&'.
                    NavigationView::$actionMonthToShow.'='.$dateHelper->getMonthToShow().'&'.
                    NavigationView::$actionYearToShow.'='. $dateHelper->getYearToShow(). "'>
                    Tillbaka till kalendern
                    </a>

                  <h3 class='center'>" . $event->getTitle() . "</h3>
                  <p class='center'>" . $event->getDescription() . "</p>
                  <p class='center'>Händelsen inträffar den " . $event->getDay() . " " . $htmlMonth . "</p>
                  <p class='center'>Pågår mellan " . $event->getStartHour() . ":" . $event->getStartMinute()
                    . "-" . $event->getEndHour() . ":" . $event->getEndMinute() . "</p>

                    <a class='orange' href='?action=" . NavigationView::$actionAlterEventForm . "&" .
                    NavigationView::$actionShowEvent . "=" . $event->getTitle() . "'>Ändra Händelsen</a>
                     <a class='right delete' href='?action=" . NavigationView::$actionDeleteEvent . "&" .
                    NavigationView::$actionShowEvent . "=" . $event->getTitle() . "'>Ta bort Händelse</a>
                </div>
                ";
            }
        }
        return $ret;

    }

    /**
     * TODO put this in a base class??
     * @return string|bool The title of chosen event
     */
    public function getEventTitle(){
        if (isset( $_GET[NavigationView::$actionShowEvent])) {
            return $_GET[NavigationView::$actionShowEvent];
        }
        return false;
    }

    /**
     * TODO put this in a base class??
     * @param array $events
     */
    public function setEvents(Array $events){
        $this->events = $events;

    }
}