<?php

require_once(__DIR__."/../Controller.php");
require_once(__DIR__."/../../models/admin/AdminEditPasswordModel.php");

class AdminEditPasswordControllerPOST extends Controller
{
    private string $id;
    private string $currentPassword;
    private string $newPassword;
    private string $confirmPassword;
    private array $errors;
    private ?array $user;
    private $model;

    public function __construct(array $data)
    {
        $this->id = $_SESSION["id"] ?? "";
        $this->currentPassword = $data["currentPassword"];
        $this->newPassword = $data["newPassword"];
        $this->confirmPassword = $data["confirmPassword"];
        $this->errors = [];
        $this->model = new AdminEditPasswordModel();
        $this->user = null;
    }

    public function index()
    {
        $this->requireAdmin();

        if(!$this->model->verifyDbConnection()){
            $this->fail(true);
        }  
        
        $this->getUser();

        if($this->isEmpty()){
            $this->fail();
        }

        $this->validate();

        $this->updatePassword();

        $this->success();
    }

    private function updatePassword()
    {
        $hashedPssword = password_hash($this->newPassword, PASSWORD_DEFAULT);

        if($this->model->editUserPassword($this->id, $hashedPssword) === false){
            $this->fail(true);
        }

        return true;
    }

    private function validate()
    {
        if(strlen($this->newPassword) < 4){
            $this->errors["newPassword"] = "Password must be atleast 4 characters";
            $this->fail();
        }

        if($this->newPassword !== $this->confirmPassword){
            $this->errors["confirmPassword"] = "Password doesn't match";
            $this->fail();
        }

        $password = $this->model->getUserPassword($this->id);
        if($password === false){
            $this->fail(true);
        }
        if(!password_verify($this->currentPassword, $password)){
            $this->errors["currentPassword"] = "Current password is not correct";
            $this->fail();
        }
    }

    private function isEmpty()
    {
        $check = false;

        if (trim($this->currentPassword) === '') {
            $this->errors["currentPassword"] = "Current Password is required";
            $check = true;
        }

        if (trim($this->newPassword) === '') {
            $this->errors["newPassword"] = "New Password is required";
            $check = true;
        }

        if (trim($this->confirmPassword) === '') {
            $this->errors["confirmPassword"] = "Confirm Password is required";
            $check = true;
        }

        return $check;

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
        $this->redirect("/projects/xitTask_OOP/admin/editPassword");
        exit();
    }

    private function fail($db = false)
    {   
        if($db){
            $this->errors["db"] = "Database Connection Failed. Please try again later";
        }
        $this->view("adminEditPassword.php", ["errors" => $this->errors, "user" => $this->user??[]]);
        exit();
    }
}