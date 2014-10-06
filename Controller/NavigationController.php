<?php

namespace controller;

use view\NavigationView;

class NavigationController{

    public function renderView(){
        $controller = null;

        switch(NavigationView::getAction()){
            case NavigationView::$actionLogin;
                $controller = new LoginController();
                return $controller->showLogInForm();
                break;

            case NavigationView::$actionShowCalendar;
                $controller = new CalendarController();
                return $controller->render();
                break;
        }
        return null;
    }
}