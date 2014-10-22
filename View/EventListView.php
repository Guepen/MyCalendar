<?php
/**
 * Created by PhpStorm.
 * User: Tobias
 * Date: 2014-10-16
 * Time: 20:30
 */

namespace View;


class EventListView {
    private $events;


    public function renderEventList(){
        $eventList = $this->getEventList();

        $ret ="<div class='eventModal'>
                  $eventList

               </div>";

        return $ret;
    }


    public function getEventList(){
        $dateHelper = new DateHelper();
        $monthHasEvents = false;
        $dateHelper->setAction(NavigationView::$actionShowEventList);

        $ret= " <a class='addEvent' href='?action=" .
            NavigationView::$actionShowCalendar.'&'.NavigationView::$actionMonthToShow.'='.$this->getMonthToShow().
            '&'.NavigationView::$actionYearToShow.'='.$this->getYearToShow()."'>Tillbaka till kalendern</a>";
        $ret .= "<label class='centerMonth'>".$dateHelper->getMonthInText()."</label>";
        $ret .= $dateHelper->getMonthNavigation();
        $ret .= "<div id='eventList'>";
        $ret .= "<li><label>Titel</label> <label>Ändra</label><label>Ta bort</label></li>";
        foreach ($this->events as $event ) {
            if ($event->getMonth() === $this->getMonthToShow() && $event->getYear() === $dateHelper->getYearToShow()) {
                $ret .= "
                     <li>" . $event->getTitle() . "
                     <a class='addEvent' href='?action=" . NavigationView::$actionAlterEventForm . "&" .
                    NavigationView::$actionShowEvent . "=" . $event->getTitle() . "'>Ändra händele</a>

                     <a class='delete deleteButton' href='?action=" . NavigationView::$actionDeleteEvent . "&" .
                    NavigationView::$actionShowEvent . "=" . $event->getTitle() . "'>Ta bort Händelse</a>

                     </li>";
                $monthHasEvents = true;
            }
        }

        if($monthHasEvents === false){
            $ret .= "<h3>Du har inga händelser den här månaden</h3>";
        }
        $ret .= "</div>";
        return $ret;
    }

    /**
     * TODO Put this in a date-helper class??
     * @return bool|string
     */
    private function getMonthToShow(){
        if(isset($_GET[NavigationView::$actionMonthToShow])){
            return $_GET[NavigationView::$actionMonthToShow];
        }
        return date("n");
    }

    /**
     * TODO Put this in a date-helper class??
     * @return bool|string
     */
    private function getYearToShow(){
        if(isset($_GET[NavigationView::$actionYearToShow])){
            return $_GET[NavigationView::$actionYearToShow];
        }
        return date("Y");
    }

    /**
     * TODO put this in a base class??
     * @param array $events
     */
    public function setEvents(Array $events){
        $this->events = $events;

    }

}