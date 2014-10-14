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
use model\UserRepository;
use model\WrongDayFormatException;
use model\WrongMonthFormatException;
use model\WrongTimeFormatException;
use View\EventView;
use view\NavigationView;

class EventController {
    private $userRepository;
    private $loginModel;
    private $eventRepository;
    private $eventView;
    private $eventModel;

    public function __construct(){
        $this->userRepository = new UserRepository();
        $this->loginModel = new LoginModel();
        $this->eventRepository = new EventRepository();
        $this->eventView = new EventView();
        $this->eventModel = new EventModel();
    }

    public function renderEvent(){
        $this->getEvents();
        return $this->eventView->renderEvent();
    }

    public function renderEventList(){
        $this->getEvents();
        return $this->eventView->renderEventList();
    }

    public function renderAlterEventForm(){
        $this->getEvents();
        return $this->eventView->renderAlterEventForm();
    }

    /**
     * if user has pressed the add event link @return string the modal/popup
     * else @return bool false
     */
    public function hasUserPressedShowAddEventForm(){
        if ($this->eventView->hasUserPressedShowAddEventForm()) {
            $this->getEvents();
            return $this->eventView->renderAddEventForm();
        }
        return false;
    }

    /**
     * if input from the add event form is valid,
     * create a new event belonging the user
     */
    public function checkIfInputIsValid(){
        try {
            if($this->eventModel->validateInput($this->eventView->getTitle(),
                    $this->eventView->getMonth(), $this->eventView->getDay(), $this->eventView->getStartHour(),
                    $this->eventView->getStartMinute(), $this->eventView->getEndHour(),
                    $this->eventView->getEndMinute(), $this->eventView->getDescription()) === true){
                if ($this->eventView->hasUserPressedAddEvent()) {
                    $this->addEvent();
                } else{
                    $this->alterEvent();
                }
                return;

            }
        } catch (EmptyTitleException $e) {
            $this->eventView->setMissingTitleMessage();

        } catch(EmptyDescriptionException $e){
            $this->eventView->setMissingDescriptionMessage();

        } catch(WrongDayFormatException $e){
            $this->eventView->setUnexpectedErrorMessage();

        } catch(WrongTimeFormatException $e){
            $this->eventView->setWrongTimeFormatMessage();

        } catch(WrongMonthFormatException $e) {
            $this->eventView->setUnexpectedErrorMessage();

        }
        $this->eventModel->setMessage($this->eventView->getMessage());
        NavigationView::redirectToModal();
    }

    public function alterEvent(){
        $event = new Event($this->eventView->getTitle(), $this->eventView->getMonth(),
            $this->eventView->getDay(), $this->eventView->getStartHour(),
            $this->eventView->getStartMinute(), $this->eventView->getEndHour(),
            $this->eventView->getEndMinute(), $this->eventView->getDescription(),
            $this->eventView->getEventId());
        try{
            $this->eventRepository->Update($event);
            NavigationView::redirectToCalendar();
        } catch(DbException $e){
            NavigationView::redirectToErrorPage();
        }

    }

    /**
     * tries to add en event
     * @throws DbException
     */
    private  function addEvent(){

        $event = new Event($this->eventView->getTitle(), $this->eventView->getMonth(),
            $this->eventView->getDay(), $this->eventView->getStartHour(),
            $this->eventView->getStartMinute(), $this->eventView->getEndHour(),
            $this->eventView->getEndMinute(), $this->eventView->getDescription());

        try {
            $userId = $this->userRepository->getUserId($this->loginModel->getUserName());
            $this->eventRepository->add($event, $userId);
            NavigationView::redirectToCalendar();
        } catch (DbException $e) {
            NavigationView::redirectToErrorPage();

        }

    }

    public function getEvents(){
        $userId = $this->userRepository->getUserId($this->loginModel->getUserName());
        $events = $this->eventRepository->getEvents($userId);
        $this->eventView->setEvents($events);
    }


} 