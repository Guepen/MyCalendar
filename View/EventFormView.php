<?php
/**
 * Created by PhpStorm.
 * User: Tobias
 * Date: 2014-10-10
 * Time: 23:02
 */

namespace View;

class EventFormView {
    private $events;
    private $dateHelper;

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

    public function __construct(){
        $this->dateHelper = new DateHelper();
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

        $modal = "
                      <div class='modalBody'>

                             <div class='form-group'>
                             <label class='col-sm-2 control-label'>Titel: </label>
                              <div class='col-sm-10'>
                             <input class='form-control'  placeholder='Ex. Kalas' type='text'
                             value='$this->defaultTitleValue' name=$this->titleInput>
                             </div>
                           </div>
                           <p></p>

                           <div class='form-group'>
                             <label class='col-sm-2 control-label'>År: </label>
                               <div class='col-sm-10'>
                             <select class='form-control' name='$this->yearInput'>
                              <option selected='selected' value='$this->defaultYearValue'>
                              $this->defaultYearValue
                              </option>
                               $years
                             </select>
                             </div>
                           </div>
                           <p></p>

                           <div class='form-group'>
                             <label class='col-sm-2 control-label' >Månad: </label>
                               <div class='col-sm-10'>
                             <select class='form-control' name='$this->monthInput'>
                              <option selected='selected' value='$this->defaultMonthValue'>
                              $this->defaultMonthValue
                              </option>
                               $months
                             </select>
                             </div>
                           </div>
                           <p></p>

                             <div class='form-group'>
                             <label class='col-sm-2 control-label'>Datum:</label>
                               <div class='col-sm-10'>
                             <select class='form-control' name=$this->dayInput>
                             <option selected='selected' value='$this->defaultDayValue'>
                             $this->defaultDayValue
                             </option>
                               $dates
                             </select>
                             </div>
                           </div>
                           <p></p>

                            <p class='center'><label>Starttid:</label></p>

                           <div class='form-group'>
                             <label class='col-sm-2 control-label'>Timme: </label>
                              <div class='col-sm-10'>
                             <select class='form-control' name=$this->startHourInput>
                             <option selected='selected' value='$this->defaultStartHourValue'>
                             $this->defaultStartHourValue
                             </option>
                               $hours
                             </select>
                             </div>
                             </div>
                             <p></p>

                             <div class='form-group'>
                              <label class='col-sm-2 control-label'>Minut: </label>
                                <div class='col-sm-10'>
                             <select class='form-control' name=$this->startMinuteInput>
                             <option selected='selected' value='$this->defaultStartMinuteValue'>
                             $this->defaultStartMinuteValue
                             </option>
                               $minutes
                             </select>
                             </div>
                           </div>
                           <p></p>
                             <p class='center'><label>Sluttid:</label></p>

                            <div class='form-group'>
                             <label class='col-sm-2 control-label'>Timme: </label>
                             <div class='col-sm-10'>
                             <select class='form-control' name=$this->endHourInput>
                             <option value='$this->defaultEndHourValue' selected='selected'>
                             $this->defaultEndHourValue
                             </option>
                               $hours
                             </select>
                             </div>
                             </div>
                             <p></p>
                             <div class='form-group'>
                              <label class='col-sm-2 control-label'>Minut: </label>
                              <div class='col-sm-10'>
                             <select class='form-control' name=$this->endMinuteInput>
                             <option selected='selected' value='$this->defaultEndMinuteValue'>
                             $this->defaultEndMinuteValue
                             </option>
                               $minutes
                             </select>
                             </div>
                           </div>
                           <p></p>
                            <div class='form-group'>
                             <label class='col-sm-2 control-label'>Beskrivning:</label>
                              <div class='col-sm-10'>
                             <textarea class='form-control' rows='5' placeholder='Ex. Kalas hos kalle'
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
        $modal="<div class='eventModal'>
                <a class='addEvent' href='?action=".NavigationView::$actionShowCalendar.'&'.
            NavigationView::$actionMonthToShow.'='. $this->dateHelper->getMonthToShow().'&'.
            NavigationView::$actionYearToShow.'='. $this->dateHelper->getYearToShow()."'>
                     Tillbaka till kalendern
                     </a>
                 $this->errorMessage
                <h3>Ändra händelse</h3>
            <form action='?action=".NavigationView::$actionSubmitAlteredEvent.'&'.
            NavigationView::$actionMonthToShow.'='. $this->dateHelper->getMonthToShow().'&'.
            NavigationView::$actionYearToShow.'='. $this->dateHelper->getYearToShow().'&'.
            NavigationView::$actionShowEvent.'='.$this->getEventTitle()."' method='post'>";

        $modal .= $this->getEventForm();
        $modal .= "<div class='hidden'>
                     <input type='hidden' value='".$this->defaultEventIdValue."'
                             name='$this->eventIdInput'
                   </div></div>

                   <div class='form-group'>
                     <div class='col-sm-offset-2 col-sm-10'>
                     <input class='btn btn-success' type='submit' value='Uppdatera'
                             name=$this->submitAlterEvent>
                   </div>
                   </div>";
        $modal .= "</form></div>";


        return $modal;

    }

