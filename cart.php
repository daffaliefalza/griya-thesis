<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require('server/connection.php');

if (isset($_POST['update_update_btn'])) {
    $update_value = $_POST['update_quantity'];
    $update_id = $_POST['update_quantity_id'];
    $update_quantity_query = mysqli_query($conn, "UPDATE `cart` SET quantity = '$update_value' WHERE id = '$update_id'");
    if ($update_quantity_query) {
        header('location:cart.php');
    };
};

if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$remove_id'");
    header('location:cart.php');
};

if (isset($_GET['delete_all'])) {
    mysqli_query($conn, "DELETE FROM `cart`");
    header('location:cart.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>

    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="css/default.css">
    <link rel="stylesheet" href="css/cart.css">

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>

<body>

    <div class="container">
        <section class="shopping-cart" style="overflow-x: auto;">
            <h1 class="heading">Keranjang Belanja</h1>

            <?php
            $user_id = $_SESSION['user_id'];

            $select_cart = mysqli_query($conn, "SELECT id, product_name, price, image, quantity FROM `cart` WHERE id_users = '$user_id'");

            $grand_total = 0;
            if (mysqli_num_rows($select_cart) > 0) {
            ?>
                <table>
                    <thead>
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Quantity</th>
                        <th>Total Harga</th>
                        <th>Aksi</th>
                    </thead>

                    <tbody>
                        <?php
                        while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                            // Format price
                            $harga_formatted = 'Rp ' . number_format($fetch_cart['price'], 0, ',', '.');
                            $sub_total = $fetch_cart['price'] * $fetch_cart['quantity'];
                            $sub_total_formatted = 'Rp ' . number_format($sub_total, 0, ',', '.');
                        ?>
                            <tr>
                                <td><img src="img/<?php echo $fetch_cart['image'] ?>" height="100" alt=""></td>
                                <td><?php echo $fetch_cart['product_name']; ?></td>
                                <td><?php echo $harga_formatted; ?></td>
                                <td>
                                    <form action="" method="post">
                                        <input type="hidden" name="update_quantity_id" value="<?php echo $fetch_cart['id']; ?>">
                                        <input type="number" name="update_quantity" min="1" value="<?php echo $fetch_cart['quantity']; ?>">
                                        <input type="submit" value="Update" name="update_update_btn">
                                    </form>
                                </td>
                                <td><?php echo $sub_total_formatted; ?>/-</td>
                                <td><a href="cart.php?remove=<?php echo $fetch_cart['id']; ?>" onclick="return confirm('Remove item from cart?')" class="delete-btn"> <i class="fas fa-trash"></i> Remove</a></td>
                            </tr>
                        <?php
                            $grand_total += $sub_total;
                        }
                        ?>
                        <tr class="table-bottom">
                            <td><a href="produk.php" class="option-btn" style="margin-top: 0;">Lanjut belanja</a></td>
                            <td colspan="3">Grand Total</td>
                            <td><?php echo 'Rp ' . number_format($grand_total, 0, ',', '.'); ?>/-</td>
                            <td><a href="cart.php?delete_all" onclick="return confirm('Are you sure you want to delete all?');" class="delete-btn"> <i class="fas fa-trash"></i> Delete All</a></td>
                        </tr>
                    </tbody>
                </table>

                <div class="checkout-btn">
                    <a href="<?php echo ($grand_total > 1) ? 'checkout.php' : '#'; ?>" class="btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>">Lanjutkan ke form pemesanan
                    </a>
                </div>

            <?php } else { ?>
                <p>Keranjang belanja Anda kosong. <a href="produk.php">Mulai berbelanja sekarang!</a></p>
            <?php } ?>

        </section>
    </div>

</body>

</html>