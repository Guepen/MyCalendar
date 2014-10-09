<?php

namespace Tests;

use model\User;

require_once("./ImportFiles.php");

class UserModelTest extends \PHPUnit_Framework_TestCase {

    public function testGetUsername(){
        $userModel = new User("username", "password");
        $this->assertEquals("username", $userModel->getUsername());
    }

    public function testGetPassword(){
        $userModel = new User("username", "password");
        $this->assertEquals("password", $userModel->getPassword());
    }

}
 