<?php

require('../server/connection.php');

if (isset($_GET['id_produk'])) {
    $id_produk = $_GET['id_produk'];

    // Retrieve existing data based on id_produk
    $sql = "SELECT * FROM produk WHERE id_produk='$id_produk'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Check if form is submitted for updating data
        if (isset($_POST['ubah_data'])) {
            $nama_produk = $_POST['nama_produk'];
            $kategori_produk = $_POST['kategori_produk'];
            $gambar = $_POST['gambar'];
            $harga = $_POST['harga'];
            $deskripsi = $_POST['deskripsi'];
            $stok = $_POST['stok'];

            // Update the data in the database
            $sql = "UPDATE produk SET nama_produk='$nama_produk', kategori_produk='$kategori_produk', image='$gambar', harga=$harga, deskripsi='$deskripsi', stok=$stok WHERE id_produk='$id_produk'";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo '<script>alert("Data produk berhasil diubah."); window.location = "index.php";</script>';
            } else {
                echo '<script>alert("Gagal mengubah data!");</script>';
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Produk</title>

    <link rel="stylesheet" href="../css/default.css">
    <link rel="stylesheet" href="../css/form-admin.css">

</head>

<body>

    <a href="./index.php" class="back">Kembali</a>
    <h1 style="text-align: center;">Ubah Data Produk</h1>

    <form action="" method="post">
        <label for="nama_produk">Nama Produk</label><br>
        <input type="text" name="nama_produk" id="nama_produk" value="<?php echo $row['nama_produk']; ?>"><br>

        <label for="kategori_produk">Kategori Produk</label><br>
        <input type="text" name="kategori_produk" id="kategori_produk" value="<?php echo $row['kategori_produk']; ?>"><br>


        <label for="gambar">Gambar</label><br>
        <input type="text" name="gambar" id="gambar" value="<?php echo $row['image']; ?>"><br>

        <label for="harga">Harga</label><br>
        <input type="number" name="harga" id="harga" value="<?php echo $row['harga']; ?>"><br>

        <label for="deskripsi">Deskripsi</label><br>
        <textarea name="deskripsi" id="deskripsi" cols="30" rows="10"><?php echo $row['deskripsi']; ?></textarea><br>

        <label for="stok">Stok</label><br>
        <input type="number" name="stok" id="stok" value="<?php echo $row['stok']; ?>"><br>

        <button type="submit" name="ubah_data">Ubah!</button>
    </form>


</body>

</html>