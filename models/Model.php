<?php

require_once(__DIR__."/../config/Db.php");

class Model
{
    protected $conn;

    public function __construct()
    {
        $this->conn = (new Db())->getConnection();
    }
    
    public function verifyDbConnection()
    {
        if($this->conn === null){
            return false;
        }
        else{
            return true;
        }
    }
}