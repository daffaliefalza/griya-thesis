<?php
session_start();

require('../server/connection.php');

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

$sql = "SELECT * FROM produk";
$result = mysqli_query($conn, $sql);

// Fetch the count of orders
$sql_order = "SELECT COUNT(*) AS total_orders FROM orders";
$result_order = mysqli_query($conn, $sql_order);
$row_order = mysqli_fetch_assoc($result_order);
$total_orders = $row_order['total_orders'];

// Fetch the count of customer
$sql_customer = "SELECT COUNT(*) AS total_customer FROM users";
$result_customer = mysqli_query($conn, $sql_customer);
$row_customer = mysqli_fetch_assoc($result_customer);
$total_customer = $row_customer['total_customer'];

// Fetch the count of transaction done
$sql_transaction = "SELECT COUNT(*) AS total_transaction FROM orders WHERE status = 'done' AND payment_status = 'paid'";
$result_transaction = mysqli_query($conn, $sql_transaction);
$row_transaction = mysqli_fetch_assoc($result_transaction);
$total_transaction = $row_transaction['total_transaction'];

$total_price = 0;

$res = mysqli_query($conn, "SELECT * FROM orders WHERE status = 'done' AND payment_status = 'paid'");

while ($row = mysqli_fetch_assoc($res)) {
    $total_price += $row['total_price'];
}

// Pagination
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 3;
$start = ($page - 1) * $limit;

// Fetch transaction data with pagination
$sql_transactions = "SELECT * FROM orders WHERE status = 'done' AND payment_status = 'paid' LIMIT $start, $limit";
$result_transactions = mysqli_query($conn, $sql_transactions);

// Count total number of transactions
$sql_count = "SELECT COUNT(*) AS total FROM orders WHERE status = 'done' AND payment_status = 'paid'";
$result_count = mysqli_query($conn, $sql_count);
$row_count = mysqli_fetch_assoc($result_count);
$total_records = $row_count['total'];

// Calculate total number of pages
$total_pages = ceil($total_records / $limit);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/default.css" />
    <link rel="stylesheet" href="../css/admin.css">

    <style>
        body {
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        /* 
        .wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        } */







        .main-content-header {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 20px;
        }

        .main-content-header div {
            flex: 1;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }




        .main-content-header div:nth-child(1),
        .main-content-header div:nth-child(2),
        .main-content-header div:nth-child(3) {
            flex-basis: calc(33.33% - 20px);
            background-color: #34495e;
            color: black;
        }



        .main-content-header div h2 {
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 1.4rem;
        }

        .main-content-header div p {
            margin-top: 0;
            margin-bottom: 5px;
            font-size: 1rem;
        }

        .main-content-header div:nth-child(4) {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .main-content-header div:nth-child(4) h2 {
            margin: 0;
        }

        .main-content-header div:nth-child(4) p {
            margin: 0;
        }

        /* CSS for table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: blue;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        table thead {
            background-color: #0c3366;
            color: #fff;
        }

        table th,
        table td {
            padding: 12px;
            border-bottom: 1px solid blue;
            text-align: left;
        }

        table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Hover effect for table rows */
        table tbody tr:hover {
            background-color: #f2f2f2;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        table thead {
            background-color: #34495e;
        }

        table th,
        table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        table tbody tr:last-child td {
            border-bottom: none;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        .pagination a {
            padding: 10px 15px;
            background-color: #34495e;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
            margin: 0 5px;
            text-decoration: none;
        }

        .pagination a.active {
            background-color: #0c3366;
        }

        .pagination a:hover {
            background-color: #0c3366;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <?php include 'sidebar.php' ?>
        <div class="top-bar">
            <h2>Dashboard</h2>
            <div class="top-bar-links">
                <h3>Halo, <span style="color: #9f9f9f">Admin</span></h3>
            </div>
        </div>
        <main class="main-content">
            <div class="main-content-header">
                <div onclick="window.location.href = 'data-pesanan.php'" style="cursor: pointer;" class="box-wrapper">
                    <h2 style="color: #fff;">Jumlah data pesanan</h2>
                    <div style="display: flex; align-items: center; justify-content: space-between; background-color: #fff" class="detail-boxes">
                        <p><?php echo $total_orders; ?></p>
                        <p>Lihat detail</p>
                    </div>
                </div>
                <div onclick="window.location.href = 'data-pelanggan.php'" style="cursor: pointer;" class="box-wrapper">
                    <h2 style="color: #fff;">Jumlah data pelanggan</h2>
                    <div style="display: flex; align-items: center; justify-content: space-between; background-color: #fff" class="detail-boxes">

                        <p><?php echo $total_customer ?></p>
                        <p>Lihat detail</p>
                    </div>
                </div>
                <div onclick="window.location.href = 'laporan-transaksi.php'" style="cursor: pointer;" class="box-wrapper">
                    <h2 style="color: #fff;">Status transaksi selesai</h2>
                    <div style="display: flex; align-items: center; justify-content: space-between; background-color: #fff" class="detail-boxes">
                        <p><?php echo $total_transaction ?></p>
                        <p>Lihat detail</p>
                    </div>
                </div>
                <!-- <div style="display: flex; align-items: center; justify-content: space-between; background-color: #fff">
                    <h2>Total Pendapatan</h2>
                    <p><strong>Rp. <?php echo number_format($total_price) ?></strong></p>
                </div> -->
            </div>
            <table>
                <h2>Data Transaksi</h2>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pelanggan</th>
                        <th>Tanggal Pemesanan</th>
                        <th>Jumlah</th>
                        <th>Status Pesanan</th>
                        <th>Status Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $transaction_number = ($page - 1) * $limit + 1;
                    while ($row = mysqli_fetch_assoc($result_transactions)) {
                    ?>
                        <tr>
                            <td><?php echo $transaction_number++; ?></td>
                            <td><?php echo $row['fullname']; ?></td>
                            <td><?php echo $row['order_date']; ?></td>
                            <td>Rp. <?php echo number_format($row['total_price']); ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td><?php echo $row['payment_status']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <!-- Pagination links -->
            <div class="pagination">
                <?php if ($page > 1) : ?>
                    <a href="index.php?page=<?php echo ($page - 1); ?>">Previous</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                    <a href="index.php?page=<?php echo $i; ?>" <?php echo ($i == $page) ? 'class="active"' : ''; ?>><?php echo $i; ?></a>
                <?php endfor; ?>

                <?php if ($page < $total_pages) : ?>
                    <a href="index.php?page=<?php echo ($page + 1); ?>">Next</a>
                <?php endif; ?>
            </div>
        </main>
        <footer class="admin-footer">
            Made with &hearts; - Andi Daffa Liefalza
        </footer>
    </div>
</body>

</html>