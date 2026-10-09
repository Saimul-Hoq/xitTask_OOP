<?php

require_once(__DIR__."/../Model.php");

class UserProfileModel extends Model
{
    public function getUser(string $id){

        $stmt = null;
        try{
            $query = "SELECT * FROM user WHERE id = ?;";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("s", $id);
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