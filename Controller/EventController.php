<?php
/**
 * Created by PhpStorm.
 * User: Tobias
 * Date: 2014-10-10
 * Time: 23:05
 */

namespace Controller;


use model\EventRepository;
use model\LoginModel;
use model\UserRepository;
use View\EventView;

class EventController {
    private $userRepository;
    private $loginModel;
    private $eventRepository;
    private $eventView;

    public function __construct(){
        $this->userRepository = new UserRepository();
        $this->loginModel = new LoginModel();
        $this->eventRepository = new EventRepository();
        $this->eventView = new EventView();
    }

    public function renderEvent(){
        $this->getEvents();
        return $this->eventView->renderEvent();
    }

    public function getEvents(){
        $userId = $this->userRepository->getUserId($this->loginModel->getUserName());
        $events = $this->eventRepository->getEvents($userId);
        $this->eventView->setEvents($events);
    }


} 