<?php

require_once(__DIR__."/../Model.php");

class UserEditProfileModel extends Model
{
    public function getUser(string $id)
    {
        $stmt = null;
        try{
            $query = "SELECT * FROM user WHERE id = ?;";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("s", $id);
            $stmt->execute();

            return $stmt->get_result()->fetch_assoc();
        }
        catch(mysqli_sql_exception $e){
            error_log("getUser Error: ". $e->getMessage());
            return false;
        }
        finally{
            if ($stmt instanceof mysqli_stmt) {
                $stmt->close();
            }
        }
    }

    public function updateUserAvatar(string $id, string $avatar)
    {
        $stmt = null;
        try{
            $query = "UPDATE user SET avatar = ? WHERE id = ?;";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ss", $avatar, $id);
            $stmt->execute();

            return true;
        }
        catch(mysqli_sql_exception $e){
            error_log("updateUserAvatar Error: ". $e->getMessage());
            return false;
        }
        finally{
            if ($stmt instanceof mysqli_stmt) {
                $stmt->close();
            }
        }
    }

    public function getAddress(string $id)
    {
        $stmt = null;
        try{
            $query = "SELECT address FROM user WHERE id = ?;";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("s", $id);
            $stmt->execute();

            $result = $stmt->get_result()->fetch_assoc();
            return $result ? $result["address"] : null;
        }
        catch(mysqli_sql_exception $e){
            error_log("getAddress Error: ". $e->getMessage());
            return false;
        }
        finally{
            if ($stmt instanceof mysqli_stmt) {
                $stmt->close();
            }
        }
    }

    public function editAddress(string $id, string $address)
    {
        $stmt = null;
        try{
            $query = "UPDATE user SET address = ? WHERE id = ?;";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ss", $address, $id);
            $stmt->execute();

            return true;
        }
        catch(mysqli_sql_exception $e){
            error_log("editAddress Error: ". $e->getMessage());
            return false;
        }
        finally{
            if ($stmt instanceof mysqli_stmt) {
                $stmt->close();
            }
        }
    }

    public function getUserMobile(string $id)
    {
        $stmt = null;
        try{
            $query = "SELECT mobile FROM user WHERE id = ?;";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("s", $id);
            $stmt->execute();

            $result = $stmt->get_result()->fetch_assoc();
            return $result ? $result["mobile"] : null;
        }
        catch(mysqli_sql_exception $e){
            error_log("getUserMobile Error: ". $e->getMessage());
            return false;
        }
        finally{
            if ($stmt instanceof mysqli_stmt) {
                $stmt->close();
            }
        }
    }

    public function isMobileExists(string $mobile, string $id)
    {
        $stmt = null;
        try{
            $query = "SELECT id FROM user WHERE mobile = ? AND id != ?;";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ss", $mobile, $id);
            $stmt->execute();

            $result = $stmt->get_result()->fetch_assoc();
            return $result ? true : null;
        }
        catch(mysqli_sql_exception $e){
            error_log("isMobileExists Error: ". $e->getMessage());
            return false;
        }
        finally{
            if ($stmt instanceof mysqli_stmt) {
                $stmt->close();
            }
        }
    }

    public function editMobile(string $id, string $mobile)
    {
        $stmt = null;
        try{
            $query = "UPDATE user SET mobile = ? WHERE id = ?;";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ss", $mobile, $id);
            $stmt->execute();

            return true;
        }
        catch(mysqli_sql_exception $e){
            error_log("editMobile Error: ". $e->getMessage());
            return false;
        }
        finally{
            if ($stmt instanceof mysqli_stmt) {
                $stmt->close();
            }
        }
    }

    public function updateUserName(string $id, string $name)
    {
        $stmt = null;
        try{
            $query = "UPDATE user SET name = ? WHERE id = ?;";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ss", $name, $id);
            $stmt->execute();

            return true;
        }
        catch(mysqli_sql_exception $e){
            error_log("updateUserName Error: ". $e->getMessage());
            return false;
        }
        finally{
            if ($stmt instanceof mysqli_stmt) {
                $stmt->close();
            }
        }
    }

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