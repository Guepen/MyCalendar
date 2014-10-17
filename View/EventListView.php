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

        $ret ="<div class='modal'>
                  $eventList

               </div>";

        return $ret;
    }


    public function getEventList(){
        $ret="";
        foreach ($this->events as $event ) {
            $ret .= "
            <p>
                 <li>".$event->getTitle()."
                 <a href='?action=".NavigationView::$actionAlterEventForm."&".
                NavigationView::$actionShowEvent."=".$event->getTitle()."'>Ändra händele</a>

                 <a href='?action=".NavigationView::$actionDeleteEvent."&".
                NavigationView::$actionShowEvent."=".$event->getTitle()."'>Ta bort Händelse</a>

                 </li>
                </p>";
        }
        return $ret;
    }

    /**
     * TODO put this in a base class??
     * @param array $events
     */
    public function setEvents(Array $events){
        $this->events = $events;

    }

}