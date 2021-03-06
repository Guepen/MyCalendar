<?php

namespace view;

class NavigationView{
    private static $action = "action";

    public static $actionShowCalendar = "calendar";
    public static $actionMonthToShow = "month";
    public static $actionYearToShow = "year";
    public static $actionDateToShow = "date";
    public static $actionShowEventForm = "modal";
    public static $actionShowEvent = "title";
    public static $actionShowEventList = "eventList";

    public static $actionShowRegisterForm = "registerForm";
    public static $actionSubmitRegisterForm = "submitRegister";

    public static $actionShowErrorPage = "error";

    public static $actionCalendarEvent = "event";
    public static $actionAddEvent = "addEvent";
    public static $actionAlterEventForm = "alterEvent";
    public static $actionSubmitAlteredEvent = "submitAlter";
    public static $actionDeleteEvent = "deleteEvent";

    public static $actionShowLoginForm = "loginForm";
    public static $actionLogin = "login";
    public static $actionLogout = "logOut";

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

    public static function redirectToErrorPage(){
        header('location: /' . \Settings::$rootPath. '/?'.self::$action.'='.self::$actionShowErrorPage);
    }

    public static function redirectToCalendar(){
        header('location: /' . \Settings::$rootPath. '/?'.self::$action.'='.self::$actionShowCalendar);
    }

    public static function redirectToModal(){
        header('location: /' . \Settings::$rootPath. '/?'.self::$action.'='.self::$actionShowEventForm);
    }
}
