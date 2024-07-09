<?php
require('server/connection.php');

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $phone = $_POST['phone'];
    $full_address = $_POST['full_address'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate phone number length
    if (strlen($phone) !== 10) {
        echo "<script>alert('Nomor telepon harus memiliki 10 - 13 digit'); window.location.href = 'register.php';</script>";
        exit(); // Exit script if validation fails
    }


    // Check if username or email already exists
    $query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Username atau email telah terdaftar'); window.location.href = 'register.php';</script>";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $insert_query = "INSERT INTO users (username, fullname, phone_number, full_address, email, password) VALUES ('$username', '$fullname', '$phone','$full_address', '$email', '$hashed_password')";
        $insert_result = mysqli_query($conn, $insert_query);

        if ($insert_result) {
            echo "<script>alert('Registrasi berhasil');</script>";
            echo "<script>window.location = 'login.php';</script>";
        } else {
            echo "Error registering user";
        }
    }
}
