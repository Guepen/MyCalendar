<?php
/**
 * Created by PhpStorm.
 * User: Tobias
 * Date: 2014-10-19
 * Time: 21:16
 */

namespace View;


class RegisterView {
    private $username;
    private $password;
    private $password2;
    private $message;

    private $usernameInput = "usernameInput";
    private $passwordInput = "passwordInput";
    private $password2Input = "password2Input";
    private $submitInput = "submitInout";


    /**
     * @return string with HTML
     */
    public function renderRegisterForm(){

        $html = "
                     <a class='btn btn-primary' href='?action=".NavigationView::$actionShowLoginForm."'>Tillbaka</a>
                     <p></p>
                      $this->message
                     <form method='post' action='?action=".NavigationView::$actionSubmitRegisterForm."' class='form-horizontal'>
                     <fieldset>
					 <legend>Registrera ny användare - Skriv in användarnamn och lösenord</legend>

 					 <div class='form-group'>
 					 <label class='col-sm-2 control-label' for='username'>Användarnamn : </label>
 					 <div class='col-sm-10'>
 					 <input placeholder='Skriv in önskat användarnamn' class='form-control' type='text'
 					 name='".$this->usernameInput."' value='$this->username' maxlength='30'/>
 					 </div>
 					 </div>

 					 <div class='form-group'>
					 <label class='col-sm-2 control-label' for='password' >Lösenord : </label>
					 <div class='col-sm-10'>
					 <input placeholder='Skriv in önskat lösenord' class='form-control' type='password'
					 name='".$this->passwordInput."' maxlength='30'/>
					 </div>
					 </div>

					 <div class='form-group'>
					 <label class='col-sm-2 control-label' for='password'  >Repetera Lösenord : </label>
					 <div class='col-sm-10'>
					 <input placeholder='Repetera lösenordet' class='form-control' type='password'
					 name='".$this->password2Input."' maxlength='30'/>
					 </div>
					 </div>

					 <div class='form-group'>
					 <div class='col-sm-offset-2 col-sm-10'>
					 <input class='btn btn-success' type='submit' name='".$this->submitInput."' value='Registrera'/>
					 </div>
					 </div>
					 </fieldset>
					 </form>
					 " ;

        return $html;

    }

    #region Messages
    private function getDangerAlert(){
        $ret = "<div class='alert alert-danger alert-error'>
                  <a href='#' class='close' data-dismiss='alert'>&times;</a>";

        return $ret;
    }

    public function setToShortUsernameMessage(){
        $this->message = $this->getDangerAlert();
        $this->message .= "Användarnamnet har för få tecken. Minst 3 tecken</div>";
    }

    public function setUsernameAndPasswordToShortMessage(){
        $this->message = $this->getDangerAlert();
        $this->message .= " Användarnamnet har för få tecken. Minst 3 tecken.
                          <p>Lösenorden har för få tecken. Minst 6 tecken</p></div>";
    }

    public function setToShortPasswordMessage(){
        $this->message = $this->getDangerAlert();
        $this->message .= "Lösenorden har för få tecken. Minst 6 tecken</div>";
    }

    public function setPasswordsDontMatchMessage(){
        $this->message = $this->getDangerAlert();
        $this->message .= "Lösenorden matchar inte";
    }

    public function setUserExistsMessage(){
        $this->message = $this->getDangerAlert();
        $this->message .= "Användarnamnet är upptaget</div>";
    }

    /**
     * @param $username string filtered username
     */
    public function setProhibitedCharacterMessage($username){
        $this->username = $username;
        $this->message = $this->getDangerAlert();
        $this->message .= "Användarnamnet innehåller ogiltliga tecken</div>";
    }
    #endregion

    #region Posts
    public function usrHasPressedRegister(){
        if(isset($_POST[$this->submitInput])){
            return true;
        }
        return false;
    }

    public function getUserName(){
        if(isset($_POST[$this->usernameInput])){
            return $this->username = $_POST[$this->usernameInput];
        }
        return false;
    }

    public function getPassword(){
        if(isset($_POST[$this->passwordInput])){
            return $this->password = $_POST[$this->passwordInput];
        }
        return false;
    }

    public function getPassword2(){
        if(isset($_POST[$this->password2Input])){
            return $this->password2 = $_POST[$this->password2Input];
        }
        return false;
    }
    #endregion

} 