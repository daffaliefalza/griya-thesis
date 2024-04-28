<?php

include '../server/connection.php';

$order_id = $_GET['order_id'];

echo $order_id;

$result = mysqli_query($conn, "SELECT * FROM payment WHERE order_id='$order_id'");

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

    <br>
    <br>
    <br>
    <form action="" method="post">

        <div class="form-group">
            <label for="">Status</label>
            <select name="status" id="" class="form-control">
                <option selected disabled>Pilih Status</option>
                <option value=" rejected">rejected</option>
                <option value="processed">processed</option>
                <option value="delivered">delivered</option>
                <option value="done">done</option>
            </select>
        </div>
        <button class="btn btn-success" name="proses">Proses</button>
    </form>


</body>

</html>