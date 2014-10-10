<?php
/**
 * Created by PhpStorm.
 * User: Tobias
 * Date: 2014-10-10
 * Time: 23:02
 */

namespace View;


class EventView {
    private $events;


    public function renderEvent(){
        $ret = "";
        $title = $this->getTitle();
        foreach ($this->events as $event) {
            if ($event->getTitle() === $title) {
                $ret = "
                <div class='modal'>
                 <a class='right' href='?action=" . NavigationView::$actionShowCalendar . "'>Tillbaka till kalendern</a>
                  <h3 class='center'>" . $event->getTitle() . "</h3>
                  <p class='center'>" . $event->getDescription() . "</p>
                  <p class='center'>Händelsen inträffar den " . $event->getDay() . " " . date("F") . "</p>
                  <p class='center'>Pågår mellan " . $event->getStartTime() . "-" . $event->getEndTime() . "</p>
                </div>
                ";
            }
        }

        return $ret;

    }

    public function setEvents($events){
        $this->events = $events;

    }

    public function getTitle(){
        return $_GET[NavigationView::$actionShowEvent];
    }


} 