<?php
/**
 * Created by PhpStorm.
 * User: Tobias
 * Date: 2014-10-10
 * Time: 20:35
 */

namespace View;

use Model\CalendarModel;

class ModalView {
    private $calendarModel;
    private $submitEvent = "submitEvent";
    private $titleInput = "titleInput";
    private $descriptionInput = "descriptionInput";
    private $startTimeInput = "startTimeInput";
    private $endTimeInput = "endTimeInput";
    private $dayInput = "dayInput";

    private $errorMessage;
    private $year;
    private $month;
    private $htmlMonth;

    public function __construct(){
        $this->calendarModel = new CalendarModel();
        $this->htmlMonth = date("F");
        $this->year = date("Y");
        $this->month = date("n");
    }

    public function renderModal(){
        $message = $this->calendarModel->getMessage();
        //$day = $_GET[NavigationView::$actionCalendarDay];
        $modal = "
                 <div class='modal'>
                    <div class='modalHeader'>
                     <a class='right' href='?action=".NavigationView::$actionShowCalendar."'>Tillbaka till kalendern</a>
                      <p>$this->htmlMonth $this->year</p>
                      </div>
                      <div class='modalBody'>
                      <h3>Lägg till händelse</h3>
                      <p>$message</p>
                        <form action='?action=".NavigationView::$actionAddEvent."' method='post'>

                         <div class='formGroup'>
                             <label>Dag:</label>
                             <input type='text' name=$this->dayInput>
                           </div>

                             <div class='formGroup'>
                             <p><label>Titel: </label></p>
                             <input placeholder='Ex. Kalas' type='text' value=''
                             name=$this->titleInput>
                           </div>

                           <div class='formGroup'>
                             <p><label>Starttid: </label></p>
                             <input placeholder='Ex. 18.00' type='text' value=''
                             name=$this->startTimeInput>
                           </div>

                            <div class='formGroup'>
                             <p><label>Sluttid: </label></p>
                             <input placeholder='Ex. 19.30' type='text' value=''
                             name=$this->endTimeInput>
                           </div>

                            <div class='formGroup'>
                             <p><label>Beskrivning: </label></p>
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

    public function hasUserPressedShowAddEventForm(){
        if(isset($_GET[NavigationView::$actionShowModal]) === true){
            return true;
        }
        return false;
    }

    public function hasUserPressedAddEvent(){
        if (isset($_POST[$this->submitEvent])) {
            return true;
        }
        return false;
    }

    public function getTitle(){
        if (isset($_POST[$this->titleInput])) {
            return $_POST[$this->titleInput];
        }
        return false;
    }

    public function getStartTime(){
        if (isset($_POST[$this->startTimeInput])) {
            return $_POST[$this->startTimeInput];
        }
        return false;
    }

    public function getEndTime(){
        if (isset($_POST[$this->endTimeInput])) {
            return $_POST[$this->endTimeInput];
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

    public function getMonth(){
        return $this->month;
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