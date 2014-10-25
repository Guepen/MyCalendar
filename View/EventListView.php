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
            NavigationView::$actionShowCalendar.'&'.NavigationView::$actionMonthToShow.'='.$dateHelper->getMonthToShow().
            '&'.NavigationView::$actionYearToShow.'='.$dateHelper->getYearToShow()."'>Tillbaka till kalendern</a>";
        $ret .= "<label class='centerMonth'>".$dateHelper->getMonthInText()."</label>";
        $ret .= $dateHelper->getMonthNavigation();
        $ret .= "<div id='eventList'>";
        $ret .= "<li><label>Titel</label> <label>Ändra</label><label>Ta bort</label></li>";
        foreach ($this->events as $event ) {
            if ($event->getMonth() === $dateHelper->getMonthToShow() && $event->getYear() === $dateHelper->getYearToShow()) {
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
     *  TODO put this in a helper-class or even base class? We use this exact function in multiple views
     * @param array $events
     */
    public function setEvents(Array $events){
        $this->events = $events;

    }

}