<?php
/**
 * Created by PhpStorm.
 * User: Tobias
 * Date: 2014-10-10
 * Time: 23:05
 */

namespace Controller;


use model\DbException;
use model\EmptyDescriptionException;
use model\EmptyTitleException;
use Model\Event;
use Model\EventModel;
use model\EventRepository;
use model\LoginModel;
use model\ProhibitedCharacterInTitleException;
use model\TitleToLongException;
use model\UserRepository;
use model\WrongDayFormatException;
use model\WrongMonthFormatException;
use model\WrongTimeFormatException;
use view\CalendarView;
use view\EventFormView;
use View\EventListView;
use View\EventView;
use view\NavigationView;

class EventController {
    private $userRepository;
    private $loginModel;
    private $eventRepository;
    private $eventFormView;
    private $calendarView;
    private $eventModel;
    private $eventListView;
    private $eventView;

    public function __construct(){
        $this->userRepository = new UserRepository();
        $this->loginModel = new LoginModel();
        $this->eventRepository = new EventRepository();
        $this->eventFormView = new EventFormView();
        $this->calendarView = new CalendarView();
        $this->eventListView = new EventListView();
        $this->eventView = new EventView();
        $this->eventModel = new EventModel();
    }

    public function userPressedAlterEvent(){
        if($this->InputIsValid()){
            $this->alterEvent();
        }
        return $this->calendarView->renderCalendar() . $this->eventFormView->renderAlterEventForm();
    }

    public function userPressedAddEvent(){
        if($this->InputIsValid()){
            $this->addEvent();
        }

        return $this->calendarView->renderCalendar() . $this->eventFormView->renderAddEventForm();
    }

    public function renderEvent(){
        if ($this->loginModel->isUserLoggedIn() === true) {
            $this->eventView->setEvents($this->getEvents());
            return $this->eventView->renderEvent();
        }
        NavigationView::redirectToLoginForm();
    }

    public function renderEventList(){
        if ($this->loginModel->isUserLoggedIn() === true) {
            $this->eventListView->setEvents($this->getEvents());
            return $this->eventListView->renderEventList();
        }
        NavigationView::redirectToLoginForm();
    }

    public function renderAlterEventForm(){
        $this->setEvents();
        return $this->eventFormView->renderAlterEventForm();
    }

    /**
     * if user has pressed the add event link @return string the modal/popup
     * else @return bool false
     */
    public function hasUserPressedShowEventForm(){
        if ($this->eventFormView->hasUserPressedShowEventForm() && $this->loginModel->isUserLoggedIn() === true) {
            $this->setEvents();
            return $this->eventFormView->renderAddEventForm();
        }
        NavigationView::redirectToLoginForm();
        return false;
    }

    /**
     * checks if input from the add event form or update event form is valid
     */
    public function InputIsValid(){
        if ($this->loginModel->isUserLoggedIn() === true) {
            try {
                if ($this->eventModel->validateInput($this->eventFormView->getTitle(),
                        $this->eventFormView->getMonth(), $this->eventFormView->getCurrentMonth(),
                        $this->eventFormView->getDay(), $this->eventFormView->getCurrentDay(),
                        $this->eventFormView->getStartHour(), $this->eventFormView->getStartMinute(),
                        $this->eventFormView->getEndHour(), $this->eventFormView->getEndMinute(),
                        $this->eventFormView->getDescription()) === true){

                    return true;

                }
            } catch (EmptyTitleException $e) {
                $this->eventFormView->setMissingTitleMessage();

            } catch (TitleToLongException $e){
                $this->eventFormView->setTitleToLongMessage();

            } catch(ProhibitedCharacterInTitleException $e){
                $this->eventFormView->setProhibitedCharacterInTitleMessage();

            } catch (EmptyDescriptionException $e) {
                $this->eventFormView->setMissingDescriptionMessage();

            } catch (WrongDayFormatException $e) {
                $this->eventFormView->setUnexpectedErrorMessage();

            } catch (WrongTimeFormatException $e) {
                $this->eventFormView->setWrongTimeFormatMessage();

            } catch (WrongMonthFormatException $e) {
                $this->eventFormView->setUnexpectedErrorMessage();

            }
            $this->setEvents();
            return false;

        }
        NavigationView::redirectToLoginForm();
    }

    public function alterEvent(){
        $event = new Event($this->eventFormView->getTitle(), $this->eventFormView->getMonth(),
            $this->eventFormView->getYear(), $this->eventFormView->getDay(), $this->eventFormView->getStartHour(),
            $this->eventFormView->getStartMinute(), $this->eventFormView->getEndHour(),
            $this->eventFormView->getEndMinute(), $this->eventFormView->getDescription(),
            $this->eventFormView->getEventId());
        try{
            $this->eventRepository->Update($event);
            NavigationView::redirectToCalendar();
            return;
        } catch(DbException $e){
            NavigationView::redirectToErrorPage();
            return;
        }

    }

    /**
     * tries to add en event
     * @throws DbException
     */
    private  function addEvent(){

        $event = new Event($this->eventFormView->getTitle(), $this->eventFormView->getMonth(),
            $this->eventFormView->getYear(),
            $this->eventFormView->getDay(), $this->eventFormView->getStartHour(),
            $this->eventFormView->getStartMinute(), $this->eventFormView->getEndHour(),
            $this->eventFormView->getEndMinute(), $this->eventFormView->getDescription());

        try {
            $userId = $this->userRepository->getUserId($this->loginModel->getUserName());
            $this->eventRepository->add($event, $userId);
            NavigationView::redirectToCalendar();
            return;
        } catch (DbException $e) {
            NavigationView::redirectToErrorPage();
            return;

        }

    }

    public function deleteEvent(){
        try {
            $userId = $this->userRepository->getUserId($this->loginModel->getUserName());
            $title = $this->eventFormView->getEventTitle();
            $this->eventRepository->deleteEvent($title, $userId);
            NavigationView::redirectToCalendar();

        } catch (DbException $e) {
            NavigationView::redirectToErrorPage();
        }

    }

    private function getEvents(){
        try {
            $userId = $this->userRepository->getUserId($this->loginModel->getUserName());
            $events = $this->eventRepository->getEvents($userId);
            return $events;
        } catch (DbException $e) {
            NavigationView::redirectToErrorPage();
        }
        return false;
    }

    private function setEvents(){
        $this->calendarView->setEvents($this->getEvents());
        $this->eventFormView->setEvents($this->getEvents());
    }


}