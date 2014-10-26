<?php

namespace controller;

use model\DbException;
use model\EventRepository;
use model\LoginModel;
use model\UserRepository;
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
        $this->getEvents();
    }

    public function isUserLoggedIn(){
        if ($this->loginModel->isUserLoggedIn() === true) {
            return true;
        }
        NavigationView::redirectToLoginForm();
    }

    public function renderCalendar(){
        if ($this->loginModel->isUserLoggedIn() === true) {
            return $this->calendarView->renderCalendar();
        }
        NavigationView::redirectToLoginForm();
    }

    /**
     * tries to get all the events belonging the user
     * redirects to the error page if something goes wrong
     */
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