<?php

namespace model;

use model\DbException;
use model\Repository;
use model\User;
use model\UserExistsException;

/**
 * Class UserRepository
 * @package model
 */
class UserRepository extends Repository{
    private static $username = 'username';
    private static $password = 'password';
    private static $userId = 'userId';
    private $db;

    public function __construct(){
        $this->dbTable = 'user';
        $this->db = $this->connection();
    }

    public function getUser($username){
        try {

            $sql = "SELECT * FROM $this->dbTable WHERE " . self::$username . " =?";
            $params = array($username);

            $query = $this->db->prepare($sql);
            $query->execute($params);

            $result = $query->fetch();

            if ($result) {
                /**
                 * username and password are columns in the db
                 */
                return new User($result[self::$username], $result[self::$password]);
            }

            return null;

        } catch (\PDOException $e) {
            throw new DbException();
        }
    }

    public function getUserId($username){
        try {

            $sql = "SELECT ".self::$userId." FROM ". $this->dbTable." WHERE " . self::$username . " =?";
            $params = array($username);

            $query = $this->db->prepare($sql);
            $query->execute($params);

            $result = $query->fetch();

            if($result){
                return $result[self::$userId];
            }

            return null;

        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
}
}

