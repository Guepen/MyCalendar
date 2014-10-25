<?php

namespace view;

use model\LoginModel;

class LoginView{
    private $message;
    private $loginModel;

    private $usernameInput = "usernameInput";
    private $passwordInput = "passwordInput";
    private $keepMeInput = "keepMeInput";
    private $submitInput = "submitInput";

    private $autoLogin = "autologin";

    public function __construct(){
        $this->cookieStorage = new CookieStorage();
        $this->loginModel = new LoginModel();
    }

    /**
     * @return string with HTML for login form
     */
    public function renderLoginForm(){

        $html = "
                <h3>Logga in</h3>
                <a href='?action=".NavigationView::$actionShowRegisterForm."'>Registrera ny användare</a>
                <form action='?action=".NavigationView::$actionLogin."' method='post' class='form-horizontal'>
                  <fieldset>
                   <legend class='center'>Skriv in användarnamn och lösenord</legend>
                   <p>$this->message</p>

                   <div class='formGroup'>
                      <label class='col-sm-2 control-label'>Användarnamn: </label>
                       <div class='col-sm-10'>
                      <input  class='form-control' placeholder='Skriv in ditt användarnamn' type='text'
                      value='".$this->getUsername()."' name=$this->usernameInput>
                   </div>
                   </div>

                     <div class='formGroup'>
                      <label class='col-sm-2 control-label'>Lösenord: </label>
                      <div class='col-sm-10'>
                      <input class='form-control' placeholder='Skriv in ditt lösenord' type='password'
                      name=$this->passwordInput>
                      </div>
                   </div>

                     <div class='formGroup'>
                      <label class='col-sm-2 control-label'>
                       <div class='col-sm-10'>
                          <input class='form-control' type='checkbox' name=$this->keepMeInput>
                          Håll mig inloggad
                      </label>
                      </div>
                   </div>
                   <div class='form-group'>
                    <div class='col-sm-offset-2 col-sm-10'>
                    <input class='btn btn-default' type='submit' class='button' name='$this->submitInput'
                    value='Logga in'/>
                    </div>
                    </div>
                   </fieldset>
                </form>

                ";

        return $html;
    }

    #region Messages
    public function setRegistrationSuccesMessae(){
        $this->message = "Registrering av ny användare lyckades";
    }

    public function setLoggedOutMessage(){
        $this->message = "Du är nu utloggad";
    }

    public function setWrongInformationInCookieMessage(){
        $this->message = "Fel information i cookies";
    }

    public function setMissingUsernameMessage(){
        $this->message = "Användarnamn saknas";
    }

    public function setMissingPasswordMessage(){
        $this->message = "Lösenord saknas";
    }

    public function setWrongUserinformationMessage(){
        $this->message = "Felaktigt användarnamn och/eller lösenord";
    }

    public function setUserDontExistMessage(){
        $this->message = "Felaktigt användarnamn och/eller lösenord";
    }
    #endregion

    #region Posts
    public function getUsername(){
        if(isset($_POST[$this->usernameInput]) === true){
            return $_POST[$this->usernameInput];
        }
        return false;
    }

    public function getPassword(){
        if(isset($_POST[$this->passwordInput]) === true){
            return $_POST[$this->passwordInput];
        }
        return false;
    }

    public function hasUserCheckedKeepMe(){
        if(isset($_POST[$this->keepMeInput]) === true){
            return true;
        }
        return false;
    }

    public function hasUserPressedLogin(){
        if(isset($_POST[$this->submitInput]) === true){
            return true;
        }
        return false;
    }
    #endregion

    public function setCookie(){
        if (isset($_POST[$this->keepMeInput]) === true) {
            $this->cookieStorage->save($this->autoLogin, $this->loginModel->getCryptPassword($this->getPassword()),
                $this->loginModel->getCookieExpireTime());
        }
    }

    public function deleteCookie(){
        $this->cookieStorage->deleteCookie($this->autoLogin);
    }

    public function isCookieSet(){
        if($this->cookieStorage->isCookieSet($this->autoLogin) === true){
            return true;
        }
        return false;
    }

    public function getAutoLoginCookie(){
        return $this->cookieStorage->load($this->autoLogin);
    }

}