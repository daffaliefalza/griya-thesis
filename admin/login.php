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
    label {
      display: block;
    }
  </style>

</head>

<body>

  <h1>Halaman Login</h1>

  <?php if (isset($error)) { ?>
    <p style="color: red; font-style: italic;">username / password salah</p>
  <?php } ?>

  <form action="" method="post">
    <ul>
      <li>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username">
      </li>
      <li>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password">
      </li>

      <li>
        <button type="submit" name="login">Login</button>
      </li>

    </ul>
  </form>

</body>

</html>