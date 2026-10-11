<?php

require_once(__DIR__."/../Controller.php");
require_once(__DIR__."/../../models/admin/AdminRequestsModel.php");

class AdminRequestsControllerGET extends Controller
{
    private string $id;
    private array $data;
    private array $user;
    private array $requests;
    private string $status;
    private string $msg;
    private $model;

    public function __construct(array $data)
    {
        $this->id = $_SESSION["id"]??"";
        $this->data = $data;
        $this->status = $data["flash"]["status"] ?? "failed";
        $this->msg = $data["flash"]["msg"] ?? "";
        $this->model = new AdminRequestsModel();
    }

    public function index()
    {
        $this->requireAdmin();

        if(!$this->model->verifyDbConnection()){
            $this->dbFail();
        }

       $this->showRequests();

        $this->success();
    }

    private function showRequests()
    {
        
        $requests = $this->model->getAllRequests();

        if(!is_array($requests)){
            $this->dbFail();
        }

        $this->user = $this->getCurrentUser($this->id, $this->model);
        $this->requests = $requests;
    }

   
    private function success()
    {
        $this->view("adminRequests.php", ["errors" => [], "user" => $this->user, "requests" => $this->requests, "status" => $this->status, "msg" => $this->msg]);
        exit();
    }

   
}