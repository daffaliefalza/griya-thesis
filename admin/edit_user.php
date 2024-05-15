<?php

session_start();
include '../server/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_user'])) {
    $id_user = $_POST['id_user'];

    // Fetch user data
    $query = "SELECT * FROM users WHERE id_users = $id_user";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id_user = $_POST['id_user'];
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];

    // Update user data
    $query = "UPDATE users SET username = '$username', fullname = '$fullname', phone_number = '$phone_number', email = '$email' WHERE id_users = $id_user";
    if (mysqli_query($conn, $query)) {
        echo "<script>
            alert('Data pelanggan berhasil diubah');
            window.location.href = 'data-pelanggan.php';
        </script>";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .wrapper {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin: 10px 0 5px;
            color: #555;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 15px;
            font-size: 16px;
        }

        button {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        button[type="submit"] {
            background-color: #3498db;
            color: #fff;
            margin-bottom: 10px;
        }

        button[type="submit"]:hover {
            background-color: #2980b9;
        }

        a {
            text-align: center;
            color: #3498db;
            text-decoration: none;
            margin-top: 15px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <h2>Edit User</h2>
        <form action="edit_user.php" method="POST">
            <input type="hidden" name="id_user" value="<?php echo $user['id_users']; ?>">
            <label for="username">Username:</label>
            <input type="text" name="username" value="<?php echo $user['username']; ?>" required><br>
            <label for="fullname">Full Name:</label>
            <input type="text" name="fullname" value="<?php echo $user['fullname']; ?>" required><br>
            <label for="phone">No Telepon:</label>
            <input type="number" name="phone_number" value="<?php echo $user['phone_number']; ?>" required><br>
            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo $user['email']; ?>" required><br>
            <button type="submit" name="update">Update</button>
        </form>
        <a href="data-pelanggan.php">Kembali</a>
    </div>
</body>

</html>