<?php 
   
    $errors = $errors??[];
    function errClass(array $errors, string $field): string {
        return isset($errors[$field]) ? ' input-error' : '';
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include(__DIR__."/../includes/headContent.php"); ?>
    <link rel="stylesheet" href="/projects/xitTask_OOP/css/adminDashboard_profile.css">
    <link rel="stylesheet" href="/projects/xitTask_OOP/css/navbar.css">
    <link rel="stylesheet" href="/projects/xitTask_OOP/css/adminNavbar.css">
</head>
<body>
    <header>
        <?php include(__DIR__."/../includes/navbar.php"); ?>
    </header>
    <main>
        <?php include(__DIR__."/../includes/alert.php"); ?>
        <section>
        <form id="editPassword-form" class="edit-form" action="/projects/xitTask_OOP/admin/editPassword" method="post">
            <div class="info-field">
                <label class="label text-xl">Current Password: </label>
            
                
                <div class="input-wrapper">
                    <input id="edit-currentPassword" name="currentPassword" type="password" class="input<?= errClass($errors, 'currentPassword') ?>" placeholder="Enter current password" />
                    <i class="fa-solid fa-eye eye-open eye" onclick="toggleCurrentPassword(this)"></i>
                    <i class="fa-solid fa-eye-slash eye-close hidden eye" onclick="toggleCurrentPassword(this)"></i>
                </div>

                <p id="edit-currentPassword-error"><?php echo htmlspecialchars($errors["currentPassword"] ?? "") ?></p>
            </div>
            
            <div class="info-field">
                <label class="label text-xl">New Password: </label>
            
                
                <div class="input-wrapper">
                    <input id="edit-newPassword" name="newPassword" type="password" class="input<?= errClass($errors, 'newPassword') ?>" placeholder="Enter new password" />
                    <i class="fa-solid fa-eye eye-open eye" onclick="toggleNewPassword(this)"></i>
                    <i class="fa-solid fa-eye-slash eye-close hidden eye" onclick="toggleNewPassword(this)"></i>
                </div>

                <p id="edit-newPassword-error"><?php echo htmlspecialchars($errors["newPassword"] ?? "") ?></p>
            </div>
            
            <div class="info-field">
                <label class="label text-xl">Confirm New Password: </label>
            
                

                <div class="input-wrapper">
                    <input id="edit-confirmPassword" name="confirmPassword" type="password" class="input<?= errClass($errors, 'confirmPassword') ?>" placeholder="Confirm new password" />
                    <i class="fa-solid fa-eye eye-open eye" onclick="toggleConfirmPassword(this)"></i>
                    <i class="fa-solid fa-eye-slash eye-close hidden eye" onclick="toggleConfirmPassword(this)"></i>
                </div>

                <p id="edit-confirmPassword-error"><?php echo htmlspecialchars($errors["confirmPassword"] ?? "") ?></p>
            </div>
            


            <button id="editPassword-save-btn" type="submit" class="btn btn-primary">Save</button>
            
        </form>
    </section>




    </main>
    <script src="/projects/xitTask_OOP/js/passwordField.js"></script>
    <script src="/projects/xitTask_OOP/js/navbar.js"></script>
    <script src="/projects/xitTask_OOP/js/mode.js"></script>
    <script src="/projects/xitTask_OOP/js/alert.js"></script>
    
</body>
</html>