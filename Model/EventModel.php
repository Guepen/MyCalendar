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
    private $day;
    private $startHour;
    private $startMinute;
    private $endHour;
    private $endMinute;
    private $description;

    public function __construct($title, $month, $day, $startHour, $startMinute, $endHour, $endMinute, $description){
        $this->title = $title;
        $this->month = $month;
        $this->day = $day;
        $this->startHour = $startHour;
        $this->startMinute = $startMinute;
        $this->endHour = $endHour;
        $this->endMinute = $endMinute;
        $this->description = $description;

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

    public function getMonth(){
        return $this->month;
    }

} 