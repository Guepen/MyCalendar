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
				<link href='./Style/Style.css' rel='stylesheet' type='text/css'>
				<meta charset=\"utf-8\">
				</head>
				<body>
					$body
				</body>
				</html>";
    }
}