<?php

require_once(__DIR__."/../Controller.php");
require_once(__DIR__."/../../models/admin/AdminUserListModel.php");

class AdminUserListControllerGET extends Controller
{
    private string $id;
    private array $data;
    private array $user;
    private array $users;
    private string $status;
    private string $msg;
    private $model;

    public function __construct(array $data)
    {
        $this->id = $_SESSION["id"]??"";
        $this->data = $data;
        $this->status = $data["flash"]["status"] ?? "failed";
        $this->msg = $data["flash"]["msg"] ?? "";
        $this->model = new AdminUserListModel();
    }

    public function index()
    {
        $this->requireAdmin();

        if(!$this->model->verifyDbConnection()){
            $this->dbFail();
        }

        $this->showUser();

        $this->success();
    }

    private function showUser()
    {
        
        $users = $this->model->getAllUsers();

        if (!is_array($users)) {
            $this->dbFail();
        }

        $this->user  = $this->getCurrentUser($this->id, $this->model);
        $this->users = $users;
    }
    private function success()
    {
        $this->view("adminUserList.php", ["errors" => [], "user" => $this->user, "users" => $this->users, "status" => $this->status, "msg" => $this->msg]);
        exit();
    }

   
}