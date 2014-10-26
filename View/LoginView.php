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

               $this->message
                <form action='?action=".NavigationView::$actionLogin."' method='post' class='form-horizontal'>
                  <fieldset>
                   <legend>Logga in - Skriv in användarnamn och lösenord</legend>

                   <div class='form-group'>
                      <label class='col-sm-2 control-label'>Användarnamn: </label>
                       <div class='col-sm-10'>
                      <input  class='form-control' placeholder='Skriv in ditt användarnamn' type='text'
                      value='".$this->getUsername()."' name=$this->usernameInput>
                   </div>
                   </div>

                     <div class='form-group'>
                      <label class='col-sm-2 control-label'>Lösenord: </label>
                      <div class='col-sm-10'>
                      <input class='form-control' placeholder='Skriv in ditt lösenord' type='password'
                      name=$this->passwordInput>
                      </div>
                   </div>

                     <div class='form-group'>
                     <div class='col-sm-offset-2 col-sm-10'>
                       <div class='checkbox'>
                        <label>
                          <input class='checkbox' type='checkbox' name=$this->keepMeInput>
                          Håll mig inloggad
                      </label>
                      </div>
                   </div>
                   </div>

                   <div class='form-group'>
                    <div class='col-sm-offset-2 col-sm-10'>
                    <input class='btn btn-success' type='submit' name='$this->submitInput'
                    value='Logga in'/>
                       <a class='btn btn-primary' href='?action=".NavigationView::$actionShowRegisterForm."'>
                       Registrera ny användare
                       </a>
                    </div>
                    </div>
                   </fieldset>
                </form>

                ";

        return $html;
    }

    #region Messages
    private function getDangerAlert(){
        $ret = "<div class='alert alert-danger alert-error'>
                  <a href='#' class='close' data-dismiss='alert'>&times;</a>";

        return $ret;
    }

    private function getSuccessAlert(){
        $ret = "<div class='alert alert-success'>
                  <a href='#' class='close' data-dismiss='alert'>&times;</a>";

        return $ret;
    }
    public function setRegistrationSuccesMessae(){
        $this->message = $this->getSuccessAlert();
        $this->message .= "Registrering av ny användare lyckades</div>";
    }

    public function setLoggedOutMessage(){
        $this->message = "Du är nu utloggad";
    }

    public function setWrongInformationInCookieMessage(){
        $this->message = "Fel information i cookies";
    }

    public function setMissingUsernameMessage(){
        $this->message = $this->getDangerAlert();
        $this->message .= "Användarnamn saknas</div>";
    }

    public function setMissingPasswordMessage(){
        $this->message = $this->getDangerAlert();
        $this->message .= "Lösenord saknas</div>";
    }

    public function setWrongUserinformationMessage(){
        $this->message = $this->getDangerAlert();
        $this->message .= "Felaktigt användarnamn och/eller lösenord</div>";
    }

    public function setUserDontExistMessage(){
        $this->message = $this->getDangerAlert();
        $this->message .= "Felaktigt användarnamn och/eller lösenord</div>";
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