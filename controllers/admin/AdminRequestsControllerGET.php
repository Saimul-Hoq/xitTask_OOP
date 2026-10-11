<?php

require_once(__DIR__."/../Controller.php");
require_once(__DIR__."/../../models/admin/AdminRequestsModel.php");

class AdminRequestsControllerGET extends Controller
{
    private string $id;
    private array $data;
    private array $user;
    private array $requests;
    private $model;

    public function __construct(array $data)
    {
        $this->id = $_SESSION["id"]??"";
        $this->data = $data;
        $this->model = new AdminRequestsModel();
    }

    public function index()
    {
        $this->requireAdmin();

        if(!$this->model->verifyDbConnection()){
            $this->fail();
        }

       $this->showRequests();

        $this->success();
    }

    private function showRequests()
    {
        $user = $this->model->getUser($this->id);
        $requests = $this->model->getAllRequests();

        if(!is_array($user) || !is_array($requests)){
            $this->fail();
        }

        $this->user = $user;
        $this->requests = $requests;
    }

   
    private function success()
    {
        $this->view("adminRequests.php", ["errors" => [], "user" => $this->user, "requests" => $this->requests]);
        exit();
    }

    private function fail(bool $db = false)
    {
        $this->redirect("/projects/xitTask_OOP/");
        exit();
    }
}