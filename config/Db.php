<?php

class Db
{
    private $host = "localhost";
    private $dbName = "xit_task";
    private $dbUsername = "saim";
    private $dbPassword = "saim1234";
    private $conn;

    public function __construct()
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        try{
            $this->conn = new mysqli($this->host, $this->dbUsername, $this->dbPassword,$this->dbName);

            $this->conn->set_charset("utf8mb4");
        }
        catch(mysqli_sql_exception $e){
            error_log("DB connection failed: ".$e->getMessage());
            $this->conn = null;
        }
        
    }
    
    public function getConnection(){
        return $this->conn;
    }
}