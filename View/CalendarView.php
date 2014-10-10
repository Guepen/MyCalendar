<?php

namespace view;


use Model\CalendarModel;

class CalendarView{
    private $month;
    private $year;
    private $htmlMonth;
    private $firstDayInMonth;
    private $dayOfTheWeek;
    private $days;

    private $submitEvent = "submitEvent";
    private $titleInput = "titleInput";
    private $descriptionInput = "descriptionInput";
    private $startTimeInput = "startTimeInput";
    private $endTimeInput = "endTimeInput";
    private $dayInput = "dayInput";
    private $errorMessage;
    private $events;

    private $calendarModel;

    public function __construct(){
        $this->year = date("Y");
        $this->dayOfTheWeek = 1;
        $this->month = date("n");
        $this->htmlMonth = date("F");
        $this->firstDayInMonth = date('w',mktime(0,0,0,$this->month,0,$this->year));
        $this->days = array("Måndag", "Tisdag", "Onsdag", "Torsdag", "Fredag", "Lördag", "Söndag");

        $this->calendarModel = new CalendarModel();
    }


    /**
     * @return string HTML td columns with the days of a week
     */
    public function getCalendarDays(){
        //$days = array("Måndag", "Tisdag", "Onsdag", "Torsdag", "Fredag", "Lördag", "Söndag");
        $ret="";

        for($i = 0; $i < count($this->days); $i++){
            $ret .= '<td class="day">'.$this->days[$i].'</td>';
        }
        return $ret;
    }

    /**
     * @return string HTML td columns for first days without a date
     */
    public function getEmptyDays(){
        $ret="";
        for($i = 0; $i < $this->firstDayInMonth; $i++){
            $ret.= '<td class="emptyDay"> </td>';
            $this->dayOfTheWeek++;
        }
        return $ret;
    }

    /**
     * @return string HTML td columns for last days without a date
     */
    public function getRemainingDays(){
        $ret="";
        for($i = 1; $i <= (8 - $this->dayOfTheWeek); $i++){
            $ret .= '<td class="emptyDay"> </td>';
        }
        return $ret;
    }

    /**
     * @return string HTML with date columns/td and date boxes/div
     */
    public function getDates(){
        $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year);
        $dayCounter = 0;
        $ret="";
        $eventBox="";
        for($i = 1; $i <= $numberOfDays; $i++) {
            foreach ($this->events as $event) {
                //var_dump($event->getDay());
                if($event->getDay() == $i){
                   $eventBox .= "<div><a href='?action=".NavigationView::$actionShowCalendar."&".
                                                         NavigationView::$actionCalendarEvent."=".$event->getTitle()."'>
                           <h4>'".$event->getTitle()."'</h4></a></div>";
                }
            }
                $ret .= '
                    <td class="calendarDay">
                    <div class="dayNumber">' . $i .$eventBox.'</div>
                    </a>
                    </td>
                    ';
            $eventBox ="";

                //new row in table if we are on the last day
                //and reset day variables
                if ($this->firstDayInMonth === 6) {
                    $ret .= '</tr>';
                    if ($dayCounter + 1 !== $numberOfDays) {
                        $ret .= '<tr class="row">';
                        $this->firstDayInMonth = -1;
                        $this->dayOfTheWeek = 0;
                    }
                }
                $this->dayOfTheWeek++;
                $this->firstDayInMonth++;
                $dayCounter++;
        }
        return $ret;
    }

    public function renderCalendar(){
        $modal="";
        //if user has clicked a date
        if(isset($_GET[NavigationView::$actionShowModal]) === true){
            $modal = $this->renderModal();
        }

        $calendar = "<table cellpadding='0' cellspacing='0' class='calendar'>";
        $calendar .= '<tr class="row">'.$this->getCalendarDays().'</tr>';
        $calendar .= '<tr class="row">'.$this->getEmptyDays();
        $calendar .= $this->getDates();

        if($this->dayOfTheWeek < 8){
            $calendar .= $this->getRemainingDays();
        }

        $calendar.= '</tr>';
        $calendar.= '</table>';

        $html = '
           <div class="centerMonth">
           <a class="btn btn-default" href="?action='.NavigationView::$actionShowCalendar.'&'.NavigationView::$actionShowModal.'">
           Lägg till händelse
           </a>
           <div>
            <label>'.$this->year.'</label>'.'
             <label>'.$this->htmlMonth.'</label>'.'
             </div>
             </div>'.
            $calendar.
            $modal.'
        ';

        return $html;
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

    #region posts
    public function hasUserPressedAddEvent(){
        if(isset($_POST[$this->submitEvent])){
            return true;
        }
        return false;
    }

    public function getTitle(){
        if(isset($_POST[$this->titleInput])){
            return $_POST[$this->titleInput];
        }
        return false;
    }

    public function getStartTime(){
        if(isset($_POST[$this->startTimeInput])){
            return $_POST[$this->startTimeInput];
        }
        return false;
    }

    public function getEndTime(){
        if(isset($_POST[$this->endTimeInput])){
            return $_POST[$this->endTimeInput];
        }
        return false;
    }

    public function getDescription(){
        if(isset($_POST[$this->descriptionInput])){
            return $_POST[$this->descriptionInput];
        }
        return false;
    }

    public function getDay(){
        if(isset($_POST[$this->dayInput])){
            return $_POST[$this->dayInput];
        }
        return false;
    }
    #endregion

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

    public function setUnexpectedErrorMessag(){
        $this->errorMessage = "Ett oväntat fel inträffade! Försök igen";
    }

    public function setEvents($events){
        $this->events = $events;

    }
}