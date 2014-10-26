<?php
/**
 * Created by PhpStorm.
 * User: Tobias
 * Date: 2014-10-10
 * Time: 20:55
 */

namespace Tests;
use Model\Event;

require_once("./ImportFiles.php");


class EventTest extends \PHPUnit_Framework_TestCase {

    public function testGetTitle(){
        $event = new Event("title","","","","","","","","","");
        $this->assertEquals("title", $event->getTitle());
    }

    public function testGetMonth(){
        $event = new Event("","10","","","","","","","","");
        $this->assertEquals("10", $event->getMonth());
    }

    public function testGetYear(){
        $event = new Event("","","2014","","","","","","","");
        $this->assertEquals("2014", $event->getYear());
    }

    public function testGetDay(){
        $event = new Event("","","","1","","","","","","","");
        $this->assertEquals("1", $event->getDay());
    }

    public function testGetStartHour(){
        $event = new Event("","","","","12","","","","","");
        $this->assertEquals("12", $event->getStartHour());
    }

    public function testGetStartMinute(){
        $event = new Event("","","","","","01","","","","");
        $this->assertEquals("01", $event->getStartMinute());
    }

    public function testGetEndHour(){
        $event = new Event("","","","","","","23","","","");
        $this->assertEquals("23", $event->getEndHour());
    }

    public function testGetEndMinute(){
        $event = new Event("","","","","","","","01","","");
        $this->assertEquals("01", $event->getEndMinute());
    }

    public function testGetDescription(){
        $event = new Event("","","","","","","","","description","");
        $this->assertEquals("description", $event->getDescription());
    }

    public function testGetEventId(){
        $event = new Event("","","","","","","","","","1");
        $this->assertEquals("1", $event->getEventId());
    }

}
 