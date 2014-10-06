<?php

namespace view;

class NavigationView{
    private static $action = "action";

    public static $actionShowCalendar = "calendar";
    public static $actionLogin = "login";

    public static function getAction(){
        if(isset($_GET[self::$action])){
            return $_GET[self::$action];
        }
        return self::$actionLogin;
    }

    public static function redirectToLogin(){
        header('location: /' . \Settings::$rootPath. '/?'.self::$action.'='.self::$actionLogin);
    }

    public static function redirectToCalendar(){
        header('location: /' . \Settings::$rootPath. '/?'.self::$action.'='.self::$actionShowCalendar);
    }
}
