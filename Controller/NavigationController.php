<?php

namespace controller;

use Model\EventModel;
use view\ErrorView;
use view\NavigationView;

class NavigationController{

    public function renderView(){
        $controller = null;
        $eventModel = new EventModel();
        switch(NavigationView::getAction()){
            case NavigationView::$actionShowLoginForm;
                $controller = new LoginController();
                return $controller->showLogInForm();
                break;

            case NavigationView::$actionShowEventList;
                $eventController = new EventController();
                $controller = new CalendarController();
                return $controller->render() . $eventController->renderEventList();
                break;

            case NavigationView::$actionAlterEvent;
                $controller = new EventController();
                $calendarController = new CalendarController();
                return $calendarController->render() . $controller->renderAlterEventForm();
                break;

            case NavigationView::$actionSubmitAlteredEvent;
                $controller = new EventController();
                $controller->checkIfInputIsValid();
                break;

            case NavigationView::$actionCalendarEvent;
                $controller = new CalendarController();
                $eventController = new EventController();
                return $controller->render().$eventController->renderEvent();
                break;

           case NavigationView::$actionDeleteEvent;
                $controller = new EventController();
                $controller->deleteEvent();
                break;

            case NavigationView::$actionLogout;
                $controller = new LoginController();
                $controller->doLogOut();
                break;

            case NavigationView::$actionShowAddEventForm;
                $controller = new CalendarController();
                $eventController = new EventController();
                return $controller->render().$eventController->hasUserPressedShowAddEventForm();
                break;

            case NavigationView::$actionShowCalendar;
                $controller = new CalendarController();
                $eventModel->deleteMessage();
                return $controller->render();
                break;

            case NavigationView::$actionLogin;
                $controller = new LoginController();
                return $controller->isInputValid();
                break;

            case NavigationView::$actionAddEvent;
                $controller = new EventController();
                $controller->checkIfInputIsValid();
                break;

            case NavigationView::$actionShowErrorPage;
                $controller = new ErrorView();
                return $controller->renderErrorPage();
        }
        return null;
    }

}