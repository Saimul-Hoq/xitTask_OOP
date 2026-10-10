<?php
    $errors = $errors??[];
    $open = $open??[];

    function errClass(array $errors, string $field): string {
        return isset($errors[$field]) ? ' input-error' : '';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include(__DIR__."/../includes/headContent.php"); ?>
    <link rel="stylesheet" href="/projects/xitTask_OOP/css/dashboard.css">
    <link rel="stylesheet" href="/projects/xitTask_OOP/css/navbar.css">

</head>
<body>
    <header>
        <?php include(__DIR__."/../includes/userNavbar.php"); ?>
    </header>
    <main>

        <section id="profile" class="card">
            <h1 id="mainHeading">Account Settings</h1>
            <div class="side-panel">
                <h4 class="side-panel-heading">BUSINESS SETTINGS</h4>

                <div class="link-container">
                    <a href="/projects/xitTask_OOP/user/profile" id="my-account" class="btn-icon" >My Account</a>
                    <a  id="edit-account" class="btn-icon bg-optionSelected">Edit Account</a>
                </div>
                
            </div>
            <form id="edit-form" action="/projects/xitTask_OOP/user/editProfile" method="post" enctype="multipart/form-data" class="main-panel edit-form" data-open-password="<?= !empty($open['password']) ? 'true' : 'false' ?>" data-open-avatar="<?= !empty($open['avatar']) ? 'true' : 'false' ?>">

                <div id="main-upper">
                    <h1 id="sidepanel-heading">My Account</h1>

                    <h2 id="profile-details-heading" class="text-light">Profile Details</h2>
                    
                    <div id="profile-photo-section">
                        <div class="profile-image">
                            <img src="/projects/xitTask_OOP/uploads/<?= htmlspecialchars($user["avatar"]) ?>" alt="Profile Picture">
                        </div>
                        <div class="change-avatar-part info-field">
                            <button type="button" onclick="openEditAvatar(this)" id="edit-avatar-btn" class="btn-icon">Change Avatar</button>
                            
                            <input disabled name="avatar" id="edit-avatar" type="file" accept="image/*" class="input<?= errClass($errors, 'avatar') ?> hidden" placeholder="Enter your profile photo" />
                            
                            <p id="edit-avatar-error"><?php echo htmlspecialchars($errors["avatar"] ?? "") ?></p>
                        </div>
                        
                        <button type="submit" form="delete-avatar-form" id="delete-avatar-btn" class="btn-icon">Delete Avatar</button>
                        
                    </div>

                    <h2 id="business-profile-heading" class="text-light">Business Profile</h2>

                    <div id="business-info">
                        <div class="info-field">
                            <p>Business Name</p>
                            <input id="edit-name" name="name" type="text" value="<?php echo htmlspecialchars($user["name"] ?? "") ?>" class="input<?= errClass($errors, 'name') ?>" placeholder="Enter new name" />
                            <p id="edit-name-error"><?php echo htmlspecialchars($errors["name"] ?? "") ?></p>
                        </div>

                        <div class="info-field">
                            <p>Business Id</p>
                            <input readonly id="edit-id" name="id" type="text" value="<?php echo htmlspecialchars($user["id"] ?? "") ?>" class="input"/>
                        </div>

                        <div class="info-field">
                            <p>Location</p>
                            <input id="edit-adress" name="address" type="text" value="<?php echo htmlspecialchars($user["address"] ?? "") ?>" class="input<?= errClass($errors, 'address') ?>" placeholder="Enter new address" />
                            <p id="edit-address-error"><?php echo htmlspecialchars($errors["address"] ?? "") ?></p>
                        </div>
                    </div>

                    <div class="email-info-heading">
                        <h2 class="text-light">Email</h2>
                        <p class="text-md text-gray">This contact will be shown to others publicly, so choose it carefully.</p>
                    </div>

                    <div class="email-input info-field">
                        <input readonly id="edit-email" name="email" type="text" value="<?php echo htmlspecialchars($user["email"] ?? "") ?>" class="input"/>
                    </div>

                    <div class="email-info-heading">
                        <h2 class="text-light">Password</h2>
                        <p class="text-md text-gray">It is recommended to use a combination of letters, numbers, and special characters.</p>
                    </div>


                    <div id="password-info">
                        <button  type="button" onclick="openEditPassword(this)"  id="edit-password-btn" class="btn-icon">Set new password</button>

                        <div id="edit-password-fields" class="hidden">
                            <div class="info-field">
                                <p>Current Password</p>
                                <div class="input-wrapper">
                                    <input disabled id="edit-currentPassword" name="currentPassword" type="password" class="input<?= errClass($errors, 'currentPassword') ?>" placeholder="Enter current password" />
                                    <i class="fa-solid fa-eye eye-open eye" onclick="toggleCurrentPassword(this)"></i>
                                    <i class="fa-solid fa-eye-slash eye-close hidden eye" onclick="toggleCurrentPassword(this)"></i>
                                </div>
                                <p id="edit-currentPassword-error"><?php echo htmlspecialchars($errors["currentPassword"] ?? "") ?></p>
                            </div>

                            <div class="info-field">
                                <p>New Password</p>
                                <div class="input-wrapper">
                                    <input disabled id="edit-newPassword" name="newPassword" type="password" class="input<?= errClass($errors, 'newPassword') ?>" placeholder="Enter new password" />
                                    <i class="fa-solid fa-eye eye-open eye" onclick="toggleNewPassword(this)"></i>
                                    <i class="fa-solid fa-eye-slash eye-close hidden eye" onclick="toggleNewPassword(this)"></i>
                                </div>
                                <p id="edit-newPassword-error"><?php echo htmlspecialchars($errors["newPassword"] ?? "") ?></p>
                            </div>

                            <div class="info-field">
                                <p>Confirm Password</p>
                                <div class="input-wrapper">
                                    <input disabled id="edit-confirmPassword" name="confirmPassword" type="password" class="input<?= errClass($errors, 'confirmPassword') ?>" placeholder="Confirm new password" />
                                    <i class="fa-solid fa-eye eye-open eye" onclick="toggleConfirmPassword(this)"></i>
                                    <i class="fa-solid fa-eye-slash eye-close hidden eye" onclick="toggleConfirmPassword(this)"></i>
                                </div>

                                <p id="edit-confirmPassword-error"><?php echo htmlspecialchars($errors["confirmPassword"] ?? "") ?></p>
                            </div>
                        </div>
                    </div>


                    <div class="email-info-heading">
                        <h2 class="text-light">Mobile Number</h2>
                        <p class="text-md text-gray">Mobile Number must not be registered before</p>
                    </div>

                    <div id="edit-mobile-part" class="email-input info-field">
                        <input id="edit-mobile" name="mobile" type="text" value="<?php echo htmlspecialchars($user["mobile"] ?? "") ?>" class="input<?= errClass($errors, 'mobile') ?>"/>
                        <p id="edit-mobile-error"><?php echo htmlspecialchars($errors["mobile"] ?? "") ?></p>
                    </div>
                </div>
                

                <section id="submit-part" >
                    <div class="btn-container">
                        <a href="/projects/xitTask_OOP/user/profile" id="submit-cancel-btn" class="btn-icon">Cancel</a>

                        <input type="hidden" name="controller" value="user">
                        <button type="submit" id="submit-btn" class="btn-icon">Submit</button>
                    </div>
                </section>

            </form>

            <form id="delete-avatar-form" action="/projects/xitTask_OOP/" method="POST">
                <input type="hidden" name="action" value="deleteAvatar">
                <input type="hidden" name="controller" value="user">
            </form>
        </section>

        

       
    </main>
    <script src="/projects/xitTask_OOP/js/dashboard.js"></script>
    <script src="/projects/xitTask_OOP/js/passwordField.js"></script>
    <script src="/projects/xitTask_OOP/js/mode.js"></script>
    <script src="/projects/xitTask_OOP/js/navbar.js"></script>

</body>
</html>