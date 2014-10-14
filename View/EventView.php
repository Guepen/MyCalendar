<?php
/**
 * Created by PhpStorm.
 * User: Tobias
 * Date: 2014-10-10
 * Time: 23:02
 */

namespace View;


use Model\EventModel;

class EventView {
    private $events;

    private $eventModel;
    private $submitEvent = "submitEvent";
    private $submitAlterEvent = "submitAlterEvent";
    private $titleInput = "titleInput";
    private $descriptionInput = "descriptionInput";
    private $startHourInput = "startHourInput";
    private $startMinuteInput = "startMinuteInput";
    private $endHourInput = "endHourInput";
    private $endMinuteInput = "endMinuteInput";
    private $dayInput = "dayInput";
    private $eventIdInput = "eventIdInput";

    private $errorMessage;
    private $year;
    private $month;
    private $htmlMonth;

    public function __construct(){
        $this->eventModel = new EventModel();
        $this->htmlMonth = date("F");
        $this->year = date("Y");
        $this->month = date("n");
    }

    public function hasUserPressedShowAddEventForm(){
        if(isset(NavigationView::$actionShowAddEventForm) === true){
            return true;
        }
        return false;
    }

    /**
     * @return string with HTML for the add event form
     */
    public function renderAddEventForm(){
        $days = $this->getDays();
        $hours = $this->getHours();
        $minutes = $this->getMinutes();
        $message = $this->eventModel->getMessage();
        $modal = "
                 <div class='modal'>
                    <div class='modalHeader'>
                     <a class='right, addEvent' href='?action=".NavigationView::$actionShowCalendar."'>
                     Tillbaka till kalendern</a>
                      <p>$this->htmlMonth $this->year</p>
                      </div>
                      <div class='modalBody'>
                      <h3>Lägg till händelse</h3>
                      <p>$message</p>
                        <form action='?action=".NavigationView::$actionAddEvent."' method='post'>

                             <div class='formGroup'>
                             <label>Titel: </label>
                             <input placeholder='Ex. Kalas' type='text' value=''
                             name=$this->titleInput>
                           </div>
                           <p></p>
                             <div class='formGroup'>
                             <label>Datum:</label>
                             <select name=$this->dayInput>
                               $days
                             </select>
                           </div>

                           <div class='formGroup'>
                             <p>Starttid:</p>
                             <label>Timme: </label>
                             <select name=$this->startHourInput>
                               $hours
                             </select>
                              <label>Minut: </label>
                             <select name=$this->startMinuteInput>
                               $minutes
                             </select>
                           </div>

                            <div class='formGroup'>
                             <p>Sluttid:</p>
                             <label>Timme: </label>
                             <select name=$this->endHourInput>
                               $hours
                             </select>
                              <label>Minut: </label>
                             <select name=$this->endMinuteInput>
                               $minutes
                             </select>
                           </div>

                            <div class='formGroup'>
                            <p></p>
                             <label class='description'>Beskrivning: </label>
                             <textarea rows='5' placeholder='Ex. Kalas hos kalle' type='text' value=''
                             name=$this->descriptionInput></textarea>
                           </div>

                            <div class='formGroup'>
                             <input type='submit' value='Lägg till'
                             name=$this->submitEvent>
                           </div>

                        </form>
                      </div>
                      </div>
        ";

        return $modal;
    }

    /**
     * TODO This form is the same as add event form except the default values. We should reuse that form
     * @return string With HTML for alter event form
     */
    public function renderAlterEventForm(){
        $event = $this->getEvent();
        $days = $this->getDays();
        $hours = $this->getHours();
        $minutes = $this->getMinutes();
        $message = $this->eventModel->getMessage();
        $modal = "
                 <div class='modal'>
                    <div class='modalHeader'>
                     <a class='right, addEvent' href='?action=".
            NavigationView::$actionShowCalendar."'>Tillbaka till kalendern</a>
                      <p>$this->htmlMonth $this->year</p>
                      </div>
                      <div class='modalBody'>
                      <h3>Ändra händelse</h3>
                      <p>$message</p>
                        <form action='?action=".NavigationView::$actionSubmitAlteredEvent."' method='post'>

                        <div class='hidden'>
                             <input type='text' value='".$event->getEventId()."'
                             name=$this->eventIdInput>
                           </div>

                             <div class='formGroup'>
                             <label>Titel: </label>
                             <input placeholder='Ex. Kalas' type='text' value='".$event->getTitle()."'
                             name=$this->titleInput>
                           </div>
                           <p></p>
                             <div class='formGroup'>
                             <label>Datum:</label>
                             <select name=$this->dayInput>
                               $days
                             </select>
                           </div>

                           <div class='formGroup'>
                             <p>Starttid:</p>
                             <label>Timme: </label>
                             <select name=$this->startHourInput>
                               $hours
                             </select>
                              <label>Minut: </label>
                             <select name=$this->startMinuteInput>
                               $minutes
                             </select>
                           </div>

                            <div class='formGroup'>
                             <p>Sluttid:</p>
                             <label>Timme: </label>
                             <select name=$this->endHourInput>
                               $hours
                             </select>
                              <label>Minut: </label>
                             <select name=$this->endMinuteInput>
                               $minutes
                             </select>
                           </div>

                            <div class='formGroup'>
                            <p></p>
                             <label class='description'>Beskrivning: </label>
                             <textarea rows='5' type='text'
                             name=$this->descriptionInput>".$event->getDescription()."</textarea>
                           </div>

                            <div class='formGroup'>
                             <input type='submit' value='Uppdatera'
                             name=$this->submitAlterEvent>
                           </div>

                        </form>
                      </div>
                      </div>
        ";

        return $modal;

    }


