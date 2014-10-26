<?php
/**
 * Created by PhpStorm.
 * User: Tobias
 * Date: 2014-10-26
 * Time: 17:18
 */

namespace Tests;

use model\RegisterModel;

class RegisterModelTest extends \PHPUnit_Framework_TestCase {

    /**
     * @expectedException \model\UsernameAndPasswordToShortException
     */
    public function testUsernameAndPasswordToShortException(){
        $registerModel = new RegisterModel();
        $registerModel->validateInput("jh", "pass", "pass");
    }

    /**
     * @expectedException \model\PasswordToShortException
     */
    public function testPasswordToShortException(){
        $registerModel = new RegisterModel();
        $registerModel->validateInput("Admin", "pass", "pass");
    }

    /**
     * @expectedException \model\UsernameToShortException
     */
    public function testUsernameToShortException(){
        $registerModel = new RegisterModel();
        $registerModel->validateInput("jh", "password", "password");
    }

    /**
     * @expectedException \model\PasswordsDontMatchException
     */
    public function testPasswordsDontMatchException(){
        $registerModel = new RegisterModel();
        $registerModel->validateInput("Admin", "password", "Password");
    }

    /**
     * @expectedException \model\ProhibitedCharacterInUsernameException
     */
    public function testProhibitedCharacterInUsernameException(){
        $registerModel = new RegisterModel();
        $registerModel->validateInput("<h1>Admin", "password", "password");
    }

    public function testOkInput(){
        $registerModel = new RegisterModel();
        $registerModel->validateInput("Admin", "password", "password");
    }

}
 