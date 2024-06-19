<?php
session_start();

include '../server/connection.php';

// inisialisasi awal
$result = null;
$_SESSION['total_price_transaksi'] = 0;
$message = "";

// cek form udah di submit apa belom
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];

    // Construct query with date filtering
    $query = "SELECT orders.*, users.fullname, GROUP_CONCAT(order_items.product_name SEPARATOR ',') AS product_names, SUM(order_items.quantity) AS total_quantity
          FROM orders 
          INNER JOIN users ON orders.id_users = users.id_users 
          INNER JOIN order_items ON orders.order_id = order_items.order_id
          WHERE order_date BETWEEN '$startDate' AND '$endDate' 
          AND status = 'Selesai' AND payment_status = 'Sudah Dibayar'
          GROUP BY orders.order_id";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 0) {
        $message = "Tidak ada riwayat transaksi. Saran: filter tanggal dari 01/01/2024 - 12/30/2024.";
    } else {
        while ($row = mysqli_fetch_assoc($result)) {
            $_SESSION['total_price_transaksi'] += $row['total_price'];
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin - Laporan Transaksi</title>
    <link rel="stylesheet" href="../css/default.css" />
    <link rel="stylesheet" href="../css/admin.css">

    <style>
        form {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        input[type="date"],
        button {
            padding: 10px 20px;
            margin-right: 10px;
            border: none;
            border-radius: 4px;
            background-color: #008CBA;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="date"]:focus,
        button:hover {
            background-color: #005f7b;
            outline: none;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }


        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
        }

        tfoot {
            font-weight: bold;
        }



        .export-button {
            padding: 10px 20px;
            border-radius: 4px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .export-button:hover {
            background-color: #45a049;
        }


        @media (max-width: 768px) {
            .main-content form {
                padding: 1rem;
            }

            .main-content form input,
            .main-content form a {
                margin-top: 10px !important;
            }
        }
    </style>

</head>

<body>
    <div class="wrapper">
        <?php include 'sidebar.php' ?>
        <div class="top-bar">
            <h2>Data Transaksi</h2>
        </div>
        <main class="main-content">
            <h3>Filter data transaksi dari tanggal mulai - tanggal berakhir</h3>
            <p style="font-style: italic;">Contoh filter tanggal dari 01/01/2024 - 12/30/2024.</p>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="start_date">Tanggal Mulai:</label>
                <input type="date" id="start_date" name="start_date">
                <label for="end_date">Tanggal Berakhir:</label>
                <input type="date" id="end_date" name="end_date">
                <button type="submit" id="search_button" disabled>Cari</button>
                <!-- Export button -->
                <?php if ($result) : ?>
                    <a style="margin-top: 10px; display: inline-block" href="export_data.php?start_date=<?php echo $startDate ?>&end_date=<?php echo $endDate ?>" class="export-button">Export Data</a>
                <?php endif; ?>
            </form>
            <br>
            <?php if ($result) : ?>
                <table border="1">
                    <thead>
                        <th>No</th>
                        <th>Pelanggan</th>
                        <th>Tanggal Pemesanan</th>
                        <th>Produk yang Dipesan</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Status Pesanan</th>
                        <th>Status Pembayaran</th>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        mysqli_data_seek($result, 0);
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $row['fullname'] ?></td>
                                <td><?php echo $row['order_date'] ?></td>
                                <td><?php echo $row['product_names'] ?></td>
                                <td><?php echo $row['total_quantity'] ?></td>
                                <td style="padding: 1rem;">Rp. <?php echo number_format($row['total_price']) ?></td>
                                <td><?php echo $row['status'] ?></td>
                                <td><?php echo $row['payment_status'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4">Total</th>
                            <td><strong>Rp. <?php echo number_format($_SESSION['total_price_transaksi']) ?></strong></td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                </table>
            <?php endif; ?>

            <?php if (!empty($message)) : ?>
                <div class="message"><?php echo $message; ?></div>
            <?php endif; ?>

        </main>
        <footer class="admin-footer">
            Made with &hearts; - Andi Daffa Liefalza
        </footer>
    </div>

    <script>
        function checkDates() {
            var startDate = document.getElementById('start_date');
            var endDate = document.getElementById('end_date');

            var searchButton = document.getElementById('search_button');

            if (startDate.value !== '' && endDate.value !== '') {
                searchButton.disabled = false;
            } else {
                searchButton.disabled = true;
            }
        }

        document.getElementById('start_date').addEventListener('change', checkDates);
        document.getElementById('end_date').addEventListener('change', checkDates);
    </script>
</body>

</html>