<?php
/**
 * Created by PhpStorm.
 * User: Tobias
 * Date: 2014-10-12
 * Time: 20:09
 */

namespace Model;


class EventModel {

    public function validateInput($title, $month, $currentMonth, $day, $currentDay, $startHour,
                                  $startMinute, $endHour, $endMinute, $description){
        if(empty($title)){
            throw new EmptyTitleException();

        } else if(mb_strlen($title) > 20){
            throw new TitleToLongException();

        } else if(preg_match('/[^a-z0-9-_]+/i', $title)){
            throw new ProhibitedCharacterInTitleException();
        }

        if(empty($description)){
            throw new EmptyDescriptionException();
        }

        if(!preg_match('/^([1-9]|1[012])$/', $month)){
            throw new WrongMonthFormatException();
        }

        if(!preg_match('/^([1-9]|[1-2][0-9]|3[0-1])$/', $day)){
            throw new WrongDayFormatException();
        }

        if(!preg_match('/^(0[0-9]|1[0-9]|2[0-3])$/',$startHour)){
            throw new WrongTimeFormatException();
        }
        if(!preg_match('/^(0[0-9]|1[0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9])$/',$startMinute)){
            var_dump($startMinute);
            throw new WrongTimeFormatException();
        }
        if(!preg_match('/^(0[0-9]|1[0-9]|2[0-3])$/',$endHour)){
            throw new WrongTimeFormatException();
        }
        if(!preg_match('/^(0[0-9]|1[0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9])$/',$endMinute)){
            throw new WrongTimeFormatException();
        }
        return true;
    }

} 