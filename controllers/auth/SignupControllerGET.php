<?php

require_once(__DIR__."/../Controller.php");


class SignupControllerGET extends Controller
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function index()
    {
        $this->view("signup.php", ["errors" => []]);
        exit();
    }
}