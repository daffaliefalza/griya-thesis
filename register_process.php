<?php
require('server/connection.php');

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate input
    // (You can add more validation checks as needed)

    // Check if username or email already exists
    $query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Username atau email telah terdaftar'); window.location.href = 'register.php';</script>";
    } else {
        // Hash the password before storing it in the database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user into the database
        $insert_query = "INSERT INTO users (username, fullname, email, password) VALUES ('$username', '$fullname', '$email', '$hashed_password')";
        $insert_result = mysqli_query($conn, $insert_query);

        if ($insert_result) {
            echo "<script>alert('Registrasi berhasil');</script>";
            // Redirect to login page or dashboard
            echo "<script>window.location = 'login.php';</script>";
        } else {
            echo "Error registering user";
        }
    }
}
