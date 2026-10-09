<?php
class Controller
{
    protected function view(string $name, array $data = []): void
    {
        extract($data);
        require(__DIR__."/../views/".$name);
    }

    protected function redirect(string $url): void
    {
        header("Location: $url");
        exit;
    }

    protected function requireLogin(): void
    {
        if (!isset($_SESSION['id']) || empty($_SESSION["id"])) {
            $this->redirect('/projects/xitTask_OOP/');
            exit();
        }
    }
}