<?php

namespace controller;

use model\DbException;
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
        return $this->loginView->renderLoginForm();
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
        return $this->loginView->renderLoginForm();
    }

    /**
     * Gets the usercredentials from the db and if they match the input redirect to calendar
     */
    public function checkIfUserExists(){
        try {
            $dbUser = $this->userRepository->getUser($this->loginView->getUsername());
            if ($this->loginModel->doLogin($this->loginView->getUsername(), $this->loginView->getPassword(),
                $dbUser->getUsername(), $dbUser->getPassword())){
                $this->checkIfUserHasCheckedKeepMe();
                NavigationView::redirectToCalendar();

            }
        } catch (DbException $e) {
            NavigationView::redirectToErrorPage();
            return false;
        }
    }

    /**
     * saves a cookie if the user checked keep me
     */
    private function checkIfUserHasCheckedKeepMe(){
        if($this->loginView->hasUserCheckedKeepMe() == true ){
            $this->loginView->setCookie();
            try {
                $this->userRepository->saveCookie($this->loginView->getUsername(), $this->loginModel->getCookieExpireTime(),
                    $this->loginView->getAutoLoginCookie());
            } catch (DbException $e) {
                NavigationView::redirectToErrorPage();
            }
        }
    }

    /**
     * tries to log in with cookies if there is a cookie
     * @return bool
     */
    public function isCookiesSet(){
        if($this->loginView->isCookieSet() === true){
            try {
                $cookieExpireTime = $this->userRepository->getCookie($this->loginView->getAutoLoginCookie());
                $username = $this->userRepository->getUsernameByCookie($this->loginView->getAutoLoginCookie());

                if($this->loginModel->checkIfCookieExpireTimeIsValid($cookieExpireTime) === true){
                    $this->loginModel->setUsername($username);
                    return true;
                }
                $this->loginView->deleteCookie();

            } catch (DbException $e) {
                NavigationView::redirectToErrorPage();
                return false;
            }
        }
        return false;
    }

    public function doLogOut(){
        $this->loginModel->doLogout();
        $this->loginView->deleteCookie();
        NavigationView::redirectToLoginForm();
    }
}