<?php

require_once(__DIR__."/../Controller.php");

class LogoutControllerGET extends Controller
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function index()
    {
        $_SESSION = [];
        session_destroy();
        $this->redirect("/projects/xitTask_OOP/");
        exit();
    }
}