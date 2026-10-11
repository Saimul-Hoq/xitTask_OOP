<?php

require_once(__DIR__."/../Model.php");

class AdminRequestsModel extends Model
{
    public function approveRequest(string $id, string $approvedBy)
    {
        $stmt1 = null;
        $stmt2 = null;
        $stmt3 = null;
        try{
            $this->conn->begin_transaction();

            // 1. Get the request (locked, so it can't be approved twice at once)
            $stmt1 = $this->conn->prepare("SELECT * FROM request WHERE id = ? FOR UPDATE;");
            $stmt1->bind_param("s", $id);
            $stmt1->execute();
            $request = $stmt1->get_result()->fetch_assoc();

            if (!$request) {
                $this->conn->rollback();
                return null;
            }

            // 2. Insert into user table with approvedBy
            $query = "INSERT INTO user (id, email, password, name, mobile, address, avatar, role, approvedBy) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
            $stmt2 = $this->conn->prepare($query);
            $stmt2->bind_param(
                "sssssssis",
                $id,
                $request["email"],
                $request["password"],
                $request["name"],
                $request["mobile"],
                $request["address"],
                $request["avatar"],
                $request["role"],
                $approvedBy
            );
            $stmt2->execute();

            // 3. Delete the request
            $stmt3 = $this->conn->prepare("DELETE FROM request WHERE id = ?;");
            $stmt3->bind_param("s", $id);
            $stmt3->execute();

            $this->conn->commit();
            return true;
        }
        catch(mysqli_sql_exception $e){
            $this->conn->rollback();
            error_log("approveRequest Error: ". $e->getMessage());
            return false;
        }
        finally{
            if ($stmt1 instanceof mysqli_stmt) {
                $stmt1->close();
            }
            if ($stmt2 instanceof mysqli_stmt) {
                $stmt2->close();
            }
            if ($stmt3 instanceof mysqli_stmt) {
                $stmt3->close();
            }
        }
    }

    public function deleteRequest(string $id)
    {
        $stmt = null;
        try{
            $stmt = $this->conn->prepare("DELETE FROM request WHERE id = ?;");
            $stmt->bind_param("s", $id);
            $stmt->execute();

            return true;
        }
        catch(mysqli_sql_exception $e){
            error_log("deleteRequest Error: ". $e->getMessage());
            return false;
        }
        finally{
            if ($stmt instanceof mysqli_stmt) {
                $stmt->close();
            }
        }
    }

    public function getAllRequests()
    {
        $stmt = null;
        try{
            $query = "SELECT * FROM request ORDER BY registerDate ASC;";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }
        catch(mysqli_sql_exception $e){
            error_log("getAllRequests Error: ". $e->getMessage());
            return false;
        }
        finally{
            if ($stmt instanceof mysqli_stmt) {
                $stmt->close();
            }
        }
    }

}