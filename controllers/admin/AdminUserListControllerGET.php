<?php

require_once(__DIR__."/../Controller.php");
require_once(__DIR__."/../../models/admin/AdminUserListModel.php");

class AdminUserListControllerGET extends Controller
{
    private string $id;
    private array $data;
    private array $user;
    private array $users;
    private $model;

    public function __construct(array $data)
    {
        $this->id = $_SESSION["id"]??"";
        $this->data = $data;
        $this->model = new AdminUserListModel();
    }

    public function index()
    {
        $this->requireAdmin();

        if(!$this->model->verifyDbConnection()){
            $this->fail();
        }

        $this->showUser();

        $this->success();
    }

    private function showUser()
    {
        $user  = $this->model->getUser($this->id);
        $users = $this->model->getAllUsers();

        if (!is_array($user) || !is_array($users)) {
            $this->fail();
        }

        $this->user  = $user;
        $this->users = $users;
    }
    private function success()
    {
        $this->view("adminUserList.php", ["errors" => [], "user" => $this->user, "users" => $this->users]);
        exit();
    }

    private function fail(bool $db = false)
    {
        $this->redirect("/projects/xitTask_OOP/");
        exit();
    }
}