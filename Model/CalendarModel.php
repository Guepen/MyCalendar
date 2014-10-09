<?php

namespace Model;

class CalendarModel {

    /**
     * @param $title
     * @param $month
     * @param $day
     * @param $startTime
     * @param $endTime
     * @param $description
     * @return bool
     * @throws EmptyDescriptionException
     * @throws EmptyTitleException
     * @throws WrongDayFormatException
     * @throws WrongMonthFormatException
     * @throws WrongTimeFormatException
     */
    public function validateInput($title, $month, $day, $startTime, $endTime, $description){
        if(empty($title)){
            throw new EmptyTitleException($day);
        }

        if(empty($description)){
            throw new EmptyDescriptionException($day);
        }

        if(!preg_match('/^([1-9]|1[012])$/', $month)){
            throw new WrongMonthFormatException($day);
        }

        if(!preg_match('/^([1-9]|[1-2][0-9]|3[0-1])$/', $day)){
            throw new WrongDayFormatException($day);
        }

        if(!preg_match('/(?:[01][0-9]|2[0-3])(.)[0-5][0-9]$/',$startTime)){
            throw new WrongTimeFormatException($day);
        }

        if(!preg_match('/(?:[01][0-9]|2[0-3])(.)[0-5][0-9]$/',$endTime)){
            throw new WrongTimeFormatException($day);
        }

        return true;
    }

    public function setMessage($message){
        $_SESSION['message'] = $message;
    }

    public function getMessage(){
        if (isset($_SESSION['message'])) {
            return $_SESSION['message'];
        }
    }
} 