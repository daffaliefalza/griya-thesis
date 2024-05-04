<?php

session_start();

include '../server/connection.php';


$result = mysqli_query($conn, "SELECT * FROM users ");


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin - Data Pelanggan</title>
    <link rel="stylesheet" href="../css/default.css" />
    <link rel="stylesheet" href="../css/admin.css">



</head>

<body>
    <div class="wrapper">
        <?php include 'sidebar.php' ?>
        <div class="top-bar">
            <h2>Data Pelanggan</h2>

        </div>
        <main class="main-content">

            <table class="content">
                <thead>
                    <th>No</th>
                    <th>Username</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                </thead>
                <?php

                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) {

                ?>
                    <tbody>
                        <td><?php echo $no++ ?></td>
                        <td><?php echo $row['username'] ?></td>
                        <td><?php echo $row['fullname'] ?></td>
                        <td><?php echo "Email di hide untuk kenyamanan bersama." ?></td>

                    </tbody>

                <?php } ?>
            </table>
        </main>
        <footer class="admin-footer">
            Made with &hearts; - Andi Daffa Liefalza
        </footer>
    </div>
</body>

</html>