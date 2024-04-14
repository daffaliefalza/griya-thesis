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
        label {
            display: block;
        }
    </style>
</head>

<body>
    <h1>Ubah Password</h1>

    <?php if (isset($error)) : ?>
        <p style="color: red; font-style: italic;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="" method="post">
        <ul>
            <li>
                <label for="password_lama">Password Lama:</label>
                <input type="password" name="password_lama" id="password_lama">
            </li>
            <li>
                <label for="password_baru">Password Baru:</label>
                <input type="password" name="password_baru" id="password_baru">
            </li>
            <li>
                <label for="konfirmasi_password">Konfirmasi Password Baru:</label>
                <input type="password" name="konfirmasi_password" id="konfirmasi_password">
            </li>
            <li>
                <button type="submit" name="ubah_password">Ubah Password</button>
            </li>
        </ul>
    </form>
</body>

</html>