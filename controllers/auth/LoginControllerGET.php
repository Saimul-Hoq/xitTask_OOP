<?php

require_once(__DIR__."/../Controller.php");


class LoginControllerGET extends Controller
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function index()
    {
        $this->view("login.php", ["errors" => [], "old" => []]);
    }
}