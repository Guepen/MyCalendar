<?php

//Views
require_once("./View/EventView.php");
require_once("./Common/HtmlView.php");
require_once("./View/NavigationView.php");
require_once("./View/LoginView.php");
require_once("./View/CalendarView.php");
require_once("./View/ErrorView.php");
require_once("./View/EventListView.php");
require_once("./View/EventFormView.php");

//Controllers
require_once("./Controller/CalendarController.php");
require_once("./Controller/LoginController.php");
require_once("./Controller/EventController.php");
require_once("./Controller/NavigationController.php");

//Models
require_once("./Model/EventModel.php");
require_once("./Model/Event.php");
require_once("./Model/LoginModel.php");
require_once("./Model/User.php");
require_once ('./Model/DAO/Repository.php');
require_once("./Model/DAO/UserRepository.php");
require_once("./Model/DAO/EventRepository.php");

//Exceptions
require_once("./Common/Exceptions/UsernameAndPasswordToShortException.php");
require_once("./Common/Exceptions/DbException.php");
require_once("./Common/Exceptions/PasswordToShortException.php");
require_once("./Common/Exceptions/UsernameToShortException.php");
require_once("./Common/Exceptions/PasswordsDontMatchException.php");
require_once("./Common/Exceptions/UserExistsException.php");
require_once("./Common/Exceptions/ProhibitedCharacterInUsernameException.php");
require_once("./Common/Exceptions/MissingPasswordException.php");
require_once("./Common/Exceptions/MissingUsernameException.php");
require_once("./Common/Exceptions/WrongUserInformationException.php");
require_once("./Common/Exceptions/WrongTimeFormatException.php");
require_once("./Common/Exceptions/WrongMonthFormatException.php");
require_once("./Common/Exceptions/WrongDayFormatException.php");
require_once("./Common/Exceptions/EmptyDescriptionException.php");
require_once("./Common/Exceptions/EmptyTitleException.php");
require_once("./Common/Exceptions/TitleToLongException.php");
require_once("./Common/Exceptions/ProhibitedCharacterInTitleException.php");

//Settings
require_once("./Settings.php");
