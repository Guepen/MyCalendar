<?php

namespace controller;

use model\EmptyDescriptionException;
use model\EmptyTitleException;
use Model\Event;

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
    private $userRepository;
    private $eventRepository;
    private $loginModel;

    public function __construct(){
        $this->calendarView = new CalendarView();
        $this->userRepository = new UserRepository();
        $this->eventRepository = new EventRepository();
        $this->loginModel = new LoginModel();
    }

    public function render(){
        $this->getEvents();
        return $this->calendarView->renderCalendar();
    }

    public function getEvents(){
        $userId = $this->userRepository->getUserId($this->loginModel->getUserName());
        $events = $this->eventRepository->getEvents($userId);
        $this->calendarView->setEvents($events);
    }


}