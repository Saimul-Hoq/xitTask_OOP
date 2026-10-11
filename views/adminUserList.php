<?php
    $users = $users??[];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <?php include(__DIR__."/../includes/headContent.php"); ?>
    <link rel="stylesheet" href="/projects/xitTask_OOP/css/adminDashboard_requests.css">
    <link rel="stylesheet" href="/projects/xitTask_OOP/css/navbar.css">
    <link rel="stylesheet" href="/projects/xitTask_OOP/css/adminNavbar.css">

</head>
<body>
    <header>
        <?php include(__DIR__."/../includes/navbar.php"); ?>
    </header>
    <main>
        <div class="table">
            <section class="table-header">
                <h4>User List</h4>
            </section>
            <section class="table-body">
                <table id="table">
                    <thead>
                        <tr>
                            <th> User </th>
                            <th> Email </th>
                            <th> Mobile </th>
                            <th> Date </th>
                            <th>Address</th>
                            <th> Delete </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td class="withImage"> <img src="/projects/xitTask_OOP/uploads/<?= htmlspecialchars($user['avatar'] ?? 'default.png') ?>"> <?= htmlspecialchars($user['name']) ?> </td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['mobile']) ?></td>
                            <td><?= htmlspecialchars(date("j F, Y", strtotime($user['registerDate']))) ?></td>  
                            <td><?= htmlspecialchars($user['address']) ?></td>
                            <td>

                                    <form class="hidden rejectPopup" method="POST" action="/projects/xitTask_OOP/admin/userList">
                                    <p>Do you want to Delete <?php echo htmlspecialchars($user["name"]??"this user") ?>?</p>

                                    <input type="hidden" name="userId" value="<?= htmlspecialchars($user['id']) ?>">


                                    <div class="btn-area">
                                        <button type="button" class="btn accept-btn" onclick="openRejectPopup(this)">No</button>
                                        <button class="btn reject-btn" type="submit">Yes</button>
                                    </div>

                                </form>

                                <button onclick="openRejectPopup(this)" class="btn reject-btn" type="button"  ><strong>Delete</strong></button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
        </div>

        
    </main>
    <script src="/projects/xitTask_OOP/js/request.js"></script>
    <script src="/projects/xitTask_OOP/js/navbar.js"></script>
    <script src="/projects/xitTask_OOP/js/mode.js"></script>
</body>
</html>