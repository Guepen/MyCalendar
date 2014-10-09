<?php

namespace controller;

use Model\CalendarModel;
use model\EmptyDescriptionException;
use model\EmptyTitleException;
use Model\Event;
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
                 $event = new Event();

             }
        } catch (EmptyTitleException $e) {
            $this->calendarView->setMissingTitleMessage();
            $this->calendarModel->setMessage($this->calendarView->getMessage());
            $this->calendarView->setMessage();

        } catch(EmptyDescriptionException $e){

        } catch(WrongDayFormatException $e){

        } catch(WrongMonthFormatException $e){

        } catch(WrongTimeFormatException $e){

        }

        NavigationView::redirectToCalendarAndModal($e->getMessage());
    }

}