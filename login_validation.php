<?php
session_start();

require('server/connection.php');

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate the input to prevent SQL injection
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    // Check if username and password are not empty
    if (empty($username) || empty($password)) {
        echo "<script>alert('Mohon lengkapi username dan password'); window.location.href = 'login.php';</script>";
        exit();
    }

    // Query to fetch user from database
    $query = "SELECT * FROM users WHERE username = '$username' OR email = '$username'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Password is correct, start session and store user data
            $_SESSION['user_id'] = $user['id_users'];
            $_SESSION['username'] = $user['username'];
            // Redirect to dashboard or desired page
            header("Location: produk.php");
            exit();
        } else {
            // Incorrect password
            echo "<script>alert('Login gagal, masukkan username atau email dan password yang benar'); window.location.href = 'login.php';</script>";
            exit();
        }
    } else {
        // User not found
        echo "<script>alert('User tidak ditemukan'); window.location.href = 'login.php';</script>";
        exit();
    }
}
