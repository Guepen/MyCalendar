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
    private $startTime;
    private $endTime;
    private $description;

    public function __construct($title, $month, $day, $startTime, $endTime, $description){
        $this->title = $title;
        $this->month = $month;
        $this->day = $day;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->description = $description;

    }

    public function getTitle(){
       return $this->title;
    }

    public function getStartTime(){
        return $this->startTime;
    }

    public function getEndTime(){
       return $this->endTime;
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