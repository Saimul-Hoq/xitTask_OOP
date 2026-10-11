<?php

require_once(__DIR__."/../Controller.php");
require_once(__DIR__."/../../models/admin/AdminUserListModel.php");

class AdminUserListControllerPOST extends Controller
{
    private string $userId;
    private $model;
    private array $errors;

    public function __construct(array $data)
    {
        $this->userId = $data["userId"];
        $this->errors = [];
        $this->model = new AdminUserListModel();
    }

    public function index()
    {
        $this->requireAdmin();

        if(!$this->model->verifyDbConnection())
        {
            $this->dbFail();
        }

        $this->deleteUser();


        $this->success();
    }

    private function deleteUser()
    {
        if($this->model->deleteUser($this->userId) === false){
            $this->dbFail();
        }

        return true;
    }

    private function success()
    {
        $this->flash(["status" => "success", "msg" => "User has been deleted"]);
        $this->redirect("/projects/xitTask_OOP/admin/userList");
        exit();
    }

    
}