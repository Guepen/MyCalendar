<?php
/**
 * Created by PhpStorm.
 * User: Tobias
 * Date: 2014-10-10
 * Time: 23:05
 */

namespace Controller;

use model\DateHasAlredayBeenException;
use model\DbException;
use model\DescriptionToLongException;
use model\EmptyDescriptionException;
use model\EmptyTitleException;
use model\EndHourNotSelectedException;
use model\EndMinuteNotSelectedException;
use Model\Event;
use Model\EventModel;
use model\EventRepository;
use model\LoginModel;
use model\MonthNotSelectedException;
use model\ProhibitedCharacterInDescriptionException;
use model\ProhibitedCharacterInTitleException;
use model\StartHourNotSelectedException;
use model\StartMinuteNotSelectedException;
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
        if($this->isInputValid() === true){
            $this->alterEvent();
        }
        //fulhack
        return $this->calendarView->renderCalendar() . $this->eventFormView->renderAlterEventForm();
    }

    public function userPressedAddEvent(){
        if($this->isInputValid() === true){
            $this->addEvent();
        }
        //fulhack
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

    public function hasUserPressedShowEventForm(){
        if ($this->eventFormView->hasUserPressedShowEventForm() && $this->loginModel->isUserLoggedIn() === true) {
            $this->setEvents();
            return $this->eventFormView->renderAddEventForm();
        }
        NavigationView::redirectToLoginForm();
        return false;
    }

    public function isInputValid(){
        if ($this->loginModel->isUserLoggedIn() === true) {
            if($this->isTextInputValid() === true && $this->isDateInputValid() === true &&
                $this->isTimeInputValid() === true){
                return true;
            }
            $this->setEvents();
            return false;
        }
        NavigationView::redirectToLoginForm();
    }

    private function isTimeInputValid(){
        try {
            if ($this->eventModel->validateTimeInput($this->eventFormView->getStartHour(),
                    $this->eventFormView->getStartMinute(), $this->eventFormView->getEndHour(),
                    $this->eventFormView->getEndMinute()) === true) {
                return true;
            }
        } catch (StartHourNotSelectedException $e) {
            $this->eventFormView->setStartHourNotSelectedMessage();

        }catch (StartMinuteNotSelectedException $e) {
            $this->eventFormView->setStartMinuteNotSelectedMessage();

        }catch (EndHourNotSelectedException $e) {
            $this->eventFormView->setEndHourNotSelectedMessage();

        }catch (EndMinuteNotSelectedException $e) {
            $this->eventFormView->setEndMinuteNotSelectedMessage();
        }
     return false;
    }

    private function isDateInputValid(){
        try {
            if ($this->eventModel->validateDateInput($this->eventFormView->getYear(),
                $this->eventFormView->getCurrentYear(), $this->eventFormView->getMonthInput(),
                $this->eventFormView->getCurrentMonth(), $this->eventFormView->getDay(),
                $this->eventFormView->getCurrentDay())) {
                return true;

            }
        } catch(MonthNotSelectedException $e){
            $this->eventFormView->setUnexpectedErrorMessage();

        } catch(DateHasAlredayBeenException $e){
            $this->eventFormView->setDateHasAlreadyBeenMessage();
        }
        catch (WrongDayFormatException $e) {
            $this->eventFormView->setDayNotSelectedMessage();

        }
        return false;
    }

    private function isTextInputValid(){
        try {
            if($this->eventModel->validateTextInput($this->eventFormView->getTitle(),
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

        } catch (ProhibitedCharacterInDescriptionException $e){
            $this->eventFormView->setProhibitedCharacterInDescriptionMessage();

        } catch(DescriptionToLongException $e){
            $this->eventFormView->setDescriptionToLongMessage();
        }
        return false;
    }

    public function alterEvent(){
        $event = new Event($this->eventFormView->getTitle(), $this->eventFormView->getMonthInput(),
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
     * tries to add an event
     */
    private  function addEvent(){

        $event = new Event($this->eventFormView->getTitle(), $this->eventFormView->getMonthInput(),
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

    /**
     * TODO should pass an Event as argument instead of just a title
     * tries to delete an event
     */
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

    /**
     * tries to get all events belonging the user
     * @return array events if all goes fine
     * redirects to the error page if something goes wrong
     */
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

    /**
     * TODO we should only have to set the events at one place
     */
    private function setEvents(){
        $this->calendarView->setEvents($this->getEvents());
        $this->eventFormView->setEvents($this->getEvents());
    }
}