<?php
/**
 * Created by PhpStorm.
 * User: Tobias
 * Date: 2014-10-10
 * Time: 23:02
 */

namespace View;


use Model\EventModel;

class EventFormView {
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
    private $monthInput = "monthInput";
    private $yearInput = "yearInput";

    private $defaultTitleValue;
    private $defaultDescriptionValue;
    private $defaultStartHourValue;
    private $defaultStartMinuteValue;
    private $defaultEndHourValue;
    private $defaultEndMinuteValue;
    private $defaultEventIdValue;
    private $defaultDayValue;
    private $defaultMonthValue;
    private $defaultYearValue;

    private $errorMessage;
    private $year;
    private $month;

    public function __construct(){
        $this->eventModel = new EventModel();
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
        $this->setDefaultValues();

        $years = $this->getYears();
        $months = $this->getMonths();
        $dates = $this->getDates();
        $hours = $this->getHours();
        $minutes = $this->getMinutes();

        //$message = $this->eventModel->getMessage();
        $modal = "
                      <div class='modalBody'>
                      <p class='error'>$this->errorMessage</p>

                             <div class='formGroup'>
                             <label class='center'>Titel: </label>
                             <input  placeholder='Ex. Kalas hos kalle' type='text' value='$this->defaultTitleValue'
                             name=$this->titleInput>
                           </div>

                            <p></p>
                           <div class='formGroup'>
                             <label>År: </label>
                             <select name='$this->yearInput'>
                              <option selected='selected' value='$this->defaultYearValue'>
                              $this->defaultYearValue
                              </option>
                               $years
                             </select>
                           </div>

                           <p></p>
                           <div class='formGroup'>
                             <label>Månad: </label>
                             <select name='$this->monthInput'>
                              <option selected='selected' value='$this->defaultMonthValue'>
                              $this->defaultMonthValue
                              </option>
                               $months
                             </select>
                           </div>

                           <p></p>
                             <div class='formGroup'>
                             <label>Datum:</label>
                             <select name=$this->dayInput>
                             <option selected='selected' value='$this->defaultDayValue'>
                             $this->defaultDayValue
                             </option>
                               $dates
                             </select>
                           </div>

                           <div class='formGroup'>
                             <p>Starttid:</p>
                             <label>Timme: </label>
                             <select name=$this->startHourInput>
                             <option selected='selected' value='$this->defaultStartHourValue'>
                             $this->defaultStartHourValue
                             </option>
                               $hours
                             </select>
                              <label>Minut: </label>
                             <select name=$this->startMinuteInput>
                             <option selected='selected' value='$this->defaultStartMinuteValue'>
                             $this->defaultStartMinuteValue
                             </option>
                               $minutes
                             </select>
                           </div>

                            <div class='formGroup'>
                             <p>Sluttid:</p>
                             <label>Timme: </label>
                             <select name=$this->endHourInput>
                             <option value='$this->defaultEndHourValue' selected='selected'>
                             $this->defaultEndHourValue
                             </option>
                               $hours
                             </select>

                              <label>Minut: </label>
                             <select name=$this->endMinuteInput>
                             <option selected='selected' value='$this->defaultEndMinuteValue'>
                             $this->defaultEndMinuteValue
                             </option>
                               $minutes
                             </select>
                           </div>

                            <div class='formGroup'>
                            <p></p>
                             <label class='description'>Beskrivning: </label>
                             <textarea rows='5' placeholder='Ex. Kalas hos kalle'
                             name=$this->descriptionInput>$this->defaultDescriptionValue</textarea>
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
                     <input type='hidden' value='".$this->defaultEventIdValue."'
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

    #region default values for eventForm

    private function setDefaultValues() {
        $this->defaultMonthValue = $this->getMonthDefaultValue();
        $this->defaultYearValue = $this->getYearDefaultValue();
        $this->defaultStartMinuteValue = "Ange Startminut";
        $this->defaultStartHourValue = "Ange Starttimme";
        $this->defaultEndMinuteValue = "Ange Slutminut";
        $this->defaultEndHourValue = "Ange Sluttimme";
        $this->defaultDayValue = $this->getDateDefaultValue();

        if($this->hasUserPressedAddEvent() === true){
            $this->setPostValuesAsDefault();
        }
        foreach ($this->events as $event) {
            if ($this->getEventTitle() === $event->getTitle()) {
                $this->defaultTitleValue = $event->getTitle();
                $this->defaultDescriptionValue = $event->getDescription();
                $this->defaultDayValue = $event->getDay();
                $this->defaultEndHourValue = $event->getEndHour();
                $this->defaultEndMinuteValue = $event->getEndMinute();
                $this->defaultStartHourValue = $event->getStartHour();
                $this->defaultStartMinuteValue = $event->getStartMinute();
                $this->defaultMonthValue = $event->getMonth();
                $this->defaultYearValue = $event->getYear();
                $this->defaultEventIdValue = $event->getEventId();
            }
        }
    }

    private function setPostValuesAsDefault(){
        $this->defaultTitleValue = $_POST[$this->titleInput];
        $this->defaultDescriptionValue = $_POST[$this->descriptionInput];
        $this->defaultDayValue = $_POST[$this->dayInput];
        $this->defaultEndHourValue = $_POST[$this->endHourInput];
        $this->defaultEndMinuteValue = $_POST[$this->endMinuteInput];
        $this->defaultStartHourValue = $_POST[$this->startHourInput];
        $this->defaultStartMinuteValue = $_POST[$this->startMinuteInput];
        $this->defaultMonthValue = $_POST[$this->monthInput];
        $this->defaultYearValue = $_POST[$this->yearInput];
    }

    #endregion

    /**
     * TODO put this in a base class?
     * @param array $events
     */
    public function setEvents(Array $events){
        $this->events = $events;

    }

    /**
     * TODO put this in a base class??
     * @return string|bool The title of chosen event
     */
    public function getEventTitle(){
        if (isset( $_GET[NavigationView::$actionShowEvent])) {
            return $_GET[NavigationView::$actionShowEvent];
        }
        return false;
    }

    private function getYearDefaultValue(){
        if(isset($_GET[NavigationView::$actionYearToShow])){
            return $_GET[NavigationView::$actionYearToShow];
        }
        return $this->year;
    }

    private function getMonthDefaultValue(){
        if(isset($_GET[NavigationView::$actionMonthToShow])){
            return $_GET[NavigationView::$actionMonthToShow];
        }
        return $this->month;
    }

    private function getDateDefaultValue(){
        if(isset($_GET["date"])){
            return $_GET["date"];
        }
        return "Ange datum";
    }

    public function getCurrentMonth(){
        return date("n");
    }

    public function getCurrentDay(){
        return date("j");
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

    private function getYears(){
        $ret="";
        $endYear = $this->year + 5;

        for($this->year; $this->year <= $endYear; $this->year++){
            $ret .= "<option value='$this->year'>$this->year</option>";
        }
        return $ret;
    }

    public function getMonths(){
        $ret="";

        for($i = 1; $i <= 12; $i++){
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

    public function getYear(){
        if (isset($_POST[$this->yearInput])) {
            return $_POST[$this->yearInput];
        }
        return false;
    }

    public function getMonthInput(){
        if (isset($_POST[$this->monthInput])) {
            return $_POST[$this->monthInput];
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
    public function setMissingTitleMessage(){
        $this->errorMessage = "Titel får inte lämnas tomt!";

    }

    public function setTitleToLongMessage(){
        $this->errorMessage = "Titeln får max vara 20 tecken!";
    }

    public function setProhibitedCharacterInTitleMessage(){
        $this->errorMessage = "Otillåtna tecken hittade i titeln!";
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