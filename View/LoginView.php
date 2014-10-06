<?php

namespace view;

class LoginView{
    private $message;
    private $usernameInput = "usernameInput";
    private $passwordInput = "passwordInput";
    private $keepMeInput = "keepMeInput";
    private $submitInput = "submitInput";

    public function showLoginForm(){
        $html = "
              <div class='center'>
                <h3>Logga in</h3>

                <form method='post'>
                   <legend class='center'>Skriv in användarnamn och lösenord</legend>
                   <fieldset>
                   <p>$this->message</p>

                   <div class='formGroup'>
                      <label>Användarnamn: </label>
                      <input placeholder='Skriv in ditt användarnamn' type='text' name=$this->usernameInput>
                   </div>

                     <div class='formGroup'>
                      <label>Lösenord: </label>
                      <input placeholder='Skriv in ditt lösenord' type='text' name=$this->passwordInput>
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
}