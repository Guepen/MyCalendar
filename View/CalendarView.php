<?php

namespace view;


class CalendarView{
    private $month;
    private $year;
    private $htmlMonth;
    private $firstDayInMonth;
    private $dayOfTheWeek;

    private $submitEvent = "submitEvent";
    private $titleInput = "titleInput";
    private $descriptionInput = "descriptionInput";
    private $startTimeInput = "startTimeInput";
    private $endTimeInput = "endTimeInput";
    private $dayInput = "dayInput";

    public function __construct(){
        $this->year = date("Y");
        $this->dayOfTheWeek = 1;
        $this->month = date("n");
        $this->htmlMonth = date("F");
        $this->firstDayInMonth = date('w',mktime(0,0,0,$this->month,0,$this->year));
    }


    /**
     * @return string HTML td columns with the days of a week
     */
    public function getCalendarDays(){
        $days = array("Måndag", "Tisdag", "Onsdag", "Torsdag", "Fredag", "Lördag", "Söndag");
        $ret="";

        for($i = 0; $i < count($days); $i++){
            $ret .= '<td class="day">'.$days[$i].'</td>';
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

        for($i = 1; $i <= $numberOfDays; $i++){
            $ret.= '
                    <td class="calendarDay">
                     <a href="?action='.NavigationView::$actionShowCalendar.'&'.
                NavigationView::$actionCalendarDay.'='.$i .'">

                    <div class="dayNumber">'.$i.'</div>
                    </a>
                    </td>
                    ';

            //new row in table if we are on the last day
            //and reset day variables
            if($this->firstDayInMonth === 6){
                $ret .= '</tr>';
                if($dayCounter + 1 !== $numberOfDays){
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
        if(isset($_GET[NavigationView::$actionCalendarDay]) === true){
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

        //if user has clicked a date

        $html = '
            <p class="centerMonth">'.$this->htmlMonth. $this->year.'</p>'.
            $calendar.
            $modal.'
        ';

        return $html;
    }

    public function renderModal(){
        $day = $_GET[NavigationView::$actionCalendarDay];
        $modal = "
                 <div class='modal'>
                    <div class='modalHeader'>
                     <a class='right' href='?action=".NavigationView::$actionShowCalendar."'>Tillbaka till kalendern</a>
                      <p>$day $this->htmlMonth $this->year</p>
                      </div>
                      <div class='modalBody'>
                      <h3>Lägg till händelse</h3>
                        <form action='?action=".NavigationView::$actionAddEvent."' method='post'>

                         <div class='formGroup, hidden'>
                             <input placeholder='Ex. 18.00' type='text' value='$day'
                             name=$this->dayInput>
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
        if(isset($_POST[$this->startTimeInput])){
            return $_POST[$this->startTimeInput];
        }
        return false;
    }

    public function getMonth(){
        return $this->month;
    }
}