<?php


include 'server/connection.php';

$order_id = $_GET['order_id'];

$result = mysqli_query($conn, "SELECT * FROM order_items  WHERE order_id='$order_id'");


$result_pelanggan = mysqli_query($conn, "SELECT * FROM orders WHERE order_id='$order_id'");
$result_pemesanan = mysqli_query($conn, "SELECT * FROM orders WHERE order_id ='$order_id'");



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota</title>

    <link rel="stylesheet" href="css/default.css">
    <link rel="stylesheet" href="css/produk.css">


    <style>
        /* body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
          
            min-height: 100vh;
            background-color: #f5f5f5;
        } */


        main,
        header {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 80%;
            max-width: 800px;
            margin: 20px;

        }


        h1,
        h2,
        h3 {
            margin-top: 0;
        }

        .row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .note {
            margin-top: 20px;
            font-style: italic;
            background-color: #e6f7ff;
            /* Changed background color */
            border: 1px solid #e6f7ff;
            padding: 10px;
            font-size: 0.8rem;
        }

        .print-button {
            padding: 10px 20px;
            background-color: #0E46A3;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            display: inline-block;
            margin-top: 10px;

        }


        @media print {
            body * {
                visibility: hidden;
            }

            .container,
            .container * {
                visibility: visible;
            }

            .container {
                position: absolute;
                left: 0;
                top: 0;
            }

            .print-button {
                visibility: hidden;
            }
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
                    <?php

                    if (isset($_SESSION['user_id'])) {
                        echo "<li><a href='checkout_history.php'>Riwayat Pemesanan</a></li>";
                    }


                    ?>
                </ul>
            </nav>

        </div>
    </header>
    <!-- header end -->


    <main>

        <div class="container">
            <h1>Nota Pesanan</h1>

            <div class="row">

                <div class="col">
                    <h3>Informasi Pemesanan</h3>
                    <?php while ($row_pemesanan  = mysqli_fetch_assoc($result_pemesanan)) { ?>
                        <p>No pemesanan: <?php echo $row_pemesanan['order_number'] ?></p>
                        <p>Tanggal pemesanan: <?php echo $row_pemesanan['order_date'] ?></p>
                        <p>Status Pembayaran: <?php echo $row_pemesanan['payment_status'] ?></p>
                    <?php } ?>
                </div>

                <div class="col">
                    <h3>Informasi Pelanggan</h3>
                    <?php while ($row_pelanggan  = mysqli_fetch_assoc($result_pelanggan)) { ?>
                        <p>Nama: <?php echo $row_pelanggan['fullname'] ?></p>
                        <p>Nomor Telepon: <?php echo $row_pelanggan['phone_number'] ?></p>
                        <p>Email: <?php echo $row_pelanggan['email'] ?></p>
                    <?php } ?>
                </div>

                <!-- <h2>Alamat Pelanggan</h2> -->
            </div>


            <table>
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Quantity</th>
                        <th>Total yang dibayar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $row['product_name'] ?></td>
                            <td><?php echo $row['quantity'] ?></td>
                            <td>Rp <?php echo number_format($row['total_price'], 0, ',', '.'); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <!-- Print button -->
            <div class="button-container">
                <button class="print-button" onclick="printPage()">Cetak</button>
            </div>

            <div class="note">
                <p>Terimakasih atas pesanan Anda. Pesanan telah diteruskan dan akan divalidasi. Untuk informasi lebih lanjut, silakan hubungi tim support Griya melalui email liefalzzzzzz@gmail.com atau WhatsApp +62812132526 dengan melakukan konfirmasi berdasarkan nomor order.</p>
            </div>
        </div>

    </main>

    <script>
        function printPage() {
            window.print(); // Call the browser's print function
        }
    </script>

</body>

</html>