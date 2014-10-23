<?php

namespace view;

class CookieStorage{

    public function save($name, $value, $expire){
        setcookie($name, $value, $expire);

        /**
         * Beacuse the cookie isnt set before the page reloads
         * i do this workaround so i can get the cookie and save it to the database
         * when its created
         */
        if(isset($_COOKIE[$name]) === false){
            $_COOKIE[$name] = $value;
        }
    }

    public function load($name){
        if(isset($_COOKIE[$name])){
            return $_COOKIE[$name];
        }
        return false;
    }

    public function deleteCookie($name){
        setcookie($name, null, -1);
    }

    public function isCookieSet($cookieName){
        if (isset($_COOKIE[$cookieName]) === true) {
            return true;
        }
        return false;
    }


}