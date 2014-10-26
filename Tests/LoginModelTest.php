<?php

namespace Tests;
require_once("./ImportFiles.php");

use model\LoginModel;

class LoginModelTest extends \PHPUnit_Framework_TestCase {

    public function testValidateOkInput(){
        $loginModel = new LoginModel();
        $this->assertTrue($loginModel->validateInput("username", "password"));
    }

    /**
     * @expectedException \model\MissingUsernameException
     */
    public function testMissingUsernameException(){
        $loginModel = new LoginModel();
        $loginModel->validateInput("", "password");
    }

    /**
     * @expectedException \model\MissingUsernameException
     */
    public function testMissingUsernameAndPasswordException(){
        $loginModel = new LoginModel();
        $loginModel->validateInput("", "");
    }

    /**
     * @expectedException \model\missingPasswordException
     */
    public function testMissingPasswordException(){
        $loginModel = new LoginModel();
        $loginModel->validateInput("username", "");
    }

    public function testDoLoginWithCorrectValues(){
        $loginModel = new LoginModel();
        $password = password_hash("password", PASSWORD_BCRYPT);
        $this->assertTrue($loginModel->doLogIn("username", "password", "username", $password));
        $this->assertTrue($loginModel->isUserLoggedIn());
    }

    /**
     * @expectedException \model\WrongUserInformationException
     */
    public function testDoLoginWithOnlyMatchingUsername(){
        $loginModel = new LoginModel();
        $password = password_hash("password", PASSWORD_BCRYPT);
        $loginModel->doLogIn("username", "Password", "username", $password);
    }

    /**
     * @expectedException \model\WrongUserInformationException
     */
    public function testDoLoginWithOnlyMatchingPassword(){
        $loginModel = new LoginModel();
        $password = password_hash("password", PASSWORD_BCRYPT);
        $loginModel->doLogIn("Username", "password", "username", $password);
    }

    /**
     * @expectedException \model\WrongUserInformationException
     */
    public function testDoLoginWithIncorrectValues(){
        $loginModel = new LoginModel();
        $password = password_hash("password", PASSWORD_BCRYPT);
        $loginModel->doLogIn("Username", "Password", "username", $password);
    }

    public function checkThatUserIsNotLoggedIn(){
        $loginModel = new LoginModel();
        $this->assertFalse($loginModel->isUserLoggedIn());
    }


    public function testLogOut(){
        $_SESSION["user"] = "username";
        $loginModel = new LoginModel();
        $loginModel->doLogout();
        $this->assertFalse(isset($_SESSION["user"]));

    }

    public function testGetCryptPassword(){
        $loginModel = new LoginModel();
        $password = "password";
        $this->assertTrue(password_verify($password,$loginModel->getCryptPassword($password)));
    }

    public function testCookieExpireTimeIsValid(){
        $loginModel = new LoginModel();
        $this->assertTrue($loginModel->checkIfCookieExpireTimeIsValid(time()+200));
    }

    public function testCookieExpireTimeIsNotValid(){
        $loginModel = new LoginModel();
        $this->assertFalse($loginModel->checkIfCookieExpireTimeIsValid(time()-200));
    }

    public function testGetCookieExpireTime(){
        $loginModel = new LoginModel();
        $this->assertEquals(strtotime("+1 week"),$loginModel->getCookieExpireTime());
    }
}
 