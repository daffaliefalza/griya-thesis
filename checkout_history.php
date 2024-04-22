<?php

session_start();
include 'server/connection.php';

$user_id = $_SESSION['user_id'];

$result = mysqli_query($conn, "SELECT * FROM orders WHERE id_users= '$user_id'");
$get_username = mysqli_query($conn, "SELECT username from users WHERE id_users='$user_id'");

// $test = mysqli_fetch_assoc($result);

// var_dump($test);

// die();

$username = null;
while ($row = mysqli_fetch_assoc($get_username)) {

    $username = $row['username'];
}


if (!isset($_SESSION['user_id'])) {
    header('location: produk.php');
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pembelian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            max-width: 800px;
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
        }

        .no-history {
            color: #555;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Riwayat Pemesanan <?php echo $username ?></h1>

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

                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <tbody>
                        <tr>
                            <td><?php echo  $no++ ?></td>
                            <td><?php echo $row['order_number'] ?></td>
                            <td><?php echo $row['total_price'] ?></td>
                            <td><?php echo $row['order_date'] ?></td>
                            <td><?php echo $row['status'] ?></td>
                            <td><?php echo $row['payment_status'] ?></td>
                            <td>
                                <a href="payment.php?order_id=<?php echo $row['order_id'] ?>">Selesaikan pembayaran</a>
                            </td>
                        </tr>
                    </tbody>
                <?php } ?>
            </table>
        <?php } else { ?>
            <p class="no-history">Tidak ada riwayat pemesanan.</p>
        <?php } ?>

        <p>jika sudah melakukan pembayaran -> status pembayaran berubah jadi paid (sudah melakukan pembayaran) -> DONE</p>
        <p>jika sudah membayar, Anda akan menerima notifikasi. Admin akan melakukan validasi pembayaran Anda. Mohon ditunggu.</p>
        <p>ADD A NOTA FOR EACH ID</p>
        <p>jika bukti pembayaran tidak valid, status pembayaran akan ditolak dan dana akan hangus.</p>
        <p>add a timer?</p>
        <p>as for the status that are rejected, stops</p>
        <p>FORMATIN DONG KAK</p>
    </div>
</body>

</html>