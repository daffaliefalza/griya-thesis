<?php

require('../server/connection.php');


if (isset($_POST['tambah_data'])) {

    $nama_produk = $_POST['nama_produk'];
    $kategori_produk = $_POST['kategori_produk'];
    $gambar = $_POST['gambar'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $stok = $_POST['stok'];

    $sql = "INSERT INTO produk VALUES ('', '$nama_produk', '$kategori_produk', '$gambar', $harga, '$deskripsi', $stok)";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo '<script>alert("Data produk berhasil ditambah."); window.location = "index.php";</script>';
    } else {
        echo '<script>alert("Gagal menambahkan data!");</script>';
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>

    <link rel="stylesheet" href="../css/default.css">
    <link rel="stylesheet" href="../css/form-admin.css">

</head>

<body>

    <a href="./index.php" class="back">Kembali</a>

    <h1 style="text-align: center;">Tambah Data Produk</h1>

    <form action="" method="post">
        <label for="nama_produk">Nama Produk</label>
        <br>
        <input type="text" name="nama_produk" id="nama_produk">
        <br>

        <label for="kategori_produk">Kategori Produk</label>
        <br>


        <p>Rubah Jadi jamu / instan</p>

        <input type="text" name="kategori_produk" id="kategori_produk">
        <br>

        <label for="gambar">Gambar</label>
        <br>

        <input type="text" name="gambar" id="gambar">
        <br>

        <label for="harga">Harga</label>
        <br>
        <input type="number" name="harga" id="harga">
        <br>

        <label for="deskripsi">Deskripsi</label>
        <br>
        <textarea name="deskripsi" id="deskripsi" cols="30" rows="10"></textarea>
        <br>

        <label for="stok">Stok</label>
        <br>
        <input type="number" name="stok" id="stok">
        <br>

        <button type="submit" name="tambah_data">Tambah!</button>

    </form>




</body>

</html>