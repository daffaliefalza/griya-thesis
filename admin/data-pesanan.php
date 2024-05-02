<?php

session_start();

include '../server/connection.php';


$result = mysqli_query($conn, "SELECT * FROM orders ");


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin - Data Pesanan</title>
    <link rel="stylesheet" href="../css/default.css" />
    <link rel="stylesheet" href="../css/admin.css">

    <style>
        .status-button {
            padding: 8px 16px;
            background-color: #28a745;
            /* Green */
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin-right: 5px;
            transition: background-color 0.3s ease;
        }

        .status-button:hover {
            background-color: #218838;
            /* Darker green */
        }

        .payment-button {
            padding: 8px 16px;
            background-color: #10439F;
            /* Red */
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin-right: 5px;
            transition: background-color 0.3s ease;
        }

        .payment-button:hover {
            background-color: #10439F;
            /* Darker red */
        }
    </style>


</head>

<body>
    <div class="wrapper">
        <?php include 'sidebar.php' ?>
        <div class="top-bar">
            <h2>Data Pesanan</h2>

        </div>
        <main class="main-content">

            <table class="content">
                <thead>
                    <th>No</th>
                    <th>Nama Pelanggan</th>
                    <th>Tanggal Pemesanan</th>
                    <th>Status Pesanan</th>
                    <th>Status Pembayaran</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </thead>
                <?php

                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) {

                ?>
                    <tbody>
                        <td><?php echo $no++ ?></td>
                        <td><?php echo $row['fullname'] ?></td>
                        <td><?php echo $row['order_date'] ?></td>
                        <td><?php echo $row['status'] ?></td>
                        <td><?php echo $row['payment_status'] ?></td>
                        <td>Rp. <?php echo number_format($row['total_price']) ?></td>
                        <td>
                            <!-- <a class="status-button">Ubah status pesanan</a> -->



                            <?php if ($row['status'] == 'Dibatalkan') { ?>
                                <p>-</p>
                            <?php } else { ?>
                                <a class="payment-button" href="lihat-bukti.php?order_id=<?php echo $row['order_id']; ?>">Detail</a>
                            <?php } ?>


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