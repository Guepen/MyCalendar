<?php
/**
 * Created by PhpStorm.
 * User: Tobias
 * Date: 2014-10-10
 * Time: 21:39
 */

namespace Controller;


use Model\ModalModel;
use model\DbException;
use model\EmptyDescriptionException;
use model\EmptyTitleException;
use model\Event;
use model\EventRepository;
use model\LoginModel;
use model\UserRepository;
use model\WrongDayFormatException;
use model\WrongMonthFormatException;
use model\WrongTimeFormatException;
use view\ModalView;
use view\NavigationView;

class ModalController {
    private $modalView;
    private $calendarModel;
    private $userRepository;
    private $eventRepository;
    private $loginModel;

    public function __construct(){
        $this->modalView = new ModalView();
        $this->calendarModel = new ModalModel();
        $this->userRepository = new UserRepository();
        $this->loginModel = new LoginModel();
        $this->eventRepository = new EventRepository();
    }

    /**
     * if user has pressed the add event link @return string the modal/popup
     * else @return bool false
     */
    public function hasUserPressedShowAddEventForm(){
        if ($this->modalView->hasUserPressedShowAddEventForm()) {
            return $this->modalView->renderAddEventForm();
        }
        return false;
    }

    /**
     * if input from the add event form is valid,
     * create a new event belonging the user
     */
    public function checkIfInputIsValid(){
        try {
            if($this->calendarModel->validateInput($this->modalView->getTitle(),
                    $this->modalView->getMonth(), $this->modalView->getDay(), $this->modalView->getStartHour(),
                    $this->modalView->getStartMinute(), $this->modalView->getEndHour(),
                    $this->modalView->getEndMinute(), $this->modalView->getDescription()) === true){
                $this->addEvent();
                return;

            }
        } catch (EmptyTitleException $e) {
            $this->modalView->setMissingTitleMessage();

        } catch(EmptyDescriptionException $e){
            $this->modalView->setMissingDescriptionMessage();

        } catch(WrongDayFormatException $e){
            $this->modalView->setUnexpectedErrorMessage();

        } catch(WrongTimeFormatException $e){
            $this->modalView->setWrongTimeFormatMessage();

        } catch(WrongMonthFormatException $e) {
            $this->modalView->setUnexpectedErrorMessage();

        }
        $this->calendarModel->setMessage($this->modalView->getMessage());
        NavigationView::redirectToModal();
    }

    /**
     * tries to add en event
     * @throws DbException
     */
    public function addEvent(){

        $event = new Event($this->modalView->getTitle(), $this->modalView->getMonth(),
            $this->modalView->getDay(), $this->modalView->getStartHour(),
            $this->modalView->getStartMinute(), $this->modalView->getEndHour(),
            $this->modalView->getEndMinute(), $this->modalView->getDescription());

        try {
            $userId = $this->userRepository->getUserId($this->loginModel->getUserName());
            $this->eventRepository->add($event, $userId);
            NavigationView::redirectToCalendar();
        } catch (DbException $e) {
            NavigationView::redirectToErrorPage();

        }

    }

} 