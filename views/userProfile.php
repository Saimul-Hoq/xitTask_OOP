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
                    <a href="/projects/xitTask_OOP/user/profile" id="my-account" class="btn-icon bg-optionSelected" >My Account</a>
                    <a href="/projects/xitTask_OOP/user/editProfile" id="edit-account" class="btn-icon">Edit Account</a>
                </div>
                
            </div>
            <div class="main-panel">
                <div id="main-upper">
                    <h1 id="sidepanel-heading">My Account</h1>

                    <h2 id="profile-details-heading" class="text-light">Profile Details</h2>
                    
                    <div id="profile-photo-section">
                        <div class="profile-image">
                            <img src="/projects/xitTask_OOP/uploads/<?= htmlspecialchars($user["avatar"]) ?>" alt="Profile Picture">
                        </div>
                        
                        <div class="username">
                            <h1><?php echo htmlspecialchars($user["name"]??"") ?></h1>
                            <p class="text-gray">User</p>
                        </div>
                    </div>

                    <h2 id="business-profile-heading" class="text-light">Business Profile</h2>

                    <div id="business-info">
                        <div class="info-field">
                            <p>Business Name</p>
                            <input readonly id="edit-name" name="name" type="text" value="<?php echo htmlspecialchars($user["name"] ?? "") ?>" class="input"/>
                        </div>

                        <div class="info-field">
                            <p>Business Id</p>
                            <input readonly id="edit-id" name="id" type="text" value="<?php echo htmlspecialchars($user["id"] ?? "") ?>" class="input"/>
                        </div>

                        <div class="info-field">
                            <p>Location</p>
                            <input readonly id="edit-adress" name="address" type="text" value="<?php echo htmlspecialchars($user["address"] ?? "") ?>" class="input"/>
                        </div>
                    </div>
                    <div id="contact-info">
                        <div class="info-field">
                            <p>Email</p>
                            <input readonly id="edit-email" name="email" type="text" value="<?php echo htmlspecialchars($user["email"] ?? "") ?>" class="input"/>
                        </div>
                        <div class="info-field">
                            <p>Mobile Number</p>
                            <input readonly id="edit-mobile" name="mobile" type="text" value="<?php echo htmlspecialchars($user["mobile"] ?? "") ?>" class="input"/>
                        </div>
                    </div>

                
                </div>

            </div>
        </section>

        



    </main>
    <script src="/projects/xitTask_OOP/js/mode.js"></script>
    <script src="/projects/xitTask_OOP/js/navbar.js"></script>
</body>
</html>