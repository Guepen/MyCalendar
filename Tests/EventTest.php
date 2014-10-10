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
        $event = new Event("title","10","25","10.00","12.00","description");
        $this->assertEquals("title", $event->getTitle());
    }

    public function testGetMonth(){
        $event = new Event("title","10","25","10.00","12.00","description");
        $this->assertEquals("10", $event->getMonth());
    }

    public function testGetDay(){
        $event = new Event("title","10","25","10.00","12.00","description");
        $this->assertEquals("25", $event->getDay());
    }

    public function testGetStartTime(){
        $event = new Event("title","10","25","10.00","12.00","description");
        $this->assertEquals("10.00", $event->getStartTime());
    }

    public function testGetEndTime(){
        $event = new Event("title","10","25","10.00","12.00","description");
        $this->assertEquals("12.00", $event->getEndTime());
    }

    public function testGetDescription(){
        $event = new Event("title","10","25","10.00","12.00","description");
        $this->assertEquals("description", $event->getDescription());
    }

}
 