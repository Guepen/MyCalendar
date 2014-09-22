<?php

namespace view;

class ErrorView{
    public function renderErrorPage(){
        $html = "
        <h3>Ett oväntat fel inträffade</h3>
        <button name='renderCalendar'>Tillbaka till kalendern</button>
        ";

        return $html;
    }

}