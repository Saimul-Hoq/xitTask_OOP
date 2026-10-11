<?php

require_once(__DIR__."/../Controller.php");
require_once(__DIR__."/../../models/admin/AdminRequestsModel.php");

class AdminRequestsControllerPOST extends Controller
{
    private string $userId;
    private string $adminId;
    private string $action;
    private array $errors;
    private $model;

    public function __construct(array $data)
    {
        $this->adminId = $_SESSION["id"] ?? "";
        $this->userId = $data["id"];
        $this->action = $data["action"];
        $this->errors = [];
        $this->model = new AdminRequestsModel();
    }

    public function index()
    {
        $this->requireAdmin();

        if(!$this->model->verifyDbConnection())
        {
            $this->dbFail();
        }


        if($this->action === "accept"){

            $this->acceptRequest();
        }
        else{

            $this->rejectRequest();
        }


        $this->success();
    }

    private function acceptRequest()
    {
        if($this->model->approveRequest($this->userId, $this->adminId) === false){
            $this->dbFail();
        }

        return true;
    }

    private function rejectRequest()
    {
        if($this->model->deleteRequest($this->userId) === false){
            $this->dbFail();
        }

        return true;
    }

    private function success()
    {
          
        if($this->action === "accept"){
            $this->flash(["status" => "success", "msg" => "Request accepted successfully"]);
        }
        else if($this->action === "reject"){
            $this->flash(["status" => "success", "msg" => "Request rejected successfully"]);
        }
        $this->redirect("/projects/xitTask_OOP/admin/requests");
        exit();
    }

}