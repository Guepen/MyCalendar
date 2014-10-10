<?php

namespace controller;

use Model\CalendarModel;
use model\EmptyDescriptionException;
use model\EmptyTitleException;
use Model\Event;
use Model\EventList;
use model\EventRepository;
use model\LoginModel;
use model\UserRepository;
use model\WrongDayFormatException;
use model\WrongMonthFormatException;
use model\WrongTimeFormatException;
use view\CalendarView;
use view\NavigationView;

class CalendarController{
    private $calendarView;
    private $calendarModel;
    private $userRepository;
    private $eventRepository;
    private $loginModel;

    public function __construct(){
        $this->calendarView = new CalendarView();
        $this->calendarModel = new CalendarModel();
        $this->userRepository = new UserRepository();
        $this->eventRepository = new EventRepository();
        $this->loginModel = new LoginModel();
    }

    public function render(){
        $userId = $this->userRepository->getUserId($this->loginModel->getUserName());
        $events = $this->eventRepository->getEvents($userId);
        $this->calendarView->setEvents($events);

        return $this->calendarView->renderCalendar();
    }


    public function checkIfInputIsValid(){
        try {
            if($this->calendarModel->validateInput($this->calendarView->getTitle(), $this->calendarView->getMonth(),
                    $this->calendarView->getDay(), $this->calendarView->getStartTime(),
                    $this->calendarView->getEndTime(), $this->calendarView->getDescription()) === true){

                $event = new Event($this->calendarView->getTitle(), $this->calendarView->getMonth(),
                                   $this->calendarView->getDay(), $this->calendarView->getStartTime(),
                                   $this->calendarView->getEndTime(), $this->calendarView->getDescription());

                $userId = $this->userRepository->getUserId($this->loginModel->getUserName());
                $this->eventRepository->add($event, $userId);
                NavigationView::$actionShowCalendar;

            }
        } catch (EmptyTitleException $e) {
            $this->calendarView->setMissingTitleMessage();

        } catch(EmptyDescriptionException $e){
            $this->calendarView->setMissingDescriptionMessage();

        } catch(WrongDayFormatException $e){
            $this->calendarView->setUnexpectedErrorMessag();

        } catch(WrongTimeFormatException $e){
            $this->calendarView->setWrongTimeFormatMessage();

        } catch(WrongMonthFormatException $e) {
            $this->calendarView->setUnexpectedErrorMessag();

        }
        $this->calendarModel->setMessage($this->calendarView->getMessage());
        //return $this->calendarView->renderModal();
        NavigationView::redirectToCalendarAndModal($e->getMessage());
    }

}