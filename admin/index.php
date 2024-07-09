<?php
session_start();

require('../server/connection.php');

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

// Default year and month
$current_year = date("Y");
$current_month = date("m");

// Handle month selection
if (isset($_GET['month']) && !empty($_GET['month'])) {
    $selected_month = $_GET['month'];
} else {
    $selected_month = $current_month;
}

// Handle year selection
if (isset($_GET['year']) && !empty($_GET['year'])) {
    $selected_year = $_GET['year'];
} else {
    $selected_year = $current_year;
}

$sql = "SELECT * FROM produk";
$result = mysqli_query($conn, $sql);

// Total orders count for the selected month and year
$sql_order = "SELECT COUNT(*) AS total_orders 
              FROM orders 
              WHERE YEAR(order_date) = $selected_year 
              AND MONTH(order_date) = $selected_month";
$result_order = mysqli_query($conn, $sql_order);
$row_order = mysqli_fetch_assoc($result_order);
$total_orders = $row_order['total_orders'];

// Total completed transactions count for the selected month and year
$sql_completed_transactions = "SELECT COUNT(*) AS total_completed_transactions 
                               FROM orders 
                               WHERE status = 'Selesai' 
                               AND payment_status = 'Sudah Dibayar' 
                               AND YEAR(order_date) = $selected_year 
                               AND MONTH(order_date) = $selected_month";
$result_completed_transactions = mysqli_query($conn, $sql_completed_transactions);
$row_completed_transactions = mysqli_fetch_assoc($result_completed_transactions);
$total_completed_transactions = $row_completed_transactions['total_completed_transactions'];

$total_price = 0;

