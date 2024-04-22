  <style>
      .sidebar-content ul {
          list-style: none;
          padding: 0;
      }

      .sidebar-content li {
          border-top: 2px solid #ddd;
      }

      .sidebar-content li:first-child {
          border-top: none;
      }

      .sidebar-content a {
          text-decoration: none;
          color: #333;
          padding: 5px 10px;
          display: flex;
          align-items: center;
      }

      .sidebar-content a:hover {
          background-color: #f0f0f0;
      }

      .sidebar-content img {
          width: 25px;
          margin-right: 10px;
      }

      .sidebar-content span {
          flex: 1;
      }

      .sidebar-content li:hover {
          background-color: #f0f0f0;
      }
  </style>



  <aside class="sidebar">
      <div class="sidebar-header">
          <img src="../img/logo.png" alt="logo griya jamoe" />
      </div>
      <div class="sidebar-content">
          <ul>
              <li style="display: flex; align-items: center; gap: 0.4rem;  ">
                  <a href="index.php" style="display: flex; gap: 0.5rem; align-items: center;">
                      <img src="../img/dashboards.png" width="25">
                      <span>Dashboard</span>
                  </a>
              </li>
              <li style="display: flex; align-items: center; gap: 0.4rem; ">
                  <a href="kelola-produk.php" style="display: flex; gap: 0.5rem; align-items: center;">
                      <img src="../img/products.png" width="25">
                      <span>Kelola Produk</span>
                  </a>
              </li>
              <li style="display: flex; align-items: center;  gap: 0.4rem;">
                  <a href="kelola-blog.php" style="display: flex; gap: 0.5rem; align-items: center;">
                      <img src="../img/blog-icon.svg" width="25">
                      <span>Kelola Artikel</span>
                  </a>
              </li>
              <li style="display: flex; align-items: center;  gap: 0.4rem;">
                  <a href="data-pesanan.php" style="display: flex; gap: 0.5rem; align-items: center;">
                      <img src="../img/checkout.png" width="25">
                      <span>Data Pesanan</span>
                  </a>
              </li>
              <li style="display: flex; align-items: center;  gap: 0.4rem;">
                  <a href="data-pelanggan.php" style="display: flex; gap: 0.5rem; align-items: center;">
                      <img src="../img/transaction-history.png" width="25">
                      <span>Data Pelanggan</span>
                  </a>
              </li>
              <li style="display: flex; align-items: center;  gap: 0.4rem;">
                  <a href="laporan-transaksi.php" style="display: flex; gap: 0.5rem; align-items: center;">
                      <img src="../img/transaction-history.png" width="25">
                      <span>Laporan Transaksi</span>
                  </a>
              </li>
              <li style="display: flex; align-items: center;  gap: 0.4rem;">
                  <a href="ubah-password.php" style="display: flex; gap: 0.5rem; align-items: center;">
                      <img src="../img/password-icon.svg" width="25">
                      <span>Ubah Pasword</span>
                  </a>
              </li>
              <li style="display: flex; align-items: center;  gap: 0.4rem;">
                  <a href="logout.php" style="display: flex; gap: 0.5rem; align-items: center;">
                      <img src="../img/logout.png" width="25">
                      <span>Logout</span>
                  </a>
              </li>
          </ul>
      </div>
  </aside>