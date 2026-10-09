<?php

require_once(__DIR__."/../Model.php");

class LoginModel extends Model
{
   

    public function getUser(string $email){

        $stmt = null;
        try{
            $query = "SELECT * FROM user WHERE email = ?;";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("s", $email);
            $stmt->execute();

            $result = $stmt->get_result()->fetch_assoc();

            return $result;
        }
        catch(mysqli_sql_exception $e){
            error_log("getUser Error: ". $e->getMessage());
            return false;
        }
        finally {
            if ($stmt instanceof mysqli_stmt) {
                $stmt->close();
            } 
        }
    }

    public function getUserFromRequest(string $email){

        $stmt = null;
        try{
            $query = "SELECT * FROM request WHERE email = ?;";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("s", $email);
            $stmt->execute();

            $result = $stmt->get_result()->fetch_assoc();
            return $result;
        }
        catch(mysqli_sql_exception $e){
            error_log("getUser Error: ". $e->getMessage());
            return false;
        }
        finally {
            if ($stmt instanceof mysqli_stmt) {
                $stmt->close();
            } 
        }
    }
}