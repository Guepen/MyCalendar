<?php

namespace controller;

use model\DbException;
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
use View\EventView;
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
        $this->getEvents();
    }

    public function render(){
        if ($this->loginModel->isUserLoggedIn() === true) {
            return $this->calendarView->renderCalendar();
        }
        NavigationView::redirectToLoginForm();
    }

    public function getEvents(){
        try {
            $userId = $this->userRepository->getUserId($this->loginModel->getUserName());
            $events = $this->eventRepository->getEvents($userId);
            $this->calendarView->setEvents($events);

        } catch (DbException $e) {
            NavigationView::redirectToErrorPage();
        }
    }


}