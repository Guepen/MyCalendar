<?php
/**
 * Created by PhpStorm.
 * User: Tobias
 * Date: 2014-10-23
 * Time: 15:02
 */

namespace Tests;


use Model\EventModel;

class EventModelTest extends \PHPUnit_Framework_TestCase {
    #region Validate text input
    /**
     * @expectedException \model\EmptyTitleException
     */
    public function testEmptyTitleException(){
        $eventModel = new EventModel();
        $eventModel->validateTextInput("","description");
    }

    /**
     * @expectedException \model\TitleToLongException
     */
    public function testTitleToLongException(){
        $eventModel = new EventModel();
        $eventModel->validateTextInput("hhhhhhhhhhhhhhhhhhhhhhhhh","description");
    }


    /**
     * @expectedException \model\EmptyDescriptionException
     */
    public function testEmptyDescriptionException(){
        $eventModel = new EventModel();
        $eventModel->validateTextInput("title","");
    }

    public function testValidateOkTextInputValues(){
        $eventModel = new EventModel();
        $this->assertTrue($eventModel->validateTextInput("title","description"));
    }

    #endregion

    #region Validate date input

    /**
     * @expectedException \model\MonthNotSelectedException
     */
    public function testSetMonthWitNotSelectedMonthValue(){
        $EventModel = new EventModel();
        $EventModel->validateDateInput("2014", "2014", "Ange Månad", "12", "25", "23");
    }

    /**
     * @expectedException \model\WrongDayFormatException
     */
    public function testSetDateWitNotSelectedDateValue(){
        $EventModel = new EventModel();
        $EventModel->validateDateInput("2014", "2014", "12", "12", "Ange Datum", "23");
    }

    /**
     * @expectedException \model\DateHasAlredayBeenException
     */
    public function testSetDateHasAlredayBeenExceptionWithOldMonth(){
        $EventModel = new EventModel();
        $EventModel->validateDateInput("2014", "2014", "9", "10", "25", "23");
    }

    /**
     * @expectedException \model\DateHasAlredayBeenException
     */
    public function testSetDateHasAlredayBeenExceptionWithOldDate(){
        $EventModel = new EventModel();
        $EventModel->validateDateInput("2014", "2014", "10", "10", "5", "23");
    }

    public function testValidateOkDateInputValues(){
        $eventModel = new EventModel();
        $this->assertTrue($eventModel->validateDateInput("2014", "2014", "10", "10", "30", "30"));
    }
    #endregion

    #region Validate time input
    /**
     * @expectedException \model\StartHourNotSelectedException
     */
    public function testSetStartHourWitNotSelectedValue(){
        $EventModel = new EventModel();
        $EventModel->validateTimeInput("Ange Starttid", "00", "01", "00");
    }

    /**
     * @expectedException \model\StartMinuteNotSelectedException
     */
    public function testSetStartMinuteWitNotSelectedValue(){
        $EventModel = new EventModel();
        $EventModel->validateTimeInput("00", "Ange Startminut", "01", "00");
    }

    /**
     * @expectedException \model\EndHourNotSelectedException
     */
    public function testSetEndHourWitNotSelectedValue(){
        $EventModel = new EventModel();
        $EventModel->validateTimeInput("00", "00", "Ange Sluttimme", "00");
    }

    /**
     * @expectedException \model\EndMinuteNotSelectedException
     */
    public function testSetEndMinuteWitNotSelectedValue(){
        $EventModel = new EventModel();
        $EventModel->validateTimeInput("00", "00", "01", "Ange Slutminut");
    }

    public function testValidateOKTimeInput(){
        $EventModel = new EventModel();
        $this->assertTrue($EventModel->validateTimeInput("00", "00", "01", "01"));
    }
    #endregion

}
 