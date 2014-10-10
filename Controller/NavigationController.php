<?php

namespace controller;

use Model\CalendarModel;
use model\LoginModel;
use view\LoginView;
use view\NavigationView;

class NavigationController{

    public function renderView(){
        $controller = null;
        $loginModel = new LoginModel();
        $calendarModel = new CalendarModel();

        switch(NavigationView::getAction()){
            case NavigationView::$actionShowLoginForm;
                $controller = new LoginController();
                return $controller->showLogInForm();
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
                $controller = new CalendarController();
                return $controller->checkIfInputIsValid();
        }
        return null;
    }
}