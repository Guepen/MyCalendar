<?php
/**
 * Created by PhpStorm.
 * User: Tobias
 * Date: 2014-10-10
 * Time: 10:30
 */

namespace model;


class EventRepository extends Repository {
    private static $userId = 'userId';
    private static $title = 'title';
    private static $month = 'month';
    private static $day = 'day';
    private static $startTime = 'startTime';
    private static $endTime = 'endTime';
    private static $description = 'description';

    private $db;
    private $eventList;

    public function __construct(){
        $this->dbTable = "event";
        $this->db = $this->connection();
        $this->eventList = array();
    }

    public function add(Event $event, $userId){
        try{

            $sql = "INSERT INTO $this->dbTable (" . self::$userId . ", " . self::$title .", ".
                                                    self::$month . ", ".self::$day .", ".
                                                    self::$startTime .", ".  self::$endTime. ", ".
                                                    self::$description .") VALUES (?,?,?,?,?,?,?)";
            $params = array($userId, $event->getTitle(), $event->getMonth(), $event->getDay(),
                                     $event->getStartTime(), $event->getEndTime(), $event->getDescription());

            $query = $this->db->prepare($sql);
            $query->execute($params);

        }catch (\PDOException $e){
            var_dump($e->getMessage());
            throw new DbException();
        }
    }

    public function getEvents($userId){
        try {
            //var_dump($userId);

            $sql = "SELECT * FROM ". $this->dbTable." WHERE " . self::$userId . " =?";
            $params = array($userId);

            $query = $this->db->prepare($sql);
            $query->execute($params);

            foreach($result = $query->fetchAll() as $event ){
                $title  = $event[self::$title];
                $month = $event[self::$month];
                $day = $event[self::$day];
                $startTime = $event[self::$startTime];
                $endTime = $event[self::$endTime];
                $description = $event[self::$description];

                $this->eventList[] = new Event($title, $month, $day, $startTime, $endTime, $description);
            }

            return $this->eventList;

        } catch (\PDOException $e) {
            die("Ett oväntat fel inträffade");
        }
    }
} 