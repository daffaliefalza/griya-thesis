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
    <title>Invoice</title>
</head>

<body>

    <h1>Invoice</h1>


    <div>
        <h3>Informasi Pemesanan</h3>
        <?php while ($row_pemesanan  = mysqli_fetch_assoc($result_pemesanan)) { ?>
            <p>No pemesanan:<?php echo $row_pemesanan['order_number'] ?></p>
            <p>Tanggal pemesanan:<?php echo $row_pemesanan['order_date'] ?></p>

        <?php } ?>
    </div>



    <div>
        <h3>Informasi Pelanggan</h3>
        <?php while ($row_pelanggan  = mysqli_fetch_assoc($result_pelanggan)) { ?>
            <p><?php echo $row_pelanggan['fullname'] ?></p>
            <p><?php echo $row_pelanggan['phone_number'] ?></p>
            <p><?php echo $row_pelanggan['email'] ?></p>

        <?php } ?>
    </div>


    <table>
        <thead>
            <th>Nama Produk</th>
            <th>Quantity</th>
            <th>Total yang dibayar</th>
        </thead>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tbody>
                <td><?php echo $row['product_name'] ?></td>
                <td><?php echo $row['quantity'] ?></td>
                <td>Rp <?php echo number_format($row['total_price'], 0, ',', '.'); ?></td>
            </tbody>

        <?php } ?>
    </table>


    <div>
        <h2>Terimakasih atas pesanan anda, pesanan telah diteruskan dan akan di validasi, Untuk informasi lebih lanjut, silakan hubungi tim support Griya via e-mail liefalzzzzzz@gmail.com atau whatsapp +62812132526 dengan melakukan konfirmasi berdasarkan nomor order.</h2>

    </div>

</body>

</html>

<p>
    <strong></strong>
</p>