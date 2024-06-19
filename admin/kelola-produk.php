<?php
session_start();

require('../server/connection.php');

if (!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

if (isset($_GET['search'])) {
  $search = $_GET['search'];
  $sql = "SELECT * FROM produk WHERE product_name LIKE '%$search%' OR product_category LIKE '%$search%'";
} else {
  $sql = "SELECT * FROM produk";
}

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin - Produk</title>
  <link rel="stylesheet" href="../css/default.css" />
  <link rel="stylesheet" href="../css/admin.css">

  <style>
    @media (max-width: 908px) {
      .main-content-header {
        flex-direction: column !important;
      }
    }
  </style>

</head>

<body>
  <div class="wrapper">
    <?php include 'sidebar.php' ?>
    <div class="top-bar">
      <h2>Kelola Produk</h2>
      <div class="top-bar-links">
        <h3>Halo, <span style="color: #9f9f9f">Admin</span></h3>
      </div>
    </div>
    <main class="main-content">
      <div class="main-content-header">
        <h3>Data Produk</h3>
        <a href="tambah.php" class="admin-produk" style="text-decoration: none;">+ Tambah Produk</a>
        <form action="" method="get" style="display: flex;">
          <input type="text" name="search" placeholder="Cari berdasarkan nama atau kategori" style="  width: 300px; padding: 10px; border-radius: 5px 0 0 5px; border: 1px solid #ccc;">
          <button type="submit" style="padding: 10px 20px; background-color: #007bff; color: #fff; border: none; border-radius: 0 5px 5px 0; cursor: pointer;">Search</button>
        </form>
      </div>

      <table class="content">
        <thead>
          <th>No</th>
          <th>Nama Produk</th>
          <th>Kategori Produk</th>
          <th>Gambar</th>
          <th>Harga</th>
          <th>Deskripsi</th>
          <th>Stok</th>
          <th>Aksi</th>
        </thead>
        <?php
        $no = 1;
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
          <tbody>
            <td><?php echo $no++ ?></td>
            <td><?php echo $row['product_name'] ?> </td>
            <td><?php echo $row['product_category'] ?></td>
            <td>
              <img src="upload_file/<?php echo $row['image']; ?>" />
            </td>
            <td><?php echo 'Rp ' . number_format($row['price'], 0, ',', '.') ?></td>
            <td><?php echo $row['description'] ?></td>
            <td><?php echo $row['stok'] ?></td>
            <td style="display: flex; align-items: center; height: 200px">
              <a href="ubah.php?id_produk=<?php echo $row['id_produk'] ?>" disabled>Ubah</a>
              <a onclick="return confirm('Apakah kamu ingin menghapus data?')" href="hapus.php?id_produk=<?php echo $row['id_produk'] ?>" style="color: rgb(158, 20, 20)">Hapus</a>
            </td>
          </tbody>
        <?php } ?>
      </table>
    </main>
    <footer class="admin-footer">
      Made with &hearts; - Andi Daffa Liefalza
    </footer>
  </div>
</body>

</html>