<?php

spl_autoload_register("autoLoader");

function autoLoader($classname){

    $base = __DIR__ . "/../controllers/";
    $folders = ["auth", "user", "admin"];
    $ext = ".php";

    foreach ($folders as $folder) {
        $fullPath = $base . $folder . "/" . $classname . $ext;

        if (file_exists($fullPath)) {
            include_once($fullPath);
            return true;
        }
    }

    return false;
}