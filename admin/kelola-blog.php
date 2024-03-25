<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin - Produk</title>

    <link rel="stylesheet" href="../css/default.css" />
    <link rel="stylesheet" href="../css/admin/style.css" />
  </head>
  <body>
    <div class="wrapper">
      <aside class="sidebar">
        <div class="sidebar-header">
          <img src="../img/logo.png" alt="logo griya jamoe" />
        </div>
        <div class="sidebar-content">
          <ul>
            <li>
              <a href="index.html">Kelola Produk</a>
            </li>
            <li>
              <a href="kelola-blog.html">Kelola Blog</a>
            </li>
          </ul>
        </div>
      </aside>
      <div class="top-bar">
        <h2>Kelola Blog</h2>
        <div class="top-bar-links">
          <h3>Halo, <span style="color: #9f9f9f">Admin</span></h3>
          <a href="admin-logout.html">Logout</a>
        </div>
      </div>
      <main class="main-content">
        <div class="main-content-header">
          <h3>Data Blog</h3>
          <button class="admin-produk">+ Tambah Blog</button>
          <input type="search" placeholder="Cari data blog" />
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
              <a href="#">Ubah</a>
              <a href="#" style="color: rgb(158, 20, 20)">Hapus</a>
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
