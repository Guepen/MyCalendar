<?php

namespace controller;

use view\LoginView;
use view\NavigationView;

class NavigationController{

    public function renderView(){
        $controller = null;

        switch(NavigationView::getAction()){
            case NavigationView::$actionShowLoginForm;
                $controller = new LoginController();
                return $controller->showLogInForm();
                break;

            case NavigationView::$actionShowCalendar;
                $controller = new CalendarController();
                return $controller->render();
                break;

            case NavigationView::$actionLogin;
                $controller = new LoginController();
               return $controller->isInputValid();
        }
        return null;
    }
}