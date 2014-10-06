<?php

namespace view;

class HtmlView{
    public function echoHTML($body) {
        if ($body === NULL) {
            throw new \Exception("HTMLView::echoHTML does not allow body to be null");
        }


        echo "
				<!DOCTYPE html>
				<html>
				<head>
				<link href='./Style/styler.css' rel='stylesheet' type='text/css'>
				<meta charset=\"utf-8\">
				</head>
				<body>
				   <div id='Container'>
				     <h1>MyCalendar</h1>
					$body
                   </div>
				</body>
				</html>";
    }
}