    /**
     * @return string with HTML for chosen event
     */
    public function renderEvent(){
        $ret = "";
        $title = $this->getEventTitle();
        foreach ($this->events as $event) {
            if ($event->getTitle() === $title) {
                $ret = "
                <div class='modal'>
                 <a class='right, addEvent' href='?action=" .
                    NavigationView::$actionShowCalendar . "'>Tillbaka till kalendern</a>
                  <h3 class='center'>" . $event->getTitle() . "</h3>
                  <p class='center'>" . $event->getDescription() . "</p>
                  <p class='center'>Händelsen inträffar den " . $event->getDay() . " " . date("F") . "</p>
                  <p class='center'>Pågår mellan " . $event->getStartHour().":".$event->getStartMinute()
                    . "-" . $event->getEndHour() .":".$event->getEndMinute(). "</p>

                    <a class='addEvent' href='?action=".NavigationView::$actionAlterEvent . "&".
                    NavigationView::$actionShowEvent ."=". $event->getTitle() ."'>Ändra Händelsen</a>
                     <a class='right' href='?action=".NavigationView::$actionDeleteEvent."&".
                    NavigationView::$actionShowEvent."=".$event->getTitle()."'>Ta bort Händelse</a>
                </div>
                ";
            }
        }
        return $ret;

    }

    /**
     * @return string with HTML containing a list of all events
     */
    public function renderEventList(){
        $eventList = $this->getEventList();

        $ret ="<div class='modal'>
                  $eventList

               </div>";

        return $ret;
    }

    /**
     * TODO maybe put this in renderEventList()?
     * @return string with HTML  containing a list of all events
     */
    public function getEventList(){
        $ret="";
        foreach ($this->events as $event ) {
            $ret .= "
            <p>
                 <li>".$event->getTitle()."
                 <a href='?action=".NavigationView::$actionAlterEvent."&".
                NavigationView::$actionShowEvent."=".$event->getTitle()."'>Ändra händele</a>

                 <a href='?action=".NavigationView::$actionDeleteEvent."&".
                NavigationView::$actionShowEvent."=".$event->getTitle()."'>Ta bort Händelse</a>

                 </li>
                </p>";
        }
        return $ret;
    }

    /**
     * @return object event if it is found in the array
     */
    private function getEvent(){
        $eventTitle = $this->getEventTitle();
        $ret = null;

        foreach($this->events as $event){
            if($eventTitle === $event->getTitle()){
                $ret = $event;
            }
        }
        return $ret;

    }

    public function setEvents(Array $events){
        $this->events = $events;

    }

    /**
     * @return string|bool The title of chosen event
     */
    public function getEventTitle(){
        if (isset( $_GET[NavigationView::$actionShowEvent])) {
            return $_GET[NavigationView::$actionShowEvent];
        }
        return false;
    }

    public function getMonth(){
        return $this->month;
    }

    /**
     * @return string with HTML options for dropdown list containing all dates in the month
     */
    public function getDays(){
        $days = cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year);
        $ret="";

        for($i = 1; $i <= $days; $i++){
            $ret .= "<option value='$i'>$i</option>";
        }
        return $ret;
    }


    public function getHours(){
        $ret="";
        for($x = 0; $x <= 9; $x++){
            $ret .= "<option value='0" . $x . "'>0" . $x . "</option>";
        }

        for($i = 10; $i <= 23; $i++){
            $ret .= "<option value='$i'>$i</option>";
        }
        return $ret;
    }

    public function getMinutes(){
        $ret="";
        for($x = 0; $x <= 9; $x++){
            $ret .= "<option value='0" . $x . "'>0" . $x . "</option>";

        }
        for($i = 10; $i <= 59; $i++){
            $ret .= "<option value='$i'>$i</option>";
        }
        return $ret;
    }


    #region posts
    public function hasUserPressedAddEvent(){
        if (isset($_POST[$this->submitEvent])) {
            return true;
        }
        return false;
    }

    public function getEventId(){
        if(isset($_POST[$this->eventIdInput])){
            return $_POST[$this->eventIdInput];
        }
        return false;
    }

    public function getTitle(){
        if (isset($_POST[$this->titleInput])) {
            return $_POST[$this->titleInput];
        }
        return false;
    }

    public function getStartHour(){
        if (isset($_POST[$this->startHourInput])) {
            return $_POST[$this->startHourInput];
        }
        return false;
    }

    public function getStartMinute(){
        if (isset($_POST[$this->startMinuteInput])) {
            return $_POST[$this->startMinuteInput];
        }
        return false;
    }

    public function getEndHour(){
        if (isset($_POST[$this->endHourInput])) {
            return $_POST[$this->endHourInput];
        }
        return false;
    }

    public function getEndMinute(){
        if (isset($_POST[$this->endMinuteInput])) {
            return $_POST[$this->endMinuteInput];
        }
        return false;
    }

    public function getDescription(){
        if (isset($_POST[$this->descriptionInput])) {
            return $_POST[$this->descriptionInput];
        }
        return false;
    }

    public function getDay(){
        if (isset($_POST[$this->dayInput])) {
            return $_POST[$this->dayInput];
        }
        return false;
    }
    #endregion

    #region messages
    public function getMessage(){
        return $this->errorMessage;
    }

    public function setMissingTitleMessage(){
        $this->errorMessage = "Titel får inte lämnas tomt!";

    }

    public function setMissingDescriptionMessage(){
        $this->errorMessage = "Beskrivning får inte lämnas tomt!";
    }

    public function setWrongTimeFormatMessage(){
        $this->errorMessage = "Fel format på tiden! Exempel på godkänt format: 16.00";
    }

    public function setUnexpectedErrorMessage(){
        $this->errorMessage = "Ett oväntat fel inträffade! Försök igen";
    }
    #endregion
} 