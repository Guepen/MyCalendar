<?php

namespace Model;

class CalendarModel {


    public function validateInput($title, $month, $day, $startTime, $endTime, $description){
        if(empty($title)){
            throw new EmptyTitleException($day);
        }

        if(empty($description)){
            throw new EmptyDescriptionException($day);
        }

        if(!preg_match('/^\d{2}$/', $month)){
            throw new WrongMonthFormatException($day);
        }

        if(!preg_match('/^\d{1,2}$/', $day)){
            throw new WrongDayFormatException($day);
        }

        if(!preg_match('/(?:[01][0-9]|2[0-3])(:|.)[0-5][0-9]/',$startTime)){
            throw new WrongTimeFormatException($day);
        }

        if(!preg_match('/(?:[01][0-9]|2[0-3])(:|.)[0-5][0-9]/',$endTime)){
            throw new WrongTimeFormatException($day);
        }

        return true;
    }
} 