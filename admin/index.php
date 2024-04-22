<?php
session_start();

require('../server/connection.php');

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}


$sql = "SELECT * FROM produk";
$result = mysqli_query($conn, $sql);



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin - Produk</title>
    <link rel="stylesheet" href="../css/default.css" />
    <link rel="stylesheet" href="../css/admin.css">



</head>

<body>
    <div class="wrapper">
        <?php include 'sidebar.php' ?>
        <div class="top-bar">
            <h2>Dashboard</h2>
            <div class="top-bar-links">
                <h3>Halo, <span style="color: #9f9f9f">Admin</span></h3>
            </div>
        </div>
        <main class="main-content">
            <div class="main-content-header">
                <h3>Dashboard</h3>
            </div>


        </main>
        <footer class="admin-footer">
            Made with &hearts; - Andi Daffa Liefalza
        </footer>
    </div>
</body>

</html>