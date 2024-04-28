<?php
session_start();
date_default_timezone_set('Asia/Jakarta');

include 'server/connection.php';

// Function to generate a unique order number
function generateOrderNumber()
{
    // Generate a random number and append current timestamp to ensure uniqueness
    return 'ORD' . mt_rand(100000, 999999) . time();
}

// Fetch cart items for the current user
$user_id = $_SESSION['user_id'];

$select_user = mysqli_query($conn, "SELECT fullname, email FROM users WHERE id_users = '$user_id'");

while ($select = mysqli_fetch_assoc($select_user)) {
    $_SESSION['fullname'] = $select['fullname'];
    $_SESSION['user_email'] = $select['email'];
}

$select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE id_users = '$user_id'");
$total = 0;

$product_details = array(); // Initialize an empty array to store product details

if (mysqli_num_rows($select_cart) > 0) {
    while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
        $total_price = $fetch_cart['price'] * $fetch_cart['quantity'];
        $total += $total_price; // Accumulate total price

        // Store product details with individual total price
        $product_details[] = array(
            'name' => $fetch_cart['name'],
            'quantity' => $fetch_cart['quantity'],
            'total_price' => $total_price // Calculate individual total price for each product
        );
    }
}

// Handle form submission
if (isset($_POST['order_btn'])) {
    // Collect order details
    $fullname = $_POST['fullname'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $province = $_POST['province'];
    $city = $_POST['city'];
    $detail_address = $_POST['detail_address'];
    $postal_code = $_POST['postal_code'];

    // Generate unique order number
    $order_number = generateOrderNumber();

    // Get current timestamp                            
    $order_date = date('Y-m-d H:i:s');

    // Calculate payment expiry (24 hours from order date)
    $payment_expiry = date('Y-m-d H:i:s', strtotime($order_date . ' +1 day'));

    // Insert order into orders table with order creation timestamp and payment expiry
    $insert_order_query = "INSERT INTO orders (order_number, id_users, fullname, phone_number, email, province, city, detail_address, postal_code, total_price, order_date, payment_expiry) VALUES ('$order_number', '$user_id', '$fullname', '$phone_number', '$email', '$province', '$city', '$detail_address', '$postal_code', '$total', '$order_date', '$payment_expiry')";
    if (mysqli_query($conn, $insert_order_query)) {
        // Get the last inserted order ID
        $order_id = mysqli_insert_id($conn);

        // Insert items into order_items table
        foreach ($product_details as $product) {
            $product_name = $product['name'];
            $quantity = $product['quantity'];
            $total_price = $product['total_price']; // Individual total price for each product
            $insert_item_query = "INSERT INTO order_items (order_id, product_name, quantity, total_price) VALUES ('$order_id', '$product_name', '$quantity', $total_price)";
            if (!mysqli_query($conn, $insert_item_query)) {
                echo "Error inserting item: " . mysqli_error($conn);
                exit();
            }
        }

        // Clear cart for the current user
        mysqli_query($conn, "DELETE FROM `cart` WHERE id_users = '$user_id'");

        // Redirect to checkout history or any other page
        header("Location: checkout_history.php");
        exit();
    } else {
        // Error occurred while inserting order
        echo "Error inserting order: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>

    <link rel="stylesheet" href="css/default.css">
    <link rel="stylesheet" href="css/checkouts.css">
</head>

<body>

    <div class="container">
        <section class="checkout-form">
            <h1 class="heading">Isi formulir pemesanan</h1>
            <form action="" method="post">
                <div class="display-order">
                    <?php
                    // Display cart items for the current user
                    foreach ($product_details as $product) {
                        echo "<p>{$product['name']} - Jumlah: {$product['quantity']}, Harga: Rp " . number_format($product['total_price'], 0, ',', '.') . ",-</p>"; // Output each product name, its quantity, and individual total price
                    }
                    if ($total > 0) {
                        echo "<span><strong>Total Harga: Rp " . number_format($total, 0, ',', '.') . ",-</strong></span>";
                    } else {
                        echo "<div class='display-order'><span>Your cart is empty!</span></div>";
                    }
                    ?>
                </div>
                <div class="flex">
                    <div class="inputBox">
                        <span>Nama Lengkap</span>
                        <input type="text" name="fullname" readonly value="<?php echo $_SESSION['fullname']   ?>" style=" background-color: #f2f2f8; 
                border: 1px solid #ddd; 
                color: #555; 
                cursor: not-allowed; ">
                    </div>
                    <div class="inputBox">
                        <span>No. Telpon</span>
                        <input type="number" placeholder="Masukkan No Telpon.." name="phone_number" required>
                    </div>
                    <div class="inputBox">
                        <span>Alamat Email</span>
                        <input type="email" placeholder="Masukkan Alamat Email.." name="email" readonly required value="<?php echo $_SESSION['user_email'] ?>" style=" background-color: #f2f2f8; 
                border: 1px solid #ddd; 
                color: #555; 
                cursor: not-allowed; ">
                    </div>
                    <div class="inputBox">
                        <span>Provinsi</span>
                        <input type="text" placeholder="Jawa Barat" name="province" required>
                    </div>
                    <div class="inputBox">
                        <span>Kota</span>
                        <input type="text" placeholder="Bandung" name="city" required>
                    </div>
                    <br>
                    <div class="inputBox">
                        <p>Alamat Lengkap</p>
                        <textarea name="detail_address" cols="30" rows="10" placeholder="Jalan lumbu tengah 1b"></textarea>
                    </div>
                    <div class="inputBox">
                        <span>Kode pos</span>
                        <input type="text" placeholder="e.g. 123456" name="postal_code" required>
                    </div>
                </div>
                <input type="submit" value="Pesan Sekarang" name="order_btn" class="btn">
            </form>
        </section>
    </div>

</body>

</html>