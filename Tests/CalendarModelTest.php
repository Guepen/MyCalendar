<?php
/**
 * Created by PhpStorm.
 * User: Tobias
 * Date: 2014-10-09
 * Time: 23:07
 */

namespace Tests;


use model\CalendarModel;

class CalendarModelTest extends \PHPUnit_Framework_TestCase {

    /**
     * @expectedException \model\EmptyTitleException
     */
    public function testEmptyTitleException(){
        $calendarModel = new CalendarModel();
        $calendarModel->validateInput("","02","20","15.30","16.30","description");
    }

    /**
     * @expectedException \model\EmptyDescriptionException
     */
    public function testEmptyDescriptionException(){
        $calendarModel = new CalendarModel();
        $calendarModel->validateInput("title","02","20","15.30","16.30","");
    }

    /**
     * @expectedException \model\WrongMonthFormatException
     */
    public function testSetMonthWithAZero(){
        $calendarModel = new CalendarModel();
        $calendarModel->validateInput("title","0","20","15.30","16.30","description");
    }

    /**
     * @expectedException \model\WrongMonthFormatException
     */
    public function testSetMonthToNoneExisting(){
        $calendarModel = new CalendarModel();
        $calendarModel->validateInput("title","13","20","15.30","16.30","description");
    }


    /**
     * @expectedException \model\WrongMonthFormatException
     */
    public function testSetMonthWithThreeDigits(){
        $calendarModel = new CalendarModel();
        $calendarModel->validateInput("title","022","20","15.30","16.30","description");
    }


    /**
     * @expectedException \model\WrongMonthFormatException
     */
    public function testSetMonthWithCharacter(){
        $calendarModel = new CalendarModel();
        $calendarModel->validateInput("title","m","20","15.30","16.30","description");
    }

    /**
     * @expectedException \model\WrongDayFormatException
     */
    public function testSetDayWithNothing(){
        $calendarModel = new CalendarModel();
        $calendarModel->validateInput("title","2","","15.30","16.30","description");
    }

    /**
     * @expectedException \model\WrongDayFormatException
     */
    public function testSetDayWithAZero(){
        $calendarModel = new CalendarModel();
        $calendarModel->validateInput("title","2","0","15.30","16.30","description");
    }

    /**
     * @expectedException \model\WrongDayFormatException
     */
    public function testSetDayWithAStartingZero(){
        $calendarModel = new CalendarModel();
        $calendarModel->validateInput("title","2","01","15.30","16.30","description");
    }

    /**
     * @expectedException \model\WrongDayFormatException
     */
    public function testSetDayWithNoneExisting(){
        $calendarModel = new CalendarModel();
        $calendarModel->validateInput("title","2","39","15.30","16.30","description");
    }

    /**
     * @expectedException \model\WrongDayFormatException
     */
    public function testSetDayWithThreeDigits(){
        $calendarModel = new CalendarModel();
        $calendarModel->validateInput("title","2","123","15.30","16.30","description");
    }

    /**
     * @expectedException \model\WrongDayFormatException
     */
    public function testSetDayWithCharacter(){
        $calendarModel = new CalendarModel();
        $calendarModel->validateInput("title","2","dd","15.30","16.30","description");
    }

    /**
 * @expectedException \model\WrongTimeFormatException
 */
    public function testSetStartTimeWithNothing(){
        $calendarModel = new CalendarModel();
        $calendarModel->validateInput("title","2","10","","16.30","description");
    }

    /**
     * @expectedException \model\WrongTimeFormatException
     */
    public function testSetStartTimeWithTwoDigits(){
        $calendarModel = new CalendarModel();
        $calendarModel->validateInput("title","2","10","15","16.30","description");
    }

    /**
     * @expectedException \model\WrongTimeFormatException
     */
    public function testSetStartTimeWithFourDigits(){
        $calendarModel = new CalendarModel();
        $calendarModel->validateInput("title","2","10","1500","16.30","description");
    }

    /**
     * @expectedException \model\WrongTimeFormatException
     */
    public function testSetStartTimeWithToManyDigits(){
        $calendarModel = new CalendarModel();
        $calendarModel->validateInput("title","2","10","06.000","16.30","description");
    }

    /**
     * @expectedException \model\WrongTimeFormatException
     */
    public function testSetStartTimeWithMissingDigits(){
        $calendarModel = new CalendarModel();
        $calendarModel->validateInput("title","2","10",".00","16.30","description");
    }

    /**
     * @expectedException \model\WrongTimeFormatException
     */
    public function testSetStartTimeWithMissingDigits2(){
        $calendarModel = new CalendarModel();
        $calendarModel->validateInput("title","2","10","1.0","16.30","description");
    }

    /**
     * @expectedException \model\WrongTimeFormatException
     */
    public function testSetStartTimeWithMissingDigit(){
        $calendarModel = new CalendarModel();
        $calendarModel->validateInput("title","2","10","1.00","16.30","description");
    }

    /**
     * @expectedException \model\WrongTimeFormatException
     */
    public function testSetEndTimeWithNothing(){
        $calendarModel = new CalendarModel();
        $calendarModel->validateInput("title","2","10","16.30","","description");
    }

    /**
     * @expectedException \model\WrongTimeFormatException
     */
    public function testSetEndTimeWithTwoDigits(){
        $calendarModel = new CalendarModel();
        $calendarModel->validateInput("title","2","10","15.30","16","description");
    }

    /**
     * @expectedException \model\WrongTimeFormatException
     */
    public function testSetEndTimeWithFourDigits(){
        $calendarModel = new CalendarModel();
        $calendarModel->validateInput("title","2","10","15.00","1630","description");
    }

    /**
     * @expectedException \model\WrongTimeFormatException
     */
    public function testSetEndTimeWithToManyDigits(){
        $calendarModel = new CalendarModel();
        $calendarModel->validateInput("title","2","10","06.00","16.300","description");
    }

    /**
     * @expectedException \model\WrongTimeFormatException
     */
    public function testSetEndTimeWithMissingDigits(){
        $calendarModel = new CalendarModel();
        $calendarModel->validateInput("title","2","10","01.00",".30","description");
    }

    /**
     * @expectedException \model\WrongTimeFormatException
     */
    public function testSetEndTimeWithMissingDigits2(){
        $calendarModel = new CalendarModel();
        $calendarModel->validateInput("title","2","10","10.00","1.3","description");
    }

    /**
     * @expectedException \model\WrongTimeFormatException
     */
    public function testSetEndTimeWithMissingDigit(){
        $calendarModel = new CalendarModel();
        $calendarModel->validateInput("title","2","10","10.00","1.30","description");
    }


    public function testSetEventWithOkValues(){
        $calendarModel = new CalendarModel();
        $this->assertTrue($calendarModel->validateInput("title","2","10","10.00","16.30","description"));
    }

    public function testSetEventWithOkValues2(){
        $calendarModel = new CalendarModel();
        $this->assertTrue($calendarModel->validateInput("title","12","10","10.00","16.30","description"));
    }

    public function testSetEventWithOkValues3(){
        $calendarModel = new CalendarModel();
        $this->assertTrue($calendarModel->validateInput("title","2","1","10.00","16.30","description"));
    }

    public function testSetEventWithOkValues4(){
        $calendarModel = new CalendarModel();
        $this->assertTrue($calendarModel->validateInput("title","2","10","01.00","23.30","description"));
    }




}
 