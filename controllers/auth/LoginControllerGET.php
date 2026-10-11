<?php

require_once(__DIR__."/../Controller.php");


class LoginControllerGET extends Controller
{
    private array $data;
    private string $status;
    private string $msg;

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->status = $data["flash"]["status"] ?? "failed";
        $this->msg = $data["flash"]["msg"] ?? "";
    }

    public function index()
    {
        $this->view("login.php", ["errors" => [], "status" => $this->status, "msg" => $this->msg]);
        exit();
    }
}