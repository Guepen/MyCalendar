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

    public function hasUserPressedShowEventForm(){
        if(isset(NavigationView::$actionShowEventForm) === true){
            return true;
        }
        return false;
    }

    #region The eventForm
    /**
     * @return string with HTML for common values between addEventForm and alterEventForm
     */
    private function getEventForm(){
        $titleValue = $this->getTitleValue();
        $dayValue = $this->getDateValue();
        $startHourValue = $this->getStartHourValue();
        $endHourValue = $this->getEndHourValue();
        $startMinuteValue = $this->getStartMinuteValue();
        $endMinuteValue = $this->getEndMinuteValue();
        $descriptionValue = $this->getDescriptionValue();

        $dates = $this->getDates();
        $hours = $this->getHours();
        $minutes = $this->getMinutes();

        $message = $this->eventModel->getMessage();
        $modal = "
                      <div class='modalBody'>
                      <p>$message</p>

                             <div class='formGroup'>
                             <label>Titel: </label>
                             <input type='text' value='$titleValue'
                             name=$this->titleInput>
                           </div>
                           <p></p>
                             <div class='formGroup'>
                             <label>Datum:</label>
                             <select name=$this->dayInput>
                             <option selected='selected' value='$dayValue'>$dayValue</option>
                               $dates
                             </select>
                           </div>

                           <div class='formGroup'>
                             <p>Starttid:</p>
                             <label>Timme: </label>
                             <select name=$this->startHourInput>
                             <option selected='selected' value='$startHourValue'>$startHourValue</option>
                               $hours
                             </select>
                              <label>Minut: </label>
                             <select name=$this->startMinuteInput>
                             <option selected='selected' value='$startMinuteValue'>$startMinuteValue</option>
                               $minutes
                             </select>
                           </div>

                            <div class='formGroup'>
                             <p>Sluttid:</p>
                             <label>Timme: </label>
                             <select name=$this->endHourInput>
                             <option value='$endHourValue' selected='selected'>$endHourValue</option>
                               $hours
                             </select>
                              <label>Minut: </label>
                             <select name=$this->endMinuteInput>
                             <option selected='selected' value='$endMinuteValue'>$endMinuteValue</option>
                               $minutes
                             </select>
                           </div>

                            <div class='formGroup'>
                            <p></p>
                             <label class='description'>Beskrivning: </label>
                             <textarea rows='5' placeholder='Ex. Kalas hos kalle'
                             name=$this->descriptionInput>$descriptionValue</textarea>
                           </div>
                      </div>
        ";

        return $modal;
    }

    #endregion

    /**
     * @return string With HTML for alter event form
     */
    public function renderAlterEventForm(){
        $modal="<div class='modal'>
                <a class='right, addEvent' href='?action=".NavigationView::$actionShowCalendar."'>
                     Tillbaka till kalendern</a>
                <h3>Ändra händelse</h3>
            <form action='?action=".NavigationView::$actionSubmitAlteredEvent."' method='post'>";
        $modal .= $this->getEventForm();
        $modal .= "<div class='hidden'>
                     <input type='hidden' value='".$this->getEventIdValue()."'
                             name='$this->eventIdInput'
                   </div></div>

                   <div class='formGroup'>
                     <input type='submit' value='Uppdatera'
                             name=$this->submitAlterEvent>
                   </div>";
        $modal .= "</form></div>";


        return $modal;

    }

    /**
     * @return string with HTML for add event form
     */
    public function renderAddEventForm(){
        $modal = "<div class='modal'>
                  <a class='right, addEvent' href='?action=".NavigationView::$actionShowCalendar."'>
                     Tillbaka till kalendern</a>
                  <h3>Lägg till händelse</h3>
                   <form action='?action=".NavigationView::$actionAddEvent."' method='post'>";
        $modal .=$this->getEventForm();
        $modal .= "<div class='formGroup'>
                             <input type='submit' value='Lägg till'
                             name=$this->submitEvent>
                           </div>";
        $modal .= "</form></div>";

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
                 <a class='right, green' href='?action=" .
                    NavigationView::$actionShowCalendar . "'>Tillbaka till kalendern</a>
                  <h3 class='center'>" . $event->getTitle() . "</h3>
                  <p class='center'>" . $event->getDescription() . "</p>
                  <p class='center'>Händelsen inträffar den " . $event->getDay() . " " . date("F") . "</p>
                  <p class='center'>Pågår mellan " . $event->getStartHour().":".$event->getStartMinute()
                    . "-" . $event->getEndHour() .":".$event->getEndMinute(). "</p>

                    <a class='green' href='?action=".NavigationView::$actionAlterEvent . "&".
                    NavigationView::$actionShowEvent ."=". $event->getTitle() ."'>Ändra Händelsen</a>
                     <a class='right, red' href='?action=".NavigationView::$actionDeleteEvent."&".
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

    #region default values for eventForm

    private function getEventIdValue(){
        $ret="";

        foreach($this->events as $event){
            if($this->getEventTitle() === $event->getTitle()){
                $ret = $event->getEventId();
            }
        }

        return $ret;
    }

    /**
     * @return string Default value for title input in eventForm
     */
    private function getTitleValue(){
        $eventTitle = $this->getEventTitle();
        $ret = "";

        foreach($this->events as $event){
            if($eventTitle === $event->getTitle()){
                $ret = $event->getTitle();
            }
        }
        return $ret;
    }

    /**
     * @return string Default value for date input in eventForm
     */
    private function getDateValue(){
        $ret="Välj datum";

        foreach($this->events as $event){
            if($this->getEventTitle() === $event->getTitle()){
                $ret = $event->getDay();
            }
        }

        return $ret;
    }

    /**
     * @return string Default value for start hour input in eventForm
     */
    private function getStartHourValue(){
        $ret="Ange starttimme";

        foreach($this->events as $event){
            if($this->getEventTitle() === $event->getTitle()){
                $ret = $event->getStartHour();
            }
        }

        return $ret;
    }

    /**
     * @return string Default value for end hour input in eventForm
     */
    private function getEndHourValue(){
        $ret="Ange sluttimme";

        foreach($this->events as $event){
            if($this->getEventTitle() === $event->getTitle()){
                $ret = $event->getEndHour();
            }
        }

        return $ret;
    }

    /**
     * @return string Default value for start minute input in eventForm
     */
    private function getStartMinuteValue(){
        $ret="Ange startminut";

        foreach($this->events as $event){
            if($this->getEventTitle() === $event->getTitle()){
                $ret = $event->getStartMinute();
            }
        }

        return $ret;
    }

    /**
     * @return string Default value for end minute input in eventForm
     */
    private function getEndMinuteValue(){
        $ret="Ange slutminut";

        foreach($this->events as $event){
            if($this->getEventTitle() === $event->getTitle()){
                $ret = $event->getEndMinute();
            }
        }

        return $ret;
    }

    /**
     * @return string Default value for description input in eventForm
     */
    private function getDescriptionValue(){
        $ret="";

        foreach($this->events as $event){
            if($this->getEventTitle() === $event->getTitle()){
                $ret = $event->getDescription();
            }
        }

        return $ret;
    }

    #endregion


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

    #region form dropdown options

    /**
     * @return string with HTML options for dropDown list containing all dates in the month for EventForm
     */
    public function getDates(){
        $days = cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year);
        $ret="";

        for($i = 1; $i <= $days; $i++){
            $ret .= "<option value='$i'>$i</option>";
        }
        return $ret;
    }

    /**
     * @return string with HTML options for dropDown list containing all possible hours for eventForm
     */
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

    /**
     * @return string HTML options for dropDown list containing all possible minutes for eventForm
     */
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

    #endregion

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