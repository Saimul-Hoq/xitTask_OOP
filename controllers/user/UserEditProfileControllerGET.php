<?php

require_once(__DIR__."/../Controller.php");
require_once(__DIR__."/../../models/user/UserEditProfileModel.php");

class UserEditProfileControllerGET extends Controller
{
    private array $data;
    private string $status;
    private string $msg;
    private $model;

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->status = $data["flash"]["status"] ?? "failed";
        $this->msg = $data["flash"]["msg"] ?? "";
        $this->model = new UserEditProfileModel();
    }

    public function getUser()
    {
        $user = $this->model->getUser($_SESSION["id"]);
        if($user === false || $user === null){
            $this->redirect("/projects/xitTask_OOP/logout");
            exit();
        }
        return $user;
    }

    public function index()
    {
        $this->requireLogin();
        $user = $this->getUser();
        $this->view("userEditProfile.php", ["errors" => [], "user" => $user, "status" => $this->status, "msg" => $this->msg]);
        exit();
    }
}