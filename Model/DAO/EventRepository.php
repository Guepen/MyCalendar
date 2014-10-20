<?php
/**
 * Created by PhpStorm.
 * User: Tobias
 * Date: 2014-10-10
 * Time: 10:30
 */

namespace model;


class EventRepository extends Repository {
    //columns in the db
    private static $userId = 'userId';
    private static $eventId = 'eventId';
    private static $title = 'title';
    private static $year = 'year';
    private static $month = 'month';
    private static $day = 'day';
    private static $startHour = 'startHour';
    private static $startMinute = 'startMinute';
    private static $endHour = 'endHour';
    private static $endMinute = 'endMinute';
    private static $description = 'description';

    private $db;
    private $eventList;

    public function __construct(){
        $this->dbTable = "event";
        $this->db = $this->connection();
        $this->eventList = array();
    }

    /**
     * tries to add an event belonging the user
     * @param Event $event An EventObject
     * @param $userId string containing the users ID
     * @throws DbException if something goes wrong
     */
    public function add(Event $event, $userId){
        try{

            $sql = "INSERT INTO ". $this->dbTable." (" . self::$userId . ", " . self::$title .", ".
                                                    self::$month . ", ".self::$year.",".self::$day .", ".
                                                    self::$startHour .", ". self::$startMinute .", ".
                                                    self::$endHour. ", ". self::$endMinute .", ".
                                                    self::$description .") VALUES (?,?,?,?,?,?,?,?,?,?)";
            $params = array($userId, $event->getTitle(), $event->getMonth(),$event->getYear(), $event->getDay(),
                                     $event->getStartHour(), $event->getStartMinute(),
                                     $event->getEndHour(), $event->getEndMinute(), $event->getDescription());

            $query = $this->db->prepare($sql);
            $query->execute($params);

        } catch (\PDOException $e){
            throw new DbException();
        }
    }

    /**
     * tries to update an event
     * @param Event $event the event to be updated
     * @throws \model\DbException if something goes wrong
     */
    public function Update(Event $event){
        try{

            $sql = "UPDATE ". $this->dbTable." SET ".
                    self::$day. "=?". ",". self::$description. "=?". ",".
                    self::$title. "=?". ",". self::$startHour. "=?". ",".
                    self::$startMinute. "=?". ",". self::$endHour. "=?".
                    ",". self::$endMinute. "=?". ",". self::$month. "=?".
                    ",". self::$year. "=?".
                    " WHERE ". self::$eventId. "=?";

            $params = array($event->getDay(), $event->getDescription(), $event->getTitle(),
                $event->getStartHour(), $event->getStartMinute(),
                $event->getEndHour(), $event->getEndMinute(), $event->getMonth(), $event->getYear(), $event->getEventId());

            $query = $this->db->prepare($sql);
            $query->execute($params);

        }catch (\PDOException $e){
            throw new DbException();
        }
    }

    /**
     * tries to get all the users events
     * @param $userId string containing the users ID
     * @throws DbException if something goes wrong
     * @return Array with all events
     */
    public function getEvents($userId){
        try {

            $sql = "SELECT * FROM ". $this->dbTable." WHERE " . self::$userId . " =?";
            $params = array($userId);

            $query = $this->db->prepare($sql);
            $query->execute($params);

            foreach($result = $query->fetchAll() as $event ){
                $title  = $event[self::$title];
                $month = $event[self::$month];
                $year = $event[self::$year];
                $day = $event[self::$day];
                $startHour = $event[self::$startHour];
                $startMinute = $event[self::$startMinute];
                $endHour = $event[self::$endHour];
                $endMinute = $event[self::$endMinute];
                $description = $event[self::$description];
                $eventId = $event[self::$eventId];

                $this->eventList[] = new Event($title, $month, $year, $day, $startHour, $startMinute,
                                               $endHour, $endMinute, $description, $eventId);
            }

        } catch (\PDOException $e) {
            throw new DbException();
        }
        return $this->eventList;
    }

    /**
     * @param $eventTitle string
     * @param $userId string
     * @throws DbException if something goes wrong
     */
    public function deleteEvent($eventTitle, $userId){
        try {
            $sql = "DELETE FROM " . $this->dbTable . " WHERE " . self::$title . " =? AND ".self::$userId. "=?";
            $params = array($eventTitle, $userId);

            $query = $this->db->prepare($sql);
            $query->execute($params);

        } catch (\PDOException $e) {
            throw new DbException();
        }
    }
} 