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

    protected function requireAdmin(): void
    {
        $this->requireLogin();
        if ((int)($_SESSION["role"] ?? 0) !== 1) {
            $this->redirect('/projects/xitTask_OOP/');
        }
    }
}