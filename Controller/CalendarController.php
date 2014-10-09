<?php

namespace controller;

use Model\CalendarModel;
use model\EmptyDescriptionException;
use model\EmptyTitleException;
use model\WrongDayFormatException;
use model\WrongMonthFormatException;
use model\WrongTimeFormatException;
use view\CalendarView;
use view\NavigationView;

class CalendarController{
    private $calendarView;
    private $calendarModel;

    public function __construct(){
        $this->calendarView = new CalendarView();
        $this->calendarModel = new CalendarModel();
    }

    public function render(){
        return $this->calendarView->renderCalendar();
    }


    public function checkIfInputIsValid(){
        try {
             if($this->calendarModel->validateInput($this->calendarView->getTitle(), $this->calendarView->getMonth(),
                $this->calendarView->getDay(), $this->calendarView->getStartTime(),
                $this->calendarView->getEndTime(), $this->calendarView->getDescription()) === true){
                 var_dump("Good values");

             }
        } catch (EmptyTitleException $e) {

        } catch(EmptyDescriptionException $e){

        } catch(WrongDayFormatException $e){

        } catch(WrongMonthFormatException $e){

        } catch(WrongTimeFormatException $e){

        }

        NavigationView::redirectToCalendarAndModal($e->getMessage());
    }

}