<?php
    $requests = $requests??[];
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
                <h4>Request List</h4>
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
                            <th> Accept </th>
                            <th> Reject </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($requests as $req): ?>
                        <tr>
                            <td class="withImage"> <img src="/projects/xitTask_OOP/uploads/<?= htmlspecialchars($req['avatar'] ?? 'default.png') ?>"> <?= htmlspecialchars($req['name']) ?> </td>
                            <td><?= htmlspecialchars($req['email']) ?></td>
                            <td><?= htmlspecialchars($req['mobile']) ?></td>
                            <td><?= htmlspecialchars(date("j F, Y", strtotime($req['registerDate']))) ?></td>  
                            <td><?= htmlspecialchars($req['address']) ?></td>
                            <td>
                                <form class="acceptForm" method="POST" action="/projects/xitTask_OOP/admin/requests">

                                    <input type="hidden" name="id" value="<?= htmlspecialchars($req['id']) ?>">

                                    <button name="action" value="accept" class="btn accept-btn" type="submit"><strong>Accept</strong> </button>
                                </form>
                            </td>
                            <td>

                                <form class="hidden rejectPopup" method="POST" action="/projects/xitTask_OOP/admin/requests">
                                    <p>Do you want to reject <?php echo htmlspecialchars($req["name"]??"this user") ?>?</p>

                                    <input type="hidden" name="id" value="<?= htmlspecialchars($req['id']) ?>">


                                    <div class="btn-area">
                                        <button type="button" class="btn accept-btn" onclick="openRejectPopup(this)">No</button>
                                        <button name="action" value="reject" class="btn reject-btn" type="submit">Yes</button>
                                    </div>

                                </form>

                                
                                    
                                <button onclick="openRejectPopup(this)" class="btn reject-btn" type="button"  ><strong>Reject</strong></button>
                                
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