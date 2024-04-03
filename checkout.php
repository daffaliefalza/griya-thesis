<?php

// Include Midtrans PHP Library
require_once dirname(__FILE__) . '/midtrans/midtrans-php-master/Midtrans.php';

// Set your Midtrans API credentials
\Midtrans\Config::$serverKey = 'SB-Mid-server-n48WqIvtn-de3JRWJW19DXY6';
\Midtrans\Config::$isProduction = false; // Set to true for production environment

// Include necessary files
include './server/connection.php'; // Include your database configuration

// Start the session
session_start();


// Handle form submission
if (isset($_POST['order_btn'])) {
    // Check if all required fields are filled
    if (empty($_POST['name']) || empty($_POST['number']) || empty($_POST['email'])  || empty($_POST['flat']) || empty($_POST['street']) || empty($_POST['city']) || empty($_POST['state']) || empty($_POST['country']) || empty($_POST['pin_code'])) {
        echo "<div class='display-order'><span>Please fill all required fields!</span></div>";
        exit;
    }

    // Collect order details
    $name = $_POST['name'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $flat = $_POST['flat'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $pin_code = $_POST['pin_code'];

    // Fetch cart items
    $select_cart = mysqli_query($conn, "SELECT * FROM `cart`");
    $total = 0;
    $grand_total = 0;
    $items = array(); // Initialize array for items
    if (mysqli_num_rows($select_cart) > 0) {
        while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
            $total_price = $fetch_cart['price'] * $fetch_cart['quantity'];
            $grand_total += $total_price;
            // Add item to items array
            $items[] = array(
                'id' => $fetch_cart['id'],
                'price' => $fetch_cart['price'],
                'quantity' => $fetch_cart['quantity'],
                'name' => $fetch_cart['name'],
            );
        }
    } else {
        echo "<div class='display-order'><span>Your cart is empty!</span></div>";
        exit;
    }

    // Prepare transaction details
    $transaction_details = array(
        'order_id' => uniqid(), // Generate a unique order ID
        'gross_amount' => $grand_total, // Set the total order amount
    );

    // Prepare customer details
    $customer_details = array(
        'first_name' => $name,
        'email' => $email,
        'phone' => $number,
        'billing_address' => array(
            'first_name' => $name,
            'email' => $email,
            'phone' => $number,
            'address' => $flat . ', ' . $street . ', ' . $city . ', ' . $state . ', ' . $country . ', ' . $pin_code,
            'city' => $city,
            'postal_code' => $pin_code,
            'country_code' => 'IDN', // Assuming Indonesia, change it accordingly
        ),
        'shipping_address' => array(
            'first_name' => $name, // Assuming shipping address same as billing
            'email' => $email,
            'phone' => $number,
            'address' => $flat . ', ' . $street . ', ' . $city . ', ' . $state . ', ' . $country . ', ' . $pin_code,
            'city' => $city,
            'postal_code' => $pin_code,
            'country_code' => 'IDN', // Assuming Indonesia, change it accordingly
        ),
    );

    // Prepare items details
    $item_details = array();
    foreach ($items as $item) {
        $item_details[] = array(
            'id' => $item['id'],
            'name' => $item['name'],
            'price' => $item['price'],
            'quantity' => $item['quantity'],
        );
    }
    // Prepare Snap Token
    try {
        $params = array(
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
            'item_details' => $item_details,
        );

        // Get Snap Token
        $snapToken = \Midtrans\Snap::getSnapToken($params);

        // Pass the Snap Token to the frontend JavaScript
        echo "<script>var snapToken = '{$snapToken}';</script>";

        // Storing form data in session variables
        $_SESSION['name'] = $name;
        $_SESSION['number'] = $number;
        $_SESSION['email'] = $email;
        $_SESSION['flat'] = $flat;
        $_SESSION['street'] = $street;
        $_SESSION['city'] = $city;
        $_SESSION['state'] = $state;
        $_SESSION['country'] = $country;
        $_SESSION['pin_code'] = $pin_code;
        $_SESSION['items'] = $items;


        // Redirect to checkout_detail.php
        header('Location: checkout_detail.php?snapToken=' . urlencode($snapToken));
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>checkout</title>

    <link rel="stylesheet" href="css/default.css">
    <link rel="stylesheet" href="css/checkouts.css">


</head>

<body>

    <div class=" container">

        <section class="checkout-form">

            <h1 class="heading">Isi formulir pemesanan</h1>

            <form action="" method="post">

                <div class="display-order">
                    <?php
                    $select_cart = mysqli_query($conn, "SELECT * FROM `cart`");
                    $total = 0;
                    $grand_total = 0;
                    if (mysqli_num_rows($select_cart) > 0) {
                        while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                            $total_price = $fetch_cart['price'] * $fetch_cart['quantity'];
                            $grand_total = $total += $total_price;
                    ?>
                            <span><?= $fetch_cart['name']; ?>(<?= $fetch_cart['quantity']; ?>)</span>
                    <?php
                        }
                    } else {
                        echo "<div class='display-order'><span>your cart is empty!</span></div>";
                    }
                    ?>
                    <span class="grand-total"> grand total : Rp <?= number_format($grand_total, 0, ',', '.'); ?>,- </span>

                </div>

                <div class="flex">
                    <div class="inputBox">
                        <span>Nama Lengkap</span>
                        <input type="text" placeholder="Masukkan Nama Lengkap.." name="name" required>
                    </div>
                    <div class="inputBox">
                        <span>No. Telpon</span>
                        <input type="number" placeholder="Masukkan No Telpon.." name="number" required>
                    </div>
                    <div class="inputBox">
                        <span>Alamat Email</span>
                        <input type="email" placeholder="Masukkan Alamat Email.." name="email" required>
                    </div>

                    <div class="inputBox">
                        <span>Address line 1</span>
                        <input type="text" placeholder="e.g. flat no." name="flat" required>
                    </div>
                    <div class="inputBox">
                        <span> Address line 2</span>
                        <input type="text" placeholder="e.g. street name" name="street" required>
                    </div>
                    <div class="inputBox">
                        <span>Kota</span>
                        <input type="text" placeholder="e.g. mumbai" name="city" required>
                    </div>
                    <div class="inputBox">
                        <span>Provinsi</span>
                        <input type="text" placeholder="e.g. maharashtra" name="state" required>
                    </div>
                    <div class="inputBox">
                        <span>Negara</span>
                        <input type="text" placeholder="e.g. india" name="country" required>
                    </div>
                    <div class="inputBox"> <span>Kode pos</span>
                        <input type="text" placeholder="e.g. 123456" name="pin_code" required>
                    </div>
                </div>
                <input type="submit" value="Pesan Sekarang" name="order_btn" class="btn">
            </form>
        </section>

    </div>

</body>

</html>