<?php

namespace Tests;

use model\UserModel;

require_once("./ImportFiles.php");

class UserModelTest extends \PHPUnit_Framework_TestCase {

    public function testGetUsername(){
        $userModel = new UserModel("username", "password");
        $this->assertEquals("username", $userModel->getUsername());
    }

    public function testGetPassword(){
        $userModel = new UserModel("username", "password");
        $this->assertEquals("password", $userModel->getPassword());
    }

}
 