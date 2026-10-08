<?php

session_start();
require_once(__DIR__."/core/Router.php");

$router = new Router();

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);