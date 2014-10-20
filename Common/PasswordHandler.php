<?php
/**
 * Created by PhpStorm.
 * User: Tobias
 * Date: 2014-10-20
 * Time: 14:00
 */

namespace Model;


class PasswordHandler {

    /**
     * @param $password string
     * @return string the crypted password
     */
    public function getCryptPassword($password){
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * Verifies the password
     * @param $password string the input from the user
     * @param $cryptedPassword string the crypted password in the db
     * @return bool true if the password is correct
     * @return bool false if the password is incorrect
     */
    public function verifyPassword($password, $cryptedPassword){
        if(password_verify($password, $cryptedPassword) === true){
            return true;
        }
        return false;
    }

} 