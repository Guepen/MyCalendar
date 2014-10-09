<?php

namespace view;

class ErrorView{
    private $backLocation ="back";
    public function renderErrorPage(){
        $html = "
        <h3>Ett oväntat fel inträffade</h3>
        <button name='$this->backLocation'>Tillbaka till kalendern</button>
        ";

        return $html;
    }

    public function userHasPressedBackToCalendar(){
        if(isset($_POST[$this->backLocation])){
            return true;
        }
        return false;
    }

}