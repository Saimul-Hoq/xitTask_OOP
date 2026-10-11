<?php
    $status = $status??"failed";
    $msg = $msg ?? "";

    function alert($status){
        if($status === "success"){
            return " alert-success";
        }
        elseif($status === "error"){
            return " alert-error";
        }
    }

    function alertMsg($msg){
        return $msg;
    }

    function alertIcon($status){
        if($status === "success"){
            return " fa-solid fa-check";
        }
        elseif($status === "error"){
            return " fa-solid fa-circle-exclamation";
        }
    }
?>

<section class="alert <?= alert($status) ?>">
    <div class="alert-container">
        <i class="<?= alertIcon($status) ?>"></i>
        <p><?= alertMsg($msg) ?></p>
    </div>
    <button onclick="hideAlert(this)" class="btn-ghost"><p><i class="fa-solid fa-xmark"></i></p></button>

   
</section> 