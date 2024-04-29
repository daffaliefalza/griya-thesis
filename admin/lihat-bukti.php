<?php

include '../server/connection.php';


$order_id = $_GET['order_id'];

$result_payment = mysqli_query($conn, "SELECT * FROM payment WHERE order_id='$order_id'");
$result_order = mysqli_query($conn, "SELECT * FROM order_items  WHERE order_id='$order_id'");
$result_pelanggan = mysqli_query($conn, "SELECT * FROM orders WHERE order_id='$order_id'");
$result_pemesanan = mysqli_query($conn, "SELECT * FROM orders WHERE order_id ='$order_id'");
$result_trigger = mysqli_query($conn, "SELECT * FROM orders WHERE order_id ='$order_id'");
$result_pengiriman = mysqli_query($conn, "SELECT * FROM orders WHERE order_id='$order_id'");
$result_ongkir = mysqli_query($conn, "SELECT shipping FROM orders WHERE order_id='$order_id'");
$result_total_harga = mysqli_query($conn, "SELECT total_price FROM orders WHERE order_id='$order_id'");

$disable_proses_button = false;

while ($row_order = mysqli_fetch_assoc($result_trigger)) {
    if ($row_order['status'] == 'done') {
        $disable_proses_button = true;
    }
}




if (isset($_POST['proses'])) {
    $status = $_POST['status'];

    // Update the order status
    mysqli_query($conn, "UPDATE orders SET status = '$status' WHERE order_id='$order_id'");

    // Decrease the product stock if the status is processed
    if ($status == 'processed') {
        // Retrieve order details
        $order_query = mysqli_query($conn, "SELECT product_name, quantity FROM order_items WHERE order_id='$order_id'");
        while ($row = mysqli_fetch_assoc($order_query)) {
            $product_name = $row['product_name'];
            $quantity = $row['quantity'];

            // Retrieve the product ID based on the product name
            $product_query = mysqli_query($conn, "SELECT id_produk FROM produk WHERE nama_produk='$product_name'");
            $product_row = mysqli_fetch_assoc($product_query);
            $product_id = $product_row['id_produk'];

            // Update product stock
            mysqli_query($conn, "UPDATE produk SET stok = stok - $quantity WHERE id_produk='$product_id'");
        }
    }

    echo "<script>
    alert('status pesanan diubah');
    window.location.href = 'data-pesanan.php';
    </script>";
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Bukti Pembayaran</title>
    <link rel="stylesheet" href="../css/default.css" />

    <style>
        body {
            line-height: 1.6 !important;
        }

        main {
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
            max-width: 1000px;
        }

        h1,
        h2,
        h3 {
            margin-top: 0;
            color: #333;
        }

        .row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }



        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            font-size: 14px;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .payment-details {
            margin-top: 20px;
        }

        .payment-details p {
            margin: 5px 0;
            color: #555;
        }

        .payment-details img {
            width: 500px;
            margin-top: 10px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        .btn {
            background-color: #3498db;
            /* New button background color */
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #2980b9;
            /* New button hover background color */
        }

        /* Additional styling for disabled button */
        .btn[disabled] {
            opacity: 0.6;
            /* Reduce opacity to indicate disabled state */
            cursor: not-allowed;
            /* Change cursor to indicate not clickable */
        }
    </style>

</head>

<body>
    <main>
        <div class="container">
            <h1>Detail Pemesanan</h1>
            <div class="row">
                <div class="col">
                    <h3>Informasi Pemesanan</h3>
                    <?php while ($row_pemesanan  = mysqli_fetch_assoc($result_pemesanan)) { ?>
                        <p>No Pemesanan: <?php echo $row_pemesanan['order_number'] ?></p>
                        <p>Tanggal Pemesanan: <?php echo $row_pemesanan['order_date'] ?></p>
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

                <div class="col">
                    <h3>Alamat Pengiriman</h3>
                    <?php while ($row_pengiriman = mysqli_fetch_assoc($result_pengiriman)) { ?>
                        <p>Provinsi: <?php echo $row_pengiriman['province'] ?></p>
                        <p>Distrik: <?php echo $row_pengiriman['district'] ?></p>
                        <p>Alamat Lengkap: <?php echo $row_pengiriman['detail_address'] ?></p>
                        <p style="border-bottom: 2px solid #aaa;">Kode Pos: <?php echo $row_pengiriman['postal_code']  ?></p>

                        <p><strong>Ongkos Kirim: Rp. <?php echo number_format($row_pengiriman['shipping']) ?></strong></p>
                    <?php } ?>
                </div>


            </div>

            <!-- Tabel Detail Pemesanan -->
            <table>
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Quantity</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_amount = 0; // Initialize total amount
                    while ($row_produk = mysqli_fetch_assoc($result_order)) {

                    ?>
                        <tr>
                            <td><?php echo $row_produk['product_name'] ?></td>
                            <td><?php echo $row_produk['quantity'] ?></td>
                            <td>Rp <?php echo number_format($row_produk['total_price'], 0, ',', '.'); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
                <tfoot>

                    <tr>
                        <td colspan="2" style="text-align: right;"><strong>Ongkos Kirim</strong></td>
                        <?php while ($row_ongkir = mysqli_fetch_assoc($result_ongkir)) { ?>
                            <td colspan="2"><strong>Rp <?php echo number_format($row_ongkir['shipping'], 0, ',', '.'); ?></strong></td>
                        <?php } ?>
                    </tr>
                    <?php


                    ?>
                    <tr>
                        <td colspan="2" style="text-align: right;"><strong>Total yang harus dibayar customer:</strong></td>
                        <?php while ($row_total = mysqli_fetch_assoc($result_total_harga)) { ?>
                            <td><strong>Rp <?php echo number_format($row_total['total_price'], 0, ',', '.'); ?></strong></td>
                        <?php } ?>
                    </tr>
                </tfoot>
            </table>

            <div class="payment-details">
                <?php while ($row = mysqli_fetch_assoc($result_payment)) { ?>
                    <p>Nama Pembayar: <?php echo $row['payer_name'] ?></p>
                    <p>Total Pembayaran: Rp. <?php echo number_format($row['total_payment']) ?></p>
                    <p>Tanggal Pembayaran: <?php echo $row['payment_date'] ?></p>
                    <h2>Bukti Transfer</h2>
                    <img src="../<?php echo $row['payment_proof'] ?>" alt="Bukti Pembayaran">
                <?php } ?>

                <form action="" method="post">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option selected disabled>Pilih Status</option>
                            <option value="rejected">Rejected</option>
                            <option value="processed">Processed</option>
                            <option value="delivered">Delivered</option>
                            <option value="done">Done</option>
                        </select>
                    </div>
                    <?php if (!$disable_proses_button) { ?>
                        <button class="btn" name="proses">Proses</button>
                    <?php } else { ?>
                        <button class="btn" name="proses" disabled>Proses</button>
                    <?php } ?>
                </form>
            </div>
        </div>
    </main>
</body>

</html>