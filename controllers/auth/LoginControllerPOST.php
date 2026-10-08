<?php


require_once(__DIR__."/../Controller.php");
require_once(__DIR__."/../../models/auth/LoginModel.php");

class LoginControllerPOST extends Controller
{
    private string $email;
    private string $password;
    private array $errors;
    private array $old;
    private $model;
    

    public function __construct(array $data)
    {
        $this->email = $data["email"];
        $this->password = $data["password"];
        $this->model = new LoginModel();
        $this->errors = [];
        $this->old = [];
    }

    public function index()
    {
        if(!$this->model->verifyDbConnection())
        {
            $this->fail(true);
        }

        if($this->isEmpty())
        {
            $this->fail();
        }

        $requestedUser = $this->model->getUserFromRequest($this->email);
        if($requestedUser === false)
        {
            $this->fail(true);
        }
        else if($requestedUser)
        {
            $this->errors["email"] = "Waiting for admin approval";
            $this->fail();
        }

        $user = $this->model->getUser($this->email);
        if($user === false)
        {
            $this->fail(true);
        }
        else if($user === null){
            $this->errors["email"] = "Email or Password incorrect";
            $this->fail();
        }

        if(!password_verify($this->password, $user["password"])){
            $this->errors["email"] = "Email or Password incorrect";
            $this->fail();
        }

        $this->success();
    }

    private function isEmpty()
    {
        $check = false;

        if(empty($this->email)){
            $this->errors["email"] = "Email is required";
            $check = true;
        }
        if(empty($this->password)){
            $this->errors["password"] = "Password is required";
            $check = true;
        }
        return $check;
    }

    private function fail($db = false)
    {   
        if($db){
            $this->errors["db"] = "Database Connection Failed. Please try again later";
        }
        $this->old["email"] = $this->email;
        $this->view("login.php", ["errors" => $this->errors, "old" => $this->old]);
        exit();
    }

    private function success(){
        $user = $this->model->getUser($this->email);
        
        session_regenerate_id(true);
        $_SESSION["id"] = $user["id"];
        $_SESSION["email"] = $user["email"];
        $_SESSION["role"] = $user["role"];

        if((int)$user["role"] === 2){
            $this->redirect("/projects/xitTask_OOP/admin");
            exit();
        }
        else{
            $this->redirect("/projects/xitTask_OOP/dashboard");
            exit();
        }
    }

    
    
}