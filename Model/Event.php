<?php
/**
 * Created by PhpStorm.
 * User: Tobias
 * Date: 2014-10-09
 * Time: 21:33
 */

namespace Model;


class Event {
    private $title;
    private $month;
    private $year;
    private $day;
    private $startHour;
    private $startMinute;
    private $endHour;
    private $endMinute;
    private $description;
    private $eventId;

    public function __construct($title, $month, $year, $day, $startHour, $startMinute,
                                $endHour, $endMinute, $description, $eventId = null){
        $this->title = $title;
        $this->month = $month;
        $this->year = $year;
        $this->day = $day;
        $this->startHour = $startHour;
        $this->startMinute = $startMinute;
        $this->endHour = $endHour;
        $this->endMinute = $endMinute;
        $this->description = $description;
        $this->eventId = $eventId;

    }

    public function getTitle(){
       return $this->title;
    }

    public function getStartHour(){
        return $this->startHour;
    }

    public function getStartMinute(){
        return $this->startMinute;
    }

    public function getEndHour(){
       return $this->endHour;
    }

    public function getEndMinute(){
        return $this->endMinute;
    }

    public function getDescription(){
       return $this->description;
    }

    public function getDay(){
      return $this->day;
    }

    public function getYear(){
        return $this->year;
    }

    public function getMonth(){
        return $this->month;
    }

    public function getEventId(){
        return $this->eventId;
    }

} 