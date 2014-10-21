<?php
/**
 * Created by PhpStorm.
 * User: Tobias
 * Date: 2014-10-21
 * Time: 09:02
 */

namespace View;


class DateHelper {
    private $month;
    private $year;
    private $htmlMonth;
    private $action;

    public function setAction($action){
        $this->action = $action;
    }

    private function setMonth(){
        if(isset($_GET[NavigationView::$actionMonthToShow])){
            $this->month = $_GET[NavigationView::$actionMonthToShow];
        } else{
            $this->month = date("n");
        }
        $this->htmlMonth = strftime("%B",mktime(0,0,0,$this->month));
        $this->htmlMonth = ucfirst($this->htmlMonth);
    }

    private function setYear(){
        if(isset($_GET[NavigationView::$actionYearToShow])){
            $this->year = $_GET[NavigationView::$actionYearToShow];
        } else{
            $this->year = date("Y");
        }
    }

    public function getMonthToShow(){
        if(isset($_GET[NavigationView::$actionMonthToShow])){
            return $_GET[NavigationView::$actionMonthToShow];
        }
        return date("n");
    }

    public function getYearToShow(){
        if(isset($_GET[NavigationView::$actionYearToShow])){
            return $_GET[NavigationView::$actionYearToShow];
        }
        return date("Y");
    }

    public function getMonthInText(){
       $this->setMonth();
        return $this->htmlMonth;
    }

    private function getNextMonth(){
        if ($this->month < 12) {
            return $this->month + 1;
        } else {
            return 1;
        }
    }

    private function getPreviousMonth(){
        if($this->month > 1){
            return $this->month - 1;
        } else{
            return 12;
        }
    }

    private function getNextYear(){
        if ($this->month == 12) {
            return $this->year + 1;
        }
        return $this->year;
    }

    private function getPreviousYear(){
        if($this->month == 1){
            return $this->year - 1;
        }
        return $this->year;
    }

    public function getMonthNavigation(){
        $this->setMonth();
        $this->setYear();
        $ret = ' <div id="monthNav">
                <a class="left orange" href="?action='.$this->action."&".
            NavigationView::$actionMonthToShow."=".$this->getPreviousMonth()."&".
            NavigationView::$actionYearToShow."=".$this->getPreviousYear().
            '"><--Föregående månad</a>

             <a class="center orange" href="?action='.$this->action.'&'.
            NavigationView::$actionMonthToShow.'='.date("n").'&'.NavigationView::$actionYearToShow.'='.date("Y").'">
        Nuvarande månad</a>

              <a class="right orange" href="?action='.$this->action.'&'.
            NavigationView::$actionMonthToShow."=".$this->getNextMonth()."&".
            NavigationView::$actionYearToShow."=".$this->getNextYear().'">Nästa månad--></a>

            </div>';

        return $ret;
    }

} 