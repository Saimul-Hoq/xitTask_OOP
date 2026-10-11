<?php 

require_once(__DIR__."/../Controller.php");
require_once(__DIR__."/../../models/admin/AdminEditPasswordModel.php");

class AdminEditPasswordControllerGET extends Controller
{
    private string $id;
    private array $data;
    private array $user;
    private $model;

    public function __construct(array $data)
    {
        $this->id = $_SESSION["id"] ?? "";
        $this->data = $data;
        $this->model = new AdminEditPasswordModel();
    }

    public function index()
    {
        $this->requireAdmin();

        if(!$this->model->verifyDbConnection()){
            $this->fail();
        }

        $this->getUser();

        $this->success();
    }

    private function getUser()
    {
        $user = $this->model->getUser($this->id);
        
        if(!is_array($user)){
            $this->fail();
        }

        $this->user = $user;
    }

    private function success()
    {
        $this->view("adminEditPassword.php", ["errors" => [], "user" => $this->user??[]]);
        exit();
    }

    private function fail()
    {
        $this->redirect("/projects/xitTask_OOP/");
        exit();
    }
}