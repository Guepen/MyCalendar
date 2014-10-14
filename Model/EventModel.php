<?php
/**
 * Created by PhpStorm.
 * User: Tobias
 * Date: 2014-10-12
 * Time: 20:09
 */

namespace Model;


class EventModel {

    private $errorMessage = "errorMessage";

    /**
     * @param $title
     * @param $month
     * @param $day
     * @param $startHour
     * @param $startMinute
     * @param $endHour
     * @param $endMinute
     * @param $description
     * @return bool
     * @throws EmptyDescriptionException
     * @throws EmptyTitleException
     * @throws WrongDayFormatException
     * @throws WrongMonthFormatException
     * @throws WrongTimeFormatException
     */
    public function validateInput($title, $month, $day, $startHour, $startMinute, $endHour, $endMinute, $description){
        if(empty($title)){
            throw new EmptyTitleException();
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
        $this->deleteMessage();
        return true;
    }

    public function setMessage($message){
        $_SESSION[$this->errorMessage] = $message;
    }

    public function getMessage(){
        if (isset($_SESSION[$this->errorMessage])) {
            return $_SESSION[$this->errorMessage];
        }
        return false;
    }

    public function deleteMessage(){
        if(isset($_SESSION[$this->errorMessage])){
            unset($_SESSION[$this->errorMessage]);
        }
    }

} 