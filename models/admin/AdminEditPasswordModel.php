<?php

require_once(__DIR__."/../Model.php");

class AdminEditPasswordModel extends Model
{
    public function getUserPassword(string $id)
    {
        $stmt = null;
        try{
            $query = "SELECT password FROM user WHERE id = ?;";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("s", $id);
            $stmt->execute();

            $result = $stmt->get_result()->fetch_assoc();
            return $result ? $result["password"] : null;
        }
        catch(mysqli_sql_exception $e){
            error_log("getUserPassword Error: ". $e->getMessage());
            return false;
        }
        finally{
            if ($stmt instanceof mysqli_stmt) {
                $stmt->close();
            }
        }
    }

    public function editUserPassword(string $id, string $hashedPassword)
    {
        $stmt = null;
        try{
            $query = "UPDATE user SET password = ? WHERE id = ?;";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ss", $hashedPassword, $id);
            $stmt->execute();

            return true;
        }
        catch(mysqli_sql_exception $e){
            error_log("editUserPassword Error: ". $e->getMessage());
            return false;
        }
        finally{
            if ($stmt instanceof mysqli_stmt) {
                $stmt->close();
            }
        }
    }
}