<?php

namespace view;

class LoginView{
    private $message;
    private $usernameInput = "usernameInput";
    private $passwordInput = "passwordInput";
    private $keepMeInput = "keepMeInput";
    private $submitInput = "submitInput";

    /**
     * @return string with HTML for login form
     */
    public function renderLoginForm(){

        $html = "
              <div class='center'>
                <h3>Logga in</h3>
                <a href='?action=".NavigationView::$actionShowRegisterForm."'>Registrera ny användare</a>
                <form action='?action=".NavigationView::$actionLogin."' method='post'>
                   <legend class='center'>Skriv in användarnamn och lösenord</legend>
                   <fieldset>
                   <p>$this->message</p>

                   <div class='formGroup'>
                      <label>Användarnamn: </label>
                      <input placeholder='Skriv in ditt användarnamn' type='text' value='".$this->getUsername()."'
                       name=$this->usernameInput>
                   </div>

                     <div class='formGroup'>
                      <label>Lösenord: </label>
                      <input placeholder='Skriv in ditt lösenord' type='password' name=$this->passwordInput>
                   </div>

                     <div class='formGroup'>
                      <label>
                          <input type='checkbox' name=$this->keepMeInput> Håll mig inloggad
                      </label>
                   </div>

                    <input type='submit' class='button' name='$this->submitInput' value='Logga in'/>
                   </fieldset>
                </form>
            </div>

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
}