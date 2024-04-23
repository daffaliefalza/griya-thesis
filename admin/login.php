<?php


session_start();

require('../server/connection.php');
require('../server/functions.php');

if (isset($_SESSION["login"])) {
  header("Location: index.php");
  exit;
}



if (isset($_POST['login'])) {

  $username = $_POST["username"];
  $password = $_POST["password"];

  $result = mysqli_query($conn, "SELECT * FROM admin WHERE username = '$username'");

  // cek username

  if (mysqli_num_rows($result) === 1) {


    // cek password
    $row = mysqli_fetch_assoc($result);
    if (password_verify($password, $row["password"])) {
      $_SESSION["login"] = true;
      $_SESSION["id_admin"] = $row["id_admin"];
      $_SESSION["password"] = $row["password"];
      // set session
      header("Location: index.php");
      exit;
    }
  }

  $error = true;
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halaman Login</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f8f9fa;
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    .container {
      max-width: 400px;
      margin: 50px auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }

    form {
      margin-top: 20px;
    }

    label {
      display: block;
      margin-bottom: 5px;
      color: #555;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }

    button[type="submit"] {
      width: 100%;
      padding: 10px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button[type="submit"]:hover {
      background-color: #0056b3;
    }

    .error-message {
      color: red;
      font-style: italic;
      margin-top: 10px;
      text-align: center;
    }
  </style>
</head>

<body>

  <div class="container">
    <h1>Halaman Login Admin</h1>

    <?php if (isset($error)) { ?>
      <p class="error-message">Username atau password salah.</p>
    <?php } ?>

    <form action="" method="post">
      <div>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
      </div>
      <div>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
      </div>
      <div>
        <button type="submit" name="login">Login</button>
      </div>
    </form>
  </div>

</body>

</html>