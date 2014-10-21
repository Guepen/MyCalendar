<?php

namespace view;

class HtmlView{
    public function echoHTML($body) {
        if ($body === NULL) {
           NavigationView::redirectToErrorPage();
        }


        echo "
				<!DOCTYPE html>
				<html>
				<head>
				<link href='./Style/styler.css' rel='stylesheet' type='text/css'>
				<link href='../../css/bootstrap.css' type='text/css' rel='stylesheet'>
                <link rel='stylesheet' type='text/css' href='../../css/bootstrap.min.css'>
                <link rel='stylesheet' type='text/css' href='../../css/bootstrap-theme.min.css'>
                <link rel='stylesheet' type='text/css' href='../../css/bootstrap-theme.css'>
                <link rel='stylesheet' type='text/css' href='../../css/bootstrap-theme.css.map'>
				<meta charset=\"utf-8\">
				</head>
				<body>
				   <div id='Container'>
				     <h1><img src='Images/myCalendarLogga.png' width='300px'> </h1>
					$body
                   </div>
                     <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
                  <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>
                 <!-- Include all compiled plugins (below), or include individual files as needed -->
                 <script src='../../js/bootstrap.min.js'></script>
                 <script src='../../js/bootstrap.js'></script>
				</body>
				</html>";
    }
}