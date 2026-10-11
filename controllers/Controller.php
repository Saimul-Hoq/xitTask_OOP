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

    protected function flash(array $data): void
    {
        $_SESSION["flash"] = $data;
    }

    public function getCurrentUser($id, $model)
    {
        $user = $model->getUser($id);
        
        if($user === false){
            $this->dbfail();
        }
        if($user === null){
            $this->flash(["status" => "error", "msg" => "Please login again."]);
            $this->redirect("/projects/xitTask_OOP/");
            exit();
        }

        return $user;
    }


    public function dbFail()
    {
        $this->flash(["status" => "error", "msg" => "Something went wrong. Please try again later"]);
        $this->redirect("/projects/xitTask_OOP/");
        exit();
    }
}