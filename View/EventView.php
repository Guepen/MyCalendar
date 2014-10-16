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

    public function renderEvent()
    {
        $ret = "";
        $title = $this->getEventTitle();
        foreach ($this->events as $event) {
            $htmlMonth = strftime("%B", mktime(0, 0, 0, $event->getMonth()));
            $htmlMonth = ucfirst($htmlMonth);
            if ($event->getTitle() === $title) {
                $ret = "
                <div class='modal'>
                 <a class='right, green' href='?action=" .
                    NavigationView::$actionShowCalendar . "'>Tillbaka till kalendern</a>
                  <h3 class='center'>" . $event->getTitle() . "</h3>
                  <p class='center'>" . $event->getDescription() . "</p>
                  <p class='center'>Händelsen inträffar den " . $event->getDay() . " " . $htmlMonth . "</p>
                  <p class='center'>Pågår mellan " . $event->getStartHour() . ":" . $event->getStartMinute()
                    . "-" . $event->getEndHour() . ":" . $event->getEndMinute() . "</p>

                    <a class='green' href='?action=" . NavigationView::$actionAlterEvent . "&" .
                    NavigationView::$actionShowEvent . "=" . $event->getTitle() . "'>Ändra Händelsen</a>
                     <a class='right, red' href='?action=" . NavigationView::$actionDeleteEvent . "&" .
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