$res = mysqli_query($conn, "SELECT * FROM orders 
                            WHERE status = 'Selesai' 
                            AND payment_status = 'Sudah Dibayar' 
                            AND YEAR(order_date) = $selected_year 
                            AND MONTH(order_date) = $selected_month");

while ($row = mysqli_fetch_assoc($res)) {
    $total_price += $row['total_price'];
}

// Fetch transactions data for the selected month and year
$sql_transactions = "SELECT orders.*, users.fullname 
                     FROM orders 
                     LEFT JOIN users ON orders.id_users = users.id_users
                     WHERE orders.status = 'Selesai' 
                     AND orders.payment_status = 'Sudah Dibayar' 
                     AND YEAR(orders.order_date) = $selected_year
                     AND MONTH(orders.order_date) = $selected_month
                     LIMIT 3";
$result_transactions = mysqli_query($conn, $sql_transactions);

// Fetch sold products data for the selected month and year
$sql_sold_products = "SELECT order_items.product_name, SUM(order_items.quantity) AS quantity, SUM(order_items.total_price) AS total_price
                      FROM order_items
                      INNER JOIN orders ON order_items.order_id = orders.order_id
                      WHERE orders.status = 'Selesai' 
                      AND orders.payment_status = 'Sudah Dibayar' 
                      AND YEAR(orders.order_date) = $selected_year
                      AND MONTH(orders.order_date) = $selected_month
                      GROUP BY order_items.product_name";
$result_sold_products = mysqli_query($conn, $sql_sold_products);

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

        @media (max-width: 908px) {
            .main-content-header {
                display: block;

            }

            .main-content-header div {
                margin: 15px 0;
            }
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
                <div <?php if ($total_orders > 0) echo 'onclick="window.location.href = \'data-pesanan.php\'"'; ?> style="cursor: <?php echo ($total_orders > 0) ? 'pointer' : 'not-allowed'; ?>" class="box-wrapper">
                    <h2 style="color: #fff;">Jumlah data pesanan</h2>
                    <div style="display: flex; align-items: center; justify-content: space-between; background-color: #fff" class="detail-boxes">
                        <p><?php echo $total_orders; ?></p>
                        <p><?php echo ($total_orders > 0) ? 'Lihat detail' : 'Tidak ada pesanan'; ?></p>
                    </div>
                </div>

                <div <?php if ($total_completed_transactions > 0) echo 'onclick="window.location.href = \'laporan-transaksi.php\'"'; ?> style="cursor: <?php echo ($total_completed_transactions > 0) ? 'pointer' : 'not-allowed'; ?>" class="box-wrapper">
                    <h2 style="color: #fff;">Status Transaksi Selesai</h2>
                    <div style="display: flex; align-items: center; justify-content: space-between; background-color: #fff" class="detail-boxes">
                        <p><?php echo $total_completed_transactions ?></p>
                        <p><?php echo ($total_completed_transactions > 0) ? 'Lihat detail' : 'Tidak ada transaksi'; ?></p>
                    </div>
                </div>

                <div class="box-wrapper" style=" background-color: #34495e; padding: 20px; border-radius: 8px; text-align: center;">
                    <h2 style="color: #fff; margin-bottom: 10px;">Total Pendapatan</h2>
                    <div class="detail-boxes">
                        <p style="font-size: 1.2rem; color: #fff; margin: 0; text-decoration: underline;"><strong>Rp. <?php echo number_format($total_price) ?></strong></p>
                    </div>
                </div>

                <!-- Year selection section -->
                <section>
                    <h2>Filter Tahun dan Bulan Penjualan</h2>
                    <select onchange="location = this.value;" style="padding: 8px 12px; border-radius: 4px; border: 1px solid #ccc; font-size: 14px; background-color: #fff; color: #333;">
                        <?php
                        // Get the current year and go 5 years back
                        $start_year = date("Y") - 5;
                        // Loop through years
                        for ($year = $start_year; $year <= $current_year; $year++) {
                        ?>
                            <option value="?year=<?php echo $year; ?>&month=<?php echo $selected_month; ?>" <?php if ($selected_year == $year) echo "selected"; ?>><?php echo $year; ?></option>
                        <?php } ?>
                    </select>

                    <select onchange="location = this.value;" style="padding: 8px 12px; border-radius: 4px; border: 1px solid #ccc; font-size: 14px; background-color: #fff; color: #333;">
                        <?php
                        // Loop through months
                        for ($month = 1; $month <= 12; $month++) {
                            $month_name = date("F", mktime(0, 0, 0, $month, 1));
                        ?>
                            <option value="?year=<?php echo $selected_year; ?>&month=<?php echo $month; ?>" <?php if ($selected_month == $month) echo "selected"; ?>><?php echo $month_name; ?></option>
                        <?php } ?>
                    </select>

                </section>




            </div>
            <?php
            // Check if there are transactions for the selected year
            if (mysqli_num_rows($result_transactions) > 0) {
            ?>
                <h2 style="margin-top: 25px;">Data Transaksi</h2>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pelanggan</th>
                            <th>Tanggal Pemesanan</th>
                            <th>Jumlah</th>
                            <th>Status Pesanan</th>
                            <th>Status Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $transaction_number = 1;
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
                        <?php
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <?php
                            // Display "Lihat Selengkapnya" link if there are completed transactions
                            if ($total_completed_transactions > 0) {
                            ?>
                                <td><a href="laporan-transaksi.php" style="color: #000">Lihat Selengkapnya</a></td>
                            <?php
                            }
                            ?>
                        </tr>
                    </tfoot>
                </table>
            <?php
            } else {
            ?>
                <!-- Display message if no transactions found -->
                <p>Tidak ada riwayat transaksi </p>
            <?php
            }
            ?>

            <!-- New Data Produk Terjual Table -->
            <h2 style="margin-top: 25px;">Data Produk Terjual</h2>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Jumlah Terjual</th>
                        <!-- <th>Harga Satuan</th> -->
                        <th>Total Harga Produk</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $product_number = 1;
                    while ($row = mysqli_fetch_assoc($result_sold_products)) {
                    ?>
                        <tr>
                            <td><?php echo $product_number++; ?></td>
                            <td><?php echo $row['product_name']; ?></td>
                            <td><?php echo $row['quantity']; ?></td>
                            <!-- <td>Rp. <?php echo number_format($row['harga_satuan']); ?></td> -->
                            <td>Rp. <?php echo number_format($row['total_price']); ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </main>
        <footer class="admin-footer">
            Made with &hearts; - Andi Daffa Liefalza
        </footer>
    </div>
</body>

</html>