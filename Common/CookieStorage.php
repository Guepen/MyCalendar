<?php

namespace view;

class CookieStorage{

    /**
     * @param $name string
     * @param $value string
     * @param $expire string
     */
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

    /**
     * @param $name string
     * @return bool
     */
    public function load($name){
        if(isset($_COOKIE[$name])){
            return $_COOKIE[$name];
        }
        return false;
    }

    /**
     * sets the cookie to a time that has already been
     * @param $name string
     */
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