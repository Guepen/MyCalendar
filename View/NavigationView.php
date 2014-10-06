<?php

namespace view;

class NavigationView{
    private static $action = "action";

    public static $actionShowCalendar = "calendar";
    public static $actionCalendarDay = "day";
    public static $actionShowLoginForm = "loginForm";
    public static $actionLogin = "login";

    public static function getAction(){
        if(isset($_GET[self::$action])){
            return $_GET[self::$action];
        }
        return self::$actionShowLoginForm;
    }

    public static function redirectToLoginForm(){
        header('location: /' . \Settings::$rootPath. '/?'.self::$action.'='.self::$actionShowLoginForm);
    }

    public static function redirectToCalendar(){
        header('location: /' . \Settings::$rootPath. '/?'.self::$action.'='.self::$actionShowCalendar);
    }
}
