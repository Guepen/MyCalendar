<?php

namespace controller;

use Model\EventModel;
use view\ErrorView;
use view\NavigationView;

class NavigationController {

    public function renderView() {
        if ($this->checkLoginActions() !== NULL) {
            return $this->checkLoginActions();

        } else if ($this->checkCalendarActions() !== NULL) {
            return $this->checkCalendarActions();

        } else if($this->checkCRUDActions() !== NULL){
            return $this->checkCRUDActions();

        } else{
            $errorView = new ErrorView();
            return $errorView->renderErrorPage();
        }
    }

    private function checkLoginActions() {
        switch (NavigationView::getAction()) {
            case NavigationView::$actionShowLoginForm;
                $controller = new LoginController();
                return $controller->showLogInForm();

            case NavigationView::$actionLogout;
                $controller = new LoginController();
                $controller->doLogOut();
                break;

            case NavigationView::$actionLogin;
                $controller = new LoginController();
                return $controller->isInputValid();

        }
        return null;
    }

    private function checkCalendarActions(){
        switch (NavigationView::getAction()) {
            case NavigationView::$actionShowCalendar;
                $controller = new CalendarController();
                return $controller->render();
                break;

            case NavigationView::$actionShowEventList;
                $eventController = new EventController();
                $controller = new CalendarController();
                return $controller->render() . $eventController->renderEventList();
                break;

            case NavigationView::$actionShowEventForm;
                $controller = new CalendarController();
                $eventController = new EventController();
                return $controller->render().$eventController->hasUserPressedShowEventForm();
                break;


            case NavigationView::$actionCalendarEvent;
                $controller = new CalendarController();
                $eventController = new EventController();
                return $controller->render().$eventController->renderEvent();
                break;

            case NavigationView::$actionAlterEventForm;
                $controller = new EventController();
                $calendarController = new CalendarController();
                return $calendarController->render() . $controller->renderAlterEventForm();
                break;

        }
        return null;
    }

    private function checkCRUDActions(){
        switch (NavigationView::getAction()) {
            case NavigationView::$actionSubmitAlteredEvent;
                $controller = new EventController();
                return $controller->userPressedAlterEvent();
                break;

            case NavigationView::$actionDeleteEvent;
                $controller = new EventController();
                $controller->deleteEvent();
                break;

            case NavigationView::$actionAddEvent;
                $controller = new EventController();
                return $controller->userPressedAddEvent();
                break;
        }
        return null;
    }

}