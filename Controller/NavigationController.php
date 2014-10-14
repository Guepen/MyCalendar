<?php

namespace controller;

use Model\EventModel;
use model\LoginModel;
use view\ErrorView;
use view\NavigationView;

class NavigationController{

    public function renderView(){
        $controller = null;
        $loginModel = new LoginModel();
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
                return $controller->checkIfInputIsValid();
                break;

            case NavigationView::$actionCalendarEvent;
                $controller = new CalendarController();
                $eventController = new EventController();
                return $controller->render().$eventController->renderEvent();
            break;
            case NavigationView::$actionLogout;
                $controller = new LoginController();
                return $controller->doLogOut();
                break;

            case NavigationView::$actionShowAddEventForm;
                $controller = new CalendarController();
                $eventController = new EventController();
                return $controller->render().$eventController->hasUserPressedShowAddEventForm();
                break;

            case NavigationView::$actionShowCalendar;
                if ($loginModel->isUserLoggedIn() === true) {
                    $controller = new CalendarController();
                    $eventModel->deleteMessage();
                    return $controller->render();
                } else{
                    NavigationView::redirectToLoginForm();
                }
                break;

            case NavigationView::$actionLogin;
                $controller = new LoginController();
                return $controller->isInputValid();

            case NavigationView::$actionAddEvent;
                $controller = new EventController();
                return $controller->checkIfInputIsValid();

            case NavigationView::$actionShowErrorPage;
                $controller = new ErrorView();
                return $controller->renderErrorPage();
        }
        return null;
    }
}