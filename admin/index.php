<?php
session_start();

require('../server/connection.php');

if (!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}


$sql = "SELECT * FROM produk";
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



</head>

<body>
  <div class="wrapper">
    <aside class="sidebar">
      <div class="sidebar-header">
        <img src="../img/logo.png" alt="logo griya jamoe" />
      </div>
      <div class="sidebar-content">
        <ul style="padding: 0.5rem;">
          <li style="display: flex; align-items: center; gap: 0.4rem; ">
            <img src="../img/produk-icon.svg" width="25">
            <a href="index.php">Kelola Produk</a>
          </li>
          <li style="display: flex; align-items: center;  gap: 0.4rem;">
            <img src="../img/blog-icon.svg" width="25">
            <a href="kelola-blog.php">Kelola Blog</a>
          </li>
        </ul>
      </div>
    </aside>
    <div class="top-bar">
      <h2>Kelola Produk</h2>
      <div class="top-bar-links">
        <h3>Halo, <span style="color: #9f9f9f">Admin</span></h3>
        <a href="logout.php">Logout</a>
      </div>
    </div>
    <main class="main-content">
      <div class="main-content-header">
        <h3>Data Produk</h3>
        <a href="tambah.php" class="admin-produk" style="text-decoration: none;">+ Tambah Produk</a>
        <input type="search" placeholder="Cari data produk" />
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
            <td><?php echo $row['nama_produk'] ?></td>
            <td><?php echo $row['kategori_produk'] ?></td>
            <td>
              <img src="../img/<?php echo $row['image']; ?>" alt="wedang kencur" />
            </td>
            <td><?php echo 'Rp ' . number_format($row['harga'], 0, ',', '.') ?></td>
            <td><?php echo $row['deskripsi'] ?></td>
            <td><?php echo $row['stok'] ?></td>
            <td>
              <a href="ubah.php?id_produk=<?php echo $row['id_produk'] ?>">Ubah</a>
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