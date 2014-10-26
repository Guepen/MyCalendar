<?php

namespace view;

class HtmlView{
    public function echoHTML($body) {

        echo "
				<!DOCTYPE html>
				<html>
				<head>
				<link href='./Style/styler.css' rel='stylesheet' type='text/css'>
				<link href='../../css/bootstrap.css' type='text/css' rel='stylesheet'>
				  <link rel='stylesheet' type='text/css' href='../../css/bootstrap-theme.css'>
                <link rel='stylesheet' type='text/css' href='../../css/bootstrap-theme.css.map'>
				<meta charset=\"utf-8\">
				<title>MyCalendar</title>
				</head>
				<body>
				   <div id='Container'>
				     <h1 class='center'><img alt='logga' src='Images/myCalendarLogga.png' width='300'> </h1>
					$body
					 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
                     <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>
                     <!-- Include all compiled plugins (below), or include individual files as needed -->
                     <script src='../../js/bootstrap.js'></script>
                   </div>
				</body>
				</html>";
    }

}