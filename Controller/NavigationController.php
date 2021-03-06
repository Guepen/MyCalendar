<?php

namespace controller;

use view\ErrorView;
use view\HtmlView;
use view\NavigationView;

class NavigationController{

    public function renderView(){
        $controller = null;
        switch(NavigationView::getAction()){

            case NavigationView::$actionShowRegisterForm;
                $controller = new RegisterController();
                return $controller->renderRegisterForm();
                break;

            case NavigationView::$actionSubmitRegisterForm;
                $controller = new RegisterController();
                return $controller->isInputValid();
                break;

            case NavigationView::$actionShowEventList;
                $eventController = new EventController();
                $controller = new CalendarController();
                return $controller->renderCalendar() . $eventController->renderEventList();
                break;

            case NavigationView::$actionAlterEventForm;
                $controller = new EventController();
                $calendarController = new CalendarController();
                return $calendarController->renderCalendar() . $controller->renderAlterEventForm();
                break;

            case NavigationView::$actionSubmitAlteredEvent;
                $controller = new EventController();
                return $controller->userPressedAlterEvent();
                break;

            case NavigationView::$actionCalendarEvent;
                $controller = new CalendarController();
                $eventController = new EventController();
                return $controller->renderCalendar().$eventController->renderEvent();
                break;

            case NavigationView::$actionDeleteEvent;
                $controller = new EventController();
                $controller->deleteEvent();
                break;

            case NavigationView::$actionLogout;
                $controller = new LoginController();
                $controller->doLogOut();
                break;

            case NavigationView::$actionShowEventForm;
                $controller = new CalendarController();
                $eventController = new EventController();
                return $controller->renderCalendar().$eventController->hasUserPressedShowEventForm();
                break;

            case NavigationView::$actionShowCalendar;
                $controller = new CalendarController();
                return $controller->renderCalendar();
                break;

            case NavigationView::$actionLogin;
                $controller = new LoginController();
                return $controller->isInputValid();
                break;

            case NavigationView::$actionAddEvent;
                $controller = new EventController();
                return $controller->userPressedAddEvent();
                break;

            case NavigationView::$actionShowErrorPage;
                $controller = new ErrorView();
                return $controller->renderErrorPage();

            default:
                $controller = new LoginController();
                if($controller->isCookiesSet() === true){
                    $controller = new CalendarController();
                    return $controller->renderCalendar();

                } else {
                    return $controller->showLogInForm();
                }
        }
        return null;
    }

}