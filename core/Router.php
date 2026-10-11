<?php

require_once(__DIR__."/../includes/autoLoader.php");

class Router
{
    private array $routes = [];

    public function __construct()
    {
        $this->routes = require(__DIR__."/../config/routes.php");
    }

    public function dispatch(string $method, string $uri): void
    {
        $path = parse_url($uri, PHP_URL_PATH);
        $path = '/' . trim($path, '/');

        if (isset($this->routes[$path])) {
            [$folder, $class] = $this->routes[$path];
            $class = $class.$method;
            $data = ($method === "POST") ? array_merge($_POST, $_FILES) : $_GET;
            if ($method === "GET" && isset($_SESSION["flash"])) {
                $data["flash"] = $_SESSION["flash"];
                unset($_SESSION["flash"]);
            }
            $controller = new $class($data);
            $controller->index();
            
        }
        else{
            header('Location: /projects/xitTask_OOP/');
            exit;
        }        
    }
}