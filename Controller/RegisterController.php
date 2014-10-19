<?php

namespace controller;

use model\DbException;
use model\PasswordsDontMatchException;
use model\PasswordToShortException;
use model\ProhibitedCharacterInUsernameException;
use model\RegisterModel;
use model\User;
use model\UserExistsException;
use model\usernameAndPasswordToShortException;
use model\UsernameToShortException;
use model\UserRepository;
use view\loginView;
use view\NavigationView;
use view\RegisterView;

/**
 * Class RegisterController
 * @package controller
 */
class RegisterController{

    private $registerView;
    private $loginView;
    private $registerModel;
    private $userRepository;

    public function __construct(){
        $this->registerView = new RegisterView();
        $this->registerModel = new RegisterModel();
        $this->loginView = new loginView();
        $this->userRepository = new UserRepository();
    }

    public function renderRegisterForm(){
        return $this->registerView->renderRegisterForm();
    }

    /**
     * if the input is valid, call addNewUser()
     * else return string with HTML for the register form
     */
    public function isInputValid() {
        try {
            if ($this->registerModel->validateInput($this->registerView->getUserName(),
                $this->registerView->getPassword(), $this->registerView->getPassword2())){
                return $this->addNewUser();
            }

        } catch (usernameAndPasswordToShortException $e) {
            $this->registerView->setUsernameAndPasswordToShortMessage();
        } catch (PasswordToShortException $e) {
            $this->registerView->setToShortPasswordMessage();
        } catch (UsernameToShortException $e) {
            $this->registerView->setToShortUsernameMessage();
        } catch (PasswordsDontMatchException $e) {
            $this->registerView->setPasswordsDontMatchMessage();
        } catch (ProhibitedCharacterInUsernameException $e) {
            $this->registerView->setProhibitedCharacterMessage($e->getMessage());
        }
       return $this->registerView->renderRegisterForm();
    }

    /**
     * tries to add a new user
     * @return string the form that should be rendered
     */
    private function addNewUser(){
        try {
            $user = new User($this->registerView->getUserName(), $this->registerModel->getCryptedPassword());
            $this->userRepository->add($user);
            $this->loginView->setRegistrationSuccesMessae();
            return $this->loginView->renderLoginForm();

        } catch (UserExistsException $e) {
            $this->registerView->setUserExistsMessage();

        } catch(DbException $e){
            NavigationView::redirectToErrorPage();
        }
        return $this->registerView->renderRegisterForm();
    }

}