<?php
include '../server/connection.php';

$result = mysqli_query($conn, "SELECT * FROM artikel");



?>


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
      </div>
    </div>
    <main class="main-content">
      <div class="main-content-header">
        <h3> Artikel</h3>
        <a href="tambah.php" class="admin-produk" style="text-decoration: none;">+ Tambah Artikel</a>
      </div>

      <table class="content">
        <thead>
          <th>No</th>
          <th>Gambar</th>
          <th>Judul</th>
          <th>Konten</th>
          <th>Tanggal post</th>
          <th>Aksi</th>
        </thead>


        <?php
        $no = 1;
        while ($row = mysqli_fetch_assoc($result)) {
        ?>

          <tbody>
            <td><?php echo $no++ ?></td>
            <td>
              <img src="../img/<?php echo $row['image'] ?>" alt="">
            </td>
            <td><?php echo $row['title'] ?></td>
            <td>
              <p><?php echo $row['content'] ?></p>
            </td>
            <td><?php echo $row['date_post'] ?></td>
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