<?php

namespace model;

use model\PasswordsDontMatchException;
use model\PasswordToShortException;
use model\ProhibitedCharacterInUsernameException;
use model\UsernameAndPasswordToShortException;
use model\UsernameToShortException;

class RegisterModel{
    private $passwordSession = "passwordSession";

    public function validateInput($username, $password, $password2){
        //$regex = '/^[a-z0-9]+$/i';
        if(mb_strlen($username) < 3 && mb_strlen($password) < 6 && mb_strlen($password2) < 6){
            throw new UsernameAndPasswordToShortException();
        }

        else if(mb_strlen($password) < 6 && mb_strlen($password2) < 6){
            throw new PasswordToShortException();
        }

        else if(mb_strlen($username) < 3 && mb_strlen($password) > 5 && mb_strlen($password2) > 5){
            throw new UsernameToShortException();
        }

        else if($password !== $password2){
            throw new PasswordsDontMatchException();
        }

        else if(preg_match('/[^a-z0-9]+/i', $username)){
            $username = preg_replace('/[^a-z0-9]+/i', "", $username);
            throw new ProhibitedCharacterInUsernameException($username);
        }

        else if(mb_strlen($username) > 2 && mb_strlen($password) > 5 && mb_strlen($password2) >5 && $password === $password2){
            $this->cryptPassword($password);
            return true;
        }
    }

    private function cryptPassword($password){
        $password = password_hash($password, PASSWORD_BCRYPT);
        $_SESSION[$this->passwordSession] = $password;

    }

    public function getCryptedPassword(){
        return $_SESSION[$this->passwordSession];
    }


}