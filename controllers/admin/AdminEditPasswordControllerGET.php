<?php 

require_once(__DIR__."/../Controller.php");
require_once(__DIR__."/../../models/admin/AdminEditPasswordModel.php");

class AdminEditPasswordControllerGET extends Controller
{
    private string $id;
    private array $data;
    private array $user;
    private string $status;
    private string $msg;
    private $model;

    public function __construct(array $data)
    {
        $this->id = $_SESSION["id"] ?? "";
        $this->data = $data;
        $this->status = $data["flash"]["status"] ?? "failed";
        $this->msg = $data["flash"]["msg"] ?? "";
        $this->model = new AdminEditPasswordModel();
    }

    public function index()
    {
        $this->requireAdmin();

        if(!$this->model->verifyDbConnection()){
            $this->dbFail();
        }

        $this->getUser();

        $this->success();
    }

    private function getUser()
    {
        $this->user = $this->getCurrentUser($this->id, $this->model);
    }

    private function success()
    {
        $this->view("adminEditPassword.php", ["errors" => [], "user" => $this->user??[], "status" => $this->status, "msg" => $this->msg]);
        exit();
    }

    
}