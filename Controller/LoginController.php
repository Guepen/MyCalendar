<?php

namespace controller;

use view\LoginView;

class LoginController{
    private $loginView;

    public function __construct(){
        $this->loginView = new LoginView();
    }

    public function showLogInForm(){
        return $this->loginView->showLoginForm();
    }
}