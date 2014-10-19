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

    public function add(User $user){
        try{

            $sql = "INSERT INTO ". $this->dbTable." (" . self::$username . ", " . self::$password . ") VALUES (?,?)";
            $params = array($user->getUsername(), $user->getPassword());

            $query = $this->db->prepare($sql);
            $query->execute($params);

        }catch (\PDOException $e){
            /**
             * if a user already has wished username
             */
            if($e->getCode() === "23000"){
                var_dump("dfs");
                throw new UserExistsException();
            }
            else{
               throw new DbException();
            }
        }
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

        } catch (\PDOException $e) {
            throw new DbException();
        }
        return null;

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

