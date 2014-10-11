<?php

namespace view;

class ErrorView{

    public function renderErrorPage(){
        $html = "
        <h3>Ett oväntat fel inträffade</h3>
        <a href=?action=".NavigationView::$actionShowLoginForm.">Tillbaka till startsidan</button>
        ";

        return $html;
    }

}