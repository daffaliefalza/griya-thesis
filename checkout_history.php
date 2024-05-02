<?php
session_start();
include 'server/connection.php';

$user_id = $_SESSION['user_id'];

// Retrieve username
$get_username = mysqli_query($conn, "SELECT fullname from users WHERE id_users='$user_id'");
$fullname = null;
while ($row = mysqli_fetch_assoc($get_username)) {
    $fullname = $row['fullname'];
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('location: produk.php');
}

// Get orders for the user
$result = mysqli_query($conn, "SELECT * FROM orders WHERE id_users= '$user_id'");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pembelian</title>
    <link rel="stylesheet" href="css/default.css">
    <link rel="stylesheet" href="css/produk.css">
    <style>
        body {
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            max-width: 1100px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f0f0f0;
        }

        tbody tr:hover {
            background-color: #f9f9f9;
        }

        p {
            margin-bottom: 10px;
            color: #555;
            text-align: justify;
        }

        .no-history {
            color: #555;
            text-align: center;
        }

        .button-link {
            display: inline-block;
            padding: 8px 15px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .button-link-invoice {
            display: inline-block;
            padding: 8px 15px;
            background-color: green !important;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .button-link:hover {
            background-color: #0056b3;
        }

        .disabled-text {
            color: #bbb;
            font-style: italic;
            text-decoration: none;
            pointer-events: none;
            cursor: default;
        }
    </style>
</head>

<body>

    <!-- header start -->
    <header>
        <div class="container">
            <a href="index.php">
                <img src="./img/logo.png" alt="Logo Griya" />
            </a>
            <nav>
                <ul>
                    <li><a href="index.php">Beranda</a></li>
                    <li><a href="index.php#tentang-kami">Tentang-kami</a></li>
                    <li><a href="produk.php">Produk</a></li>
                    <li><a href="artikel.php">Artikel</a></li>

                </ul>
            </nav>

        </div>
    </header>
    <!-- header end -->

    <div class="container">
        <h1>Riwayat Pemesanan <?php echo $fullname ?></h1>

        <?php if (mysqli_num_rows($result) > 0) { ?>
            <table>
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>Nomor Pemesanan</th>
                        <th>Total harga pemesanan</th>
                        <th>Tanggal pemesanan</th>
                        <th>Status Pesanan</th>
                        <th>Status Pembayaran</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <?php $no = 1; ?>
                <?php while ($row = mysqli_fetch_assoc($result)) {

                ?>
                    <tbody>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $row['order_number']; ?></td>
                            <td>Rp <?php echo number_format($row['total_price'], 0, ',', '.'); ?></td>
                            <td><?php echo date('d F Y H:i:s', strtotime($row['order_date'])); ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td><?php echo $row['payment_status']; ?></td>
                            <td>

                                <?php
                                if ($row['status'] == 'rejected') {
                                    echo '<a class="disabled-text" disabled>* Pesanan dibatalkan karena bukti tidak valid</a>';
                                } elseif ($row['payment_status'] == 'Menunggu Pembayaran' && $row['status'] != 'rejected') {
                                    echo '<a class="button-link" href="payment.php?order_id=' . $row['order_id'] . '">Selesaikan pembayaran</a>';
                                } elseif ($row['payment_status'] == 'Sudah Dibayar') {
                                    echo '<a class="button-link-invoice" href="nota.php?order_id=' . $row['order_id'] . '">Lihat Nota</a>';
                                }
                                ?>

                            </td>
                        </tr>
                    </tbody>
                <?php } ?>
            </table>
        <?php } else { ?>
            <!-- Display message if no orders found -->
            <p class="no-history">Tidak ada riwayat pemesanan.</p>
        <?php } ?>



    </div>
</body>

</html>