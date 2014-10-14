<?php

namespace controller;

use model\LoginModel;
use model\MissingPasswordException;
use model\MissingUsernameException;
use model\UserRepository;
use model\WrongUserInformationException;
use view\LoginView;
use view\NavigationView;

class LoginController{
    private $loginView;
    private $loginModel;
    private $userRepository;

    public function __construct(){
        $this->loginView = new LoginView();
        $this->loginModel = new LoginModel();
        $this->userRepository = new UserRepository();
    }

    public function showLogInForm(){
        return $this->loginView->showLoginForm();
    }

    /**
     * Checks if the input from the login form is valid
     * else @return string with HTML for the login form
     */
    public function isInputValid(){
        try{
            if($this->loginModel->validateInput($this->loginView->getUsername(),
               $this->loginView->getPassword()) === true){
                $this->checkIfUserExists();
            }

        } catch (MissingUsernameException $e) {
            $this->loginView->setMissingUsernameMessage();
        } catch(MissingPasswordException $e){
            $this->loginView->setMissingPasswordMessage();
        } catch(WrongUserInformationException $e){
            $this->loginView->setWrongUserinformationMessage();
        }
        return $this->loginView->showLoginForm();
    }

    public function checkIfUserExists(){
        $dbUser = $this->userRepository->getUser($this->loginView->getUsername());
        if ($this->loginModel->doLogin($this->loginView->getUsername(), $this->loginView->getPassword(),
            $dbUser->getUsername(), $dbUser->getPassword())) {
            NavigationView::redirectToCalendar();

        }
    }

    public function doLogOut(){
        $this->loginModel->doLogout();
        NavigationView::redirectToLoginForm();
    }
}