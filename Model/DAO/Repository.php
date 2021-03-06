<?php

namespace model;

/**
 * Class Repository
 * @package model
 * This code is taken from https://github.com/dntoll/1dv408-HT14/blob/master/Portfolio/src/model/Repository.php
 */
abstract class Repository{
    protected  $dbConnection;
    protected  $dbTable;

    protected function connection(){
        if($this->dbConnection == null){
            //TODO do we have to create a new PDO instance multiple times??
            $this->dbConnection = new \PDO(\Settings::$dbConnectionString, \Settings::$dbUsername, \Settings::$dbPassword);

            $this->dbConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            return $this->dbConnection;
        }
        return null;
    }

}