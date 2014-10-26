<?php
/**
 * Created by PhpStorm.
 * User: Tobias
 * Date: 2014-10-12
 * Time: 20:09
 */

namespace Model;


class EventModel {

    /**
     * TODO validate that endtime is later than starttime
     * @param $startHour string
     * @param $startMinute string
     * @param $endHour string
     * @param $endMinute string
     * @return bool
     * @throws EndHourNotSelectedException
     * @throws EndMinuteNotSelectedException
     * @throws StartHourNotSelectedException
     * @throws StartMinuteNotSelectedException
     */
    public function validateTimeInput($startHour, $startMinute, $endHour, $endMinute){
        if(!preg_match('/^(0[0-9]|1[0-9]|2[0-3])$/',$startHour)){
            throw new StartHourNotSelectedException();
        }
        if(!preg_match('/^(0[0-9]|1[0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9])$/',$startMinute)){
            throw new StartMinuteNotSelectedException();
        }
        if(!preg_match('/^(0[0-9]|1[0-9]|2[0-3])$/',$endHour)){
            throw new EndHourNotSelectedException();
        }
        if(!preg_match('/^(0[0-9]|1[0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9])$/',$endMinute)){
            throw new EndMinuteNotSelectedException();
        }
        return true;

    }

    public function validateDateInput($year, $currentYear, $month, $currentMonth, $day, $currentDay){
        if(!preg_match('/^([1-9]|1[012])$/', $month)){
            throw new MonthNotSelectedException();
        }

        if($year <= $currentYear && $month < $currentMonth ||
            $year <= $currentYear && $month <= $currentMonth && $day < $currentDay) {
            throw new DateHasAlredayBeenException();
        }

        if(!preg_match('/^([1-9]|[1-2][0-9]|3[0-1])$/', $day)){
            throw new WrongDayFormatException();
        }
        return true;
    }

    public function validateTextInput($title, $description){
        if(empty($title)){
            throw new EmptyTitleException();

        } else if(mb_strlen($title) > 20){
            throw new TitleToLongException();

        } else if(preg_match('/[<>]/', $title)){
            throw new ProhibitedCharacterInTitleException();
        }

        if(empty($description)){
            throw new EmptyDescriptionException();

        } else if(preg_match('/[<>]/', $description)){
            throw new ProhibitedCharacterInDescriptionException();

        } else if(mb_strlen($description) > 255){
            throw new DescriptionToLongException();
        }
        return true;

    }

} 