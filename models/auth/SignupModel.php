<?php


require_once(__DIR__."/../../config/Db.php");

class SignupModel
{
    private $conn;

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

    public function emailExists(string $email)
    {
        $stmt1 = null;
        $stmt2 = null;
        try{
            $stmt1 = $this->conn->prepare("SELECT email FROM user WHERE email = ?;");
            $stmt1->bind_param("s", $email);
            $stmt1->execute();
            $userResult = $stmt1->get_result()->fetch_assoc();

            $stmt2 = $this->conn->prepare("SELECT email FROM request WHERE email = ?;");
            $stmt2->bind_param("s", $email);
            $stmt2->execute();
            $requestResult = $stmt2->get_result()->fetch_assoc();

            if ($userResult || $requestResult) {
                return true;
            }
            return null;
        }
        catch(mysqli_sql_exception $e){
            error_log("emailExists Error: ". $e->getMessage());
            return false;
        }
        finally{
            if ($stmt1 instanceof mysqli_stmt) {
                $stmt1->close();
            } 
            if ($stmt2 instanceof mysqli_stmt) {
                $stmt2->close();
            } 
        }
    }


    public function mobileExists(string $mobile)
    {
        $stmt1 = null;
        $stmt2 = null;

        try{
            $stmt1 = $this->conn->prepare("SELECT mobile FROM user WHERE mobile = ?;");
            $stmt1->bind_param("s", $mobile);
            $stmt1->execute();
            $userResult = $stmt1->get_result()->fetch_assoc();

            $stmt2 = $this->conn->prepare("SELECT mobile FROM request WHERE mobile = ?;");
            $stmt2->bind_param("s", $mobile);
            $stmt2->execute();
            $requestResult = $stmt2->get_result()->fetch_assoc();

            if ($userResult || $requestResult) {
                return true;
            }
            return null;
        }
        catch(mysqli_sql_exception $e){
            error_log("mobileExists Error: ". $e->getMessage());
            return false;
        }
        finally{
            if ($stmt1 instanceof mysqli_stmt) {
                $stmt1->close();
            } 
            if ($stmt2 instanceof mysqli_stmt) {
                $stmt2->close();
            } 
        }

    }

    public function createSignupRequest(string $id, string $email, string $password, string $name, string $mobile, string $address, string $avatar, int $role)
    {
        $stmt = null;
        try{
            $query = "INSERT INTO request (id, email, password, name, mobile, address, avatar, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param(
                "sssssssi",
                $id,
                $email,
                $password,
                $name,
                $mobile,
                $address,
                $avatar,
                $role
            );
            $stmt->execute();
            return true;
        }
        catch(mysqli_sql_exception $e){
            error_log("createSignupRequest Error: ". $e->getMessage());
            return false;
        }
        finally{
            if ($stmt instanceof mysqli_stmt) {
                $stmt->close();
            } 
        }
    }
}