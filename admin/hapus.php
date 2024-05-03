<?php

require('../server/connection.php');

if (isset($_GET['id_produk'])) {

    $id_produk = $_GET['id_produk'];

    $sql = "DELETE FROM produk WHERE id_produk='$id_produk'";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo '<script>alert("Data produk berhasil dihapus."); window.location = "kelola-produk.php";</script>';
    } else {
        echo '<script>alert("Gagal menghapus data!");</script>';
    }
}
