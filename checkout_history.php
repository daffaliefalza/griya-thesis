<?php
session_start();
include 'server/connection.php';

$user_id = $_SESSION['user_id'];

$result = mysqli_query($conn, "SELECT * FROM orders WHERE id_users= '$user_id'");
$get_username = mysqli_query($conn, "SELECT username from users WHERE id_users='$user_id'");

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
    <link rel="stylesheet" href="css/default.css">
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
                $current_time = time();
                $expiry_time = 24 * 60 * 60; // 24 hours in seconds

                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    $order_timestamp = strtotime($row['order_date']);
                    $payment_expiry = $order_timestamp + $expiry_time; // Calculate payment expiry from order date
                    $time_difference = $payment_expiry - $current_time;

                    // If payment is due within the next 24 hours, display the deadline
                    if ($time_difference > 0) {
                        $payment_deadline = date('d F Y H:i:s', $payment_expiry);
                        $payment_notification = "<p>Bayar sebelum: $payment_deadline</p>";
                    } else {
                        $payment_notification = "<a class='disabled-text' disabled>* Pesanan dibatalkan karena bukti tidak valid atau melebihi batas waktu yang ditentukan</a>";
                        // Update the status to rejected if payment deadline has passed and payment status is unpaid
                        if ($row['payment_status'] == 'unpaid') {
                            $order_id = $row['order_id'];
                            mysqli_query($conn, "UPDATE orders SET status = 'rejected' WHERE order_id = '$order_id'");
                        }
                    }

                ?>
                    <tbody>
                        <tr>
                            <td><?php echo  $no++ ?></td>
                            <td><?php echo $row['order_number'] ?></td>
                            <td>Rp <?php echo number_format($row['total_price'], 0, ',', '.'); ?></td>
                            <td><?php echo date('d F Y H:i:s', strtotime($row['order_date'])); ?></td>
                            <td><?php echo $row['status'] ?></td>
                            <td><?php echo $row['payment_status'] ?></td>
                            <td>
                                <?php if ($row['status'] == 'rejected') { ?>
                                    <a class="disabled-text" disabled>* Pesanan dibatalkan karena bukti tidak valid atau melebihi batas waktu yang ditentukan</a>
                                <?php } ?>

                                <?php if ($row['payment_status'] == 'unpaid' && $row['status'] != 'rejected') { ?>
                                    <a class="button-link" href="payment.php?order_id=<?php echo $row['order_id'] ?>">Selesaikan pembayaran</a>
                                    <?php echo $payment_notification; ?>
                                <?php } ?>

                                <?php if ($row['payment_status'] == 'paid') { ?>
                                    <a class="button-link-invoice" href="nota.php?order_id=<?php echo $row['order_id'] ?>">Lihat Nota </a>
                                <?php } ?>
                            </td>
                        </tr>
                    </tbody>
                <?php } ?>
            </table>
        <?php } else { ?>
            <p class="no-history">Tidak ada riwayat pemesanan.</p>
        <?php } ?>

        <p>
            <strong>Untuk informasi lebih lanjut, silakan hubungi tim support Griya via e-mail liefalzzzzzz@gmail.com atau whatsapp +62812132526 dengan melakukan konfirmasi berdasarkan nomor order.</strong>
        </p>

        <p>add a timer? if the timer is expired, automatically the status is rejected / batal (done)</p>
        <p>Rubah status paid unpaid, rejected processed etc</p>
    </div>
</body>

</html>