<?php

require_once(__DIR__."/../Controller.php");
require_once(__DIR__."/../../models/user/UserProfileModel.php");

class UserProfileControllerGET extends Controller
{
    private array $data;
    private $model;

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->model = new UserProfileModel();
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
        $this->view("userProfile.php", ["errors" => [], "user" => $user]);
        exit();
    }
}