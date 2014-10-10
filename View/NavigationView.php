<?php

namespace view;

class NavigationView{
    private static $action = "action";

    public static $actionShowCalendar = "calendar";
    public static $actionShowModal = "modal";
    public static $actionCalendarEvent = "event";
    public static $actionShowEvent = "title";

    public static $actionAddEvent ="addEvent";

    public static $actionShowLoginForm = "loginForm";
    public static $actionLogin = "login";

    /**
     * @return string with the actionURL
     */
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

    public static function redirectToCalendarAndModal(){
        header('location: /' . \Settings::$rootPath. '/?'.self::$action.'='.self::$actionShowCalendar.
            '&'.self::$actionShowModal);
    }
}
