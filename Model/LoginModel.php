<?php

namespace model;

class LoginModel{

    private $sessionUser = "user";

    /**
     * Validates the input from the login form
     * @param $username string
     * @param $password string
     * @return bool true if the input is valid else false
     * @throws MissingPasswordException if the password is leaved blank
     * @throws MissingUsernameException if the username is leaved blank
     */
    public function validateInput($username, $password){
        if(empty($username) || empty($username) && empty($password)){
            throw new MissingUsernameException();

        } else if(empty($password)){
            throw new MissingPasswordException();

        } else{
            return true;
        }
    }

    /**
     * tries to log in
     * @param $username string
     * @param $password string
     * @param $dbUsername string
     * @param $dbPassword string
     * @return bool true if the values from inputs in the login form matches a user in the db
     * @throws WrongUserInformationException if the values from inputs in the login form don´t matches a user in the db
     */
    public function doLogIn($username, $password, $dbUsername, $dbPassword){
        if ($username === $dbUsername && $password === $dbPassword) {
            $_SESSION[$this->sessionUser] = $username;
            return true;

        } else {
            throw new WrongUserInformationException();
        }
    }

    public function doLogout(){
        unset($_SESSION[$this->sessionUser]);
    }

    public function getUserName(){
        return $_SESSION[$this->sessionUser];
    }

    public function isUserLoggedIn(){
        if(isset($_SESSION[$this->sessionUser]) === true){
            return true;
        }
        return false;
    }
}