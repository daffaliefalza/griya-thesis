<?php

session_start();

require('../server/connection.php');
require('../server/functions.php');

// Pastikan user sudah login
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

// Jika tombol "Ubah Password" diklik
if (isset($_POST['ubah_password'])) {
    $id_admin = $_SESSION["id_admin"]; // Ambil ID admin dari session

    $password_lama = $_POST["password_lama"];
    $password_baru = $_POST["password_baru"];
    $konfirmasi_password = $_POST["konfirmasi_password"];

    // Validasi form
    if (empty($password_lama) || empty($password_baru) || empty($konfirmasi_password)) {
        $error = "Semua field harus diisi";
    } elseif (!password_verify($password_lama, $_SESSION["password"])) {
        $error = "Password lama salah";
    } elseif ($password_baru !== $konfirmasi_password) {
        $error = "Konfirmasi password tidak sesuai";
    } else {
        // Enkripsi password baru
        $password_hashed = password_hash($password_baru, PASSWORD_DEFAULT);

        // Update password di database
        $query = "UPDATE admin SET password = '$password_hashed' WHERE id_admin = '$id_admin'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            // Password berhasil diubah, redirect ke halaman index
            $_SESSION["password"] = $password_hashed; // Update password di session
            echo "<script>
                    alert('Password berhasil diubah');
                    window.location.href='index.php';
                 </script>";
            exit;
        } else {
            $error = "Gagal mengubah password. Silakan coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
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
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        form {
            margin-top: 20px;
        }

        ul {
            padding: 0;
            list-style: none;
        }

        li {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            /* cursor: not-allowed; */
            font-size: 16px;
            width: 100%;
            display: block;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            font-style: italic;
            margin-top: 10px;
        }


        /* input[disabled] {
            cursor: not-allowed;
        } */
    </style>
</head>

<body>
    <div>
        <marquee>
            For testing purpose, you're not allowed to change the password :-)
            <br>
            <img src="../proof_image/Ok.jpeg" alt="" width="130" style="border-radius: 50%;">
            <a href="index.php">Go Back please :)</a>
        </marquee>
    </div>
    <div class="container">
        <h1>Ubah Password</h1>

        <?php if (isset($error)) : ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="" method="post">
            <ul>
                <li>
                    <label for="password_lama">Password Lama:</label>
                    <input type="password" name="password_lama" id="password_lama" required>
                </li>
                <li>
                    <label for="password_baru">Password Baru:</label>
                    <input type="password" name="password_baru" id="password_baru" required>
                </li>
                <li>
                    <label for="konfirmasi_password">Konfirmasi Password Baru:</label>
                    <input type="password" name="konfirmasi_password" id="konfirmasi_password" required>
                </li>
                <li>
                    <button type="submit" name="ubah_password">Ubah Password</button>
                </li>
            </ul>
        </form>
    </div>
</body>

</html>