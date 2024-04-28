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
        echo "Username or email already exists";
    } else {
        // Hash the password before storing it in the database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user into the database
        $insert_query = "INSERT INTO users (username, fullname, email, password) VALUES ('$username', '$fullname', '$email', '$hashed_password')";
        $insert_result = mysqli_query($conn, $insert_query);

        if ($insert_result) {
            echo "User registered successfully";
            // Redirect to login page or dashboard
            header('Location: login.php');
        } else {
            echo "Error registering user";
        }
    }
}
