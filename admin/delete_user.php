<?php

session_start();
include '../server/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_user'])) {
    $id_user = $_POST['id_user'];

    // Delete associated orders first
    $query_orders = "DELETE FROM orders WHERE id_users = $id_user";
    mysqli_query($conn, $query_orders);

    // Now delete the user
    $query_user = "DELETE FROM users WHERE id_users = $id_user";
    if (mysqli_query($conn, $query_user)) {
        header("Location: data-pelanggan.php");
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}
