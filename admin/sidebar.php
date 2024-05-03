<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>


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

    /* Active style */
    .sidebar-content li.active a {
        background-color: #ccc;
        transition: background-color 0.3s ease;
        /* Smooth transition */
        box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        /* Add box shadow */

    }
</style>



<aside class="sidebar">
    <div class="sidebar-header">
        <img src="../img/logo.png" alt="logo griya jamoe" />
    </div>
    <div class="sidebar-content">
        <ul>
            <li <?php if ($current_page === 'index.php') echo 'class="active"'; ?>>
                <a href="index.php">
                    <img src="../img/dashboards.png" width="25">
                    <span>Dashboard</span>
                </a>
            </li>
            <li <?php if ($current_page === 'kelola-produk.php') echo 'class="active"'; ?>>
                <a href="kelola-produk.php">
                    <img src="../img/products.png" width="25">
                    <span>Kelola Produk</span>
                </a>
            </li>
            <!-- <li <?php if ($current_page === 'kelola-blog.php') echo 'class="active"'; ?>>
                <a href="kelola-artikel.php">
                    <img src="../img/blog-icon.svg" width="25">
                    <span>Kelola Artikel</span>
                </a>
            </li> -->
            <li <?php if ($current_page === 'data-pesanan.php') echo 'class="active"'; ?>>
                <a href="data-pesanan.php">
                    <img src="../img/checkout.png" width="25">
                    <span>Data Pesanan</span>
                </a>
            </li>
            <li <?php if ($current_page === 'data-pelanggan.php') echo 'class="active"'; ?>>
                <a href="data-pelanggan.php">
                    <img src="../img/user.png" width="25">
                    <span>Data Pelanggan</span>
                </a>
            </li>
            <li <?php if ($current_page === 'laporan-transaksi.php') echo 'class="active"'; ?>>
                <a href="laporan-transaksi.php">
                    <img src="../img/transaction-history.png" width="25">
                    <span>Laporan Transaksi</span>
                </a>
            </li>
            <li <?php if ($current_page === 'ubah-password.php') echo 'class="active"'; ?>>
                <a href="ubah-password.php">
                    <img src="../img/password-icon.svg" width="25">
                    <span>Ubah Pasword</span>
                </a>
            </li>
            <li <?php if ($current_page === 'logout.php') echo 'class="active"'; ?>>
                <a href="logout.php" onclick="confirmLogout(event)">
                    <img src="../img/logout.png" width="25">
                    <span>Logout</span>
                </a>
            </li>

            <script>
                function confirmLogout(event) {
                    event.preventDefault(); // Prevent the default link behavior
                    var confirmation = confirm("Apakah Anda ingin logout?");
                    if (confirmation) {
                        window.location.href = "logout.php"; // Redirect to logout.php
                    }
                }
            </script>
        </ul>
    </div>
</aside>