    /**
     * @return string with HTML for add event form
     */
    public function renderAddEventForm(){
        $modal = "<div class='eventModal'>
                  <a class='right, addEvent' href='?action=".NavigationView::$actionShowCalendar.'&'.
            NavigationView::$actionMonthToShow.'='. $this->dateHelper->getMonthToShow().'&'.
            NavigationView::$actionYearToShow.'='. $this->dateHelper->getYearToShow()."'>
                     Tillbaka till kalendern
                     </a>
                    $this->errorMessage
                   <form action='?action=".NavigationView::$actionAddEvent.'&'.
            NavigationView::$actionMonthToShow.'='. $this->dateHelper->getMonthToShow().'&'.
            NavigationView::$actionYearToShow.'='. $this->dateHelper->getYearToShow()."' method='post'>
                   <legend>Lägg till händelse</legend>";
        $modal .=$this->getEventForm();
        $modal .= "<div class='form-group'>
                       <div class='col-sm-offset-2 col-sm-10'>
                             <input class='btn btn-success' type='submit' value='Lägg till'
                             name=$this->submitEvent>
                           </div>
                           </div>";
        $modal .= "</form></div>";

        return $modal;
    }

    #region default values for eventForm

    private function setDefaultValues() {
        $this->defaultMonthValue = $this->dateHelper->getMonthToShow();
        $this->defaultYearValue = $this->dateHelper->getYearToShow();
        $this->defaultStartMinuteValue = "Ange Startminut";
        $this->defaultStartHourValue = "Ange Starttimme";
        $this->defaultEndMinuteValue = "Ange Slutminut";
        $this->defaultEndHourValue = "Ange Sluttimme";
        $this->defaultDayValue = $this->getDateDefaultValue();

        if($this->hasUserPressedAddEvent() === true){
            $this->setPostValuesAsDefault();
        }
        $this->setDefaultValuesFromEvent();
    }

    private function setDefaultValuesFromEvent(){
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
     * TODO put this in a helper-class or even base class? We use this exact function in multiple views
     * @param array $events
     */
    public function setEvents(Array $events){
        $this->events = $events;

    }

    /**
     * TODO put this in a helper-class or even base class? We use this exact function in multiple views
     * @return string|bool The title of chosen event
     */
    public function getEventTitle(){
        if (isset( $_GET[NavigationView::$actionShowEvent])) {
            return $_GET[NavigationView::$actionShowEvent];
        }
        return false;
    }

    /**
     * @return string
     */
    private function getDateDefaultValue(){
        if(isset($_GET[NavigationView::$actionDateToShow])){
            return $_GET[NavigationView::$actionDateToShow];
        }
        return "Ange datum";
    }

    /**
     * TODO put these three getters in DateHelper??
     * @return bool|string
     */
    public function getCurrentYear(){
        return date("Y");
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
        $days = cal_days_in_month(CAL_GREGORIAN, $this->dateHelper->getMonthToShow(), $this->dateHelper->getYearToShow());
        $ret="";

        for($i = 1; $i <= $days; $i++){
            $ret .= "<option value='$i'>$i</option>";
        }
        return $ret;
    }

    private function getYears(){
        $ret="";
        $year = $this->getCurrentYear();
        $endYear = $year + 5;

        for($year; $year <= $endYear; $year++){
            $ret .= "<option value='$year'>$year</option>";
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

    private function getAlert(){
        $ret = "<div class='alert alert-danger alert-error'>
                  <a href='#' class='close' data-dismiss='alert'>&times;</a>";

        return $ret;
    }
    public function setMissingTitleMessage(){
        $this->errorMessage = $this->getAlert();
        $this->errorMessage .= "Titel får inte lämnas tomt!
                                </div>";

    }

    public function setTitleToLongMessage(){
        $this->errorMessage = $this->getAlert();
        $this->errorMessage .= "Titeln får max vara 20 tecken!</div>";
    }

    public function setProhibitedCharacterInTitleMessage(){
        $this->errorMessage = $this->getAlert();
        $this->errorMessage .= "Otillåtna tecken hittade i titeln!  Ex.<></div>";
    }

    public function setMissingDescriptionMessage(){
        $this->errorMessage = $this->getAlert();
        $this->errorMessage .= "Beskrivning får inte lämnas tomt!</div>";
    }

    public function setDescriptionToLongMessage(){
        $this->errorMessage = $this->getAlert();
        $this->errorMessage .= "Beskrivning får max innehålla 255 tecken!</div>";
    }

    public function setProhibitedCharacterInDescriptionMessage(){
        $this->errorMessage = $this->getAlert();
        $this->errorMessage .= "Otillåtna tecken hittade i beskrivningen! Ex.<></div>";
    }

    public function setDateHasAlreadyBeenMessage(){
        $this->errorMessage = $this->getAlert();
        $this->errorMessage .= "Det här datumet har redan varit!</div>";
    }

    public function setDayNotSelectedMessage(){
        $this->errorMessage = $this->getAlert();
        $this->errorMessage .= "Du måste välja ett datum!</div>";
    }

    public function setStartHourNotSelectedMessage(){
        $this->errorMessage = $this->getAlert();
        $this->errorMessage .= "Du måste välja en starttime!</div>";
    }

    public function setStartMinuteNotSelectedMessage(){
        $this->errorMessage = $this->getAlert();
        $this->errorMessage .= "Du måste välja en startminut!</div>";
    }

    public function setEndHourNotSelectedMessage(){
        $this->errorMessage = $this->getAlert();
        $this->errorMessage .= "Du måste välja en sluttime!</div>";
    }

    public function setEndMinuteNotSelectedMessage(){
        $this->errorMessage = $this->getAlert();
        $this->errorMessage .= "Du måste välja en slutminut!</div>";
    }

    public function setUnexpectedErrorMessage(){
        $this->errorMessage = $this->getAlert();
        $this->errorMessage .= "Ett oväntat fel inträffade! Försök igen</div>";
    }
    #endregion
}