<?php

namespace controller;

use model\LoginModel;
use view\ErrorView;
use view\NavigationView;

class NavigationController{

    public function renderView(){
        $controller = null;
        $loginModel = new LoginModel();

        switch(NavigationView::getAction()){
            case NavigationView::$actionShowLoginForm;
                $controller = new LoginController();
                return $controller->showLogInForm();
                break;

            case NavigationView::$actionCalendarEvent;
                $controller = new CalendarController();
                $eventController = new EventController();
                return $controller->render().$eventController->renderEvent();
            break;

            case NavigationView::$actionShowAddEventForm;
                $controller = new CalendarController();
                $modalController = new ModalController();
                return $controller->render().$modalController->hasUserPressedShowAddEventForm();
                break;

            case NavigationView::$actionShowCalendar;
                if ($loginModel->isUserLoggedIn() === true) {
                    $controller = new CalendarController();
                    return $controller->render();
                } else{
                    NavigationView::redirectToLoginForm();
                }
                break;

            case NavigationView::$actionLogin;
                $controller = new LoginController();
                return $controller->isInputValid();

            case NavigationView::$actionAddEvent;
                $controller = new ModalController();
                return $controller->checkIfInputIsValid();

            case NavigationView::$actionShowErrorPage;
                $controller = new ErrorView();
                return $controller->renderErrorPage();
        }
        return null;
    }
}