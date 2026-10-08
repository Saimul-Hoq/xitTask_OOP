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
            $data = ($method === "POST")? $_POST : $_GET;
            $controller = new $class($data);
            $controller->index();
            
        }
        else{
            header('Location: /projects/xitTask_OOP/');
            exit;
        }        
    }
}