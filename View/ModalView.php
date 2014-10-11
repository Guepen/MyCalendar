<?php
/**
 * Created by PhpStorm.
 * User: Tobias
 * Date: 2014-10-10
 * Time: 20:35
 */

namespace View;

use Model\ModalModel;

class ModalView {
    private $calendarModel;
    private $submitEvent = "submitEvent";
    private $titleInput = "titleInput";
    private $descriptionInput = "descriptionInput";
    private $startHourInput = "startHourInput";
    private $startMinuteInput = "startMinuteInput";
    private $endHourInput = "endHourInput";
    private $endMinuteInput = "endMinuteInput";
    private $dayInput = "dayInput";

    private $errorMessage;
    private $year;
    private $month;
    private $htmlMonth;

    public function __construct(){
        $this->calendarModel = new ModalModel();
        $this->htmlMonth = date("F");
        $this->year = date("Y");
        $this->month = date("n");
    }

    /**
     * @return bool true if the user has pressed add event
     * else false
     */
    public function hasUserPressedShowAddEventForm(){
        if(isset(NavigationView::$actionShowAddEventForm) === true){
            return true;
        }
        return false;
    }

    public function renderAddEventForm(){
        $days = $this->getDays();
        $hours = $this->getHours();
        $minutes = $this->getMinutes();
        $message = $this->calendarModel->getMessage();
        $modal = "
                 <div class='modal'>
                    <div class='modalHeader'>
                     <a class='right, addEvent' href='?action=".NavigationView::$actionShowCalendar."'>Tillbaka till kalendern</a>
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

    public function hasUserPressedAddEvent(){
        if (isset($_POST[$this->submitEvent])) {
            return true;
        }
        return false;
    }

    #region posts
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

    public function getMonth(){
        return $this->month;
    }

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
            $ret .= "<option value='0".$x."'>0".$x."</option>";
        }
        for($i = 10; $i <= 23; $i++){
            $ret .= "<option value='$i'>$i</option>";
        }

        return $ret;
    }

    public function getMinutes(){
        $ret="";
        for($x = 0; $x <= 9; $x++){
            $ret .= "<option value='0".$x."'>0".$x."</option>";
        }
        for($i = 10; $i <= 59; $i++){
            $ret .= "<option value='$i'>$i</option>";
        }
        return $ret;
    }

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

} 