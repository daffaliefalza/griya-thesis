<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin - Produk</title>

  <link rel="stylesheet" href="../css/default.css" />
  <link rel="stylesheet" href="../css/admin.css" />
</head>

<body>
  <div class="wrapper">
    <?php include 'sidebar.php' ?>
    <div class="top-bar">
      <h2>Kelola Artikel</h2>
      <div class="top-bar-links">
        <h3>Halo, <span style="color: #9f9f9f">Admin</span></h3>
        <a href="admin-logout.html">Logout</a>
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

        <tbody>
          <td>1</td>
          <td>Wedang Kencur</td>
          <td>Jamu</td>
          <td>
            <img src="../img/wedang-kencur.png" alt="wedang kencur" />
          </td>
          <td>Rp 15.000</td>
          <td>Terbuat dari bahan dan rempah pilihan</td>
          <td>50</td>
          <td>
            <a href="ubah.php?id_produk=<?php echo $row['id_produk'] ?>">Ubah</a>
            <a onclick="return confirm('Apakah kamu ingin menghapus data?')" href="hapus.php?id_produk=<?php echo $row['id_produk'] ?>" style="color: rgb(158, 20, 20)">Hapus</a>
          </td>
        </tbody>
      </table>
    </main>
    <footer class="admin-footer">
      Made with &hearts; - Andi Daffa Liefalza
    </footer>
  </div>
</body>

</html>