<?php

//Views
require_once("./Common/HtmlView.php");
require_once("./View/NavigationView.php");
require_once("./View/LoginView.php");
require_once("./View/CalendarView.php");
require_once("./View/ErrorView.php");
require_once("./View/ModalView.php");
require_once("./View/EventView.php");

//Controllers
require_once("./Controller/CalendarController.php");
require_once("./Controller/ModalController.php");
require_once("./Controller/LoginController.php");
require_once("./Controller/EventController.php");
require_once("./Controller/NavigationController.php");

//Models
require_once("./Model/ModalModel.php");
require_once("./Model/EventModel.php");
require_once("./Model/LoginModel.php");
require_once("./model/UserModel.php");
require_once ('./model/DAO/Repository.php');
require_once("./model/DAO/UserRepository.php");
require_once("./model/DAO/EventRepository.php");

//Exceptions
require_once("./common/Exceptions/UsernameAndPasswordToShortException.php");
require_once("./common/Exceptions/PasswordToShortException.php");
require_once("./common/Exceptions/UsernameToShortException.php");
require_once("./common/Exceptions/PasswordsDontMatchException.php");
require_once("./common/Exceptions/UserExistsException.php");
require_once("./common/Exceptions/ProhibitedCharacterInUsernameException.php");
require_once("./common/Exceptions/MissingPasswordException.php");
require_once("./common/Exceptions/MissingUsernameException.php");
require_once("./common/Exceptions/WrongUserinformationException.php");
require_once("./common/Exceptions/WrongTimeFormatException.php");
require_once("./common/Exceptions/WrongMonthFormatException.php");
require_once("./common/Exceptions/WrongDayFormatException.php");
require_once("./common/Exceptions/EmptyDescriptionException.php");
require_once("./common/Exceptions/EmptyTitleException.php");

//Settings
require_once("./Settings.php");
