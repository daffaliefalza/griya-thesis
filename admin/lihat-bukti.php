<?php

include '../server/connection.php';

$order_id = $_GET['order_id'];

echo $order_id;

$result = mysqli_query($conn, "SELECT * FROM payment WHERE order_id='$order_id'");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat bukti pembayaran</title>
</head>

<body>

    <h1>Lihat bukti pembayaran</h1>

    <?php
    while ($row = mysqli_fetch_assoc($result)) {

    ?>
        <p><?php $row['payer_name'] ?></p>
        <p><?php $row['total_payment'] ?></p>
        <p><?php $row['payment_date'] ?></p>

        <img src="../<?php echo $row['payment_proof'] ?>" alt="">

    <?php } ?>

</body>

</html>