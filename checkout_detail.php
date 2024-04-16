<?php
session_start();

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

// require 'PHPMailer/src/Exception.php';
// require 'PHPMailer/src/PHPMailer.php';
// require 'PHPMailer/src/SMTP.php';

// // Create a new PHPMailer instance
// $mail = new PHPMailer(true);

// Check if snapToken is present in the URL query parameters
if (isset($_GET['snapToken'])) {
    $snapToken = $_GET['snapToken'];
} else {
    // If snapToken is not present, redirect back to checkout.php
    header('Location: checkout.php');
    exit;
}

// Retrieve form data from session variables
$name = $_SESSION['name'];
$number = $_SESSION['number'];
$email = $_SESSION['email'];
$flat = $_SESSION['flat'];
$street = $_SESSION['street'];
$city = $_SESSION['city'];
$state = $_SESSION['state'];
$country = $_SESSION['country'];
$pin_code = $_SESSION['pin_code'];

// Retrieve product details from session variable
$items = $_SESSION['items'];

// Retrieve transaction details from session variable
$transaction_details = $_SESSION['transaction_details'];

// Check if transaction details is set
if (isset($transaction_details)) {
    // Access order ID
    $order_id = $transaction_details['order_id'];
} else {
    // Handle the case where transaction details are not set
    // You can redirect the user or show an error message
    echo "Transaction details are not set!";
}

// Construct email message
// $message = "Dear $name,\n\n";
// $message .= "Thank you for your order!\n\n";
// $message .= "Your order details:\n\n";

// // Include order ID in the email message
// $message .= "Order ID: $order_id\n\n";

// $grand_total = 0;

// foreach ($items as $item) {
//     $total_price = $item['price'] * $item['quantity'];
//     $total_price_formatted = 'Rp ' . number_format($total_price, 0, ',', '.');
//     $grand_total += $total_price;

//     $message .= "Product: " . $item['name'] . "\n";
//     $message .= "Price: Rp " . number_format($item['price'], 0, ',', '.') . "\n";
//     $message .= "Quantity: " . $item['quantity'] . "\n";
//     $message .= "Total Price: " . $total_price_formatted . "\n\n";
// }

// $wa = 'https://wa.me/6281213567170';

// $message .= "Grand Total: Rp " . number_format($grand_total, 0, ',', '.') . "\n\n";
// $message .= "Shipping Address:\n";
// $message .= "Address Line 1: $flat\n";
// $message .= "Address Line 2: $street\n";
// $message .= "City: $city\n";
// $message .= "State: $state\n";
// $message .= "Country: $country\n";
// $message .= "Postal Code: $pin_code\n\n";
// $message .= "If you have any questions, feel free to contact us at $wa \n";
// $message .= "Best Regards,\n";
// $message .= "Griya Jamoe Klasik";

// // SMTP configuration
// $mail->isSMTP();
// $mail->Host = 'smtp.gmail.com';
// $mail->SMTPAuth = true;
// $mail->Username = 'liefalzaa@gmail.com'; // Your Gmail email address
// $mail->Password = 'jnzw guiv sksl vcjy'; // Your Gmail password
// $mail->SMTPSecure = 'tls';
// $mail->Port = 587;

// // Set email parameters
// $mail->setFrom('liefalzaa@gmail.com', 'Your Company Name');
// $mail->addAddress($email, $name);
// $mail->Subject = 'Order Confirmation';
// $mail->Body = $message;

// // Send email
// if (!$mail->send()) {
//     echo 'Email could not be sent.';
//     echo 'Mailer Error: ' . $mail->ErrorInfo;
// } else {
//     // echo 'Email sent successfully!';
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Detail</title>
    <link rel="stylesheet" href="css/checkout-detail.css">
</head>

<body>
    <div class="container">
        <h1>Detail Pembayaran</h1>
        <!-- Display order ID -->
        <p><strong>Nomor Order:</strong> <?= $order_id ?></p>
        <div class="customer-info">
            <h2>Informasi Customer:</h2>
            <p><strong>Nama Lengkap:</strong> <?= $name ?></p>
            <p><strong>No Telpon:</strong> <?= $number ?></p>
            <p><strong>Alamat Email:</strong> <?= $email ?></p>
        </div>

        <div class="shipping-address">
            <h2>Alamat Pengiriman:</h2>
            <p><strong>Address Line 1:</strong> <?= $flat ?></p>
            <p><strong>Address Line 2:</strong> <?= $street ?></p>
            <p><strong>Kota:</strong> <?= $city ?></p>
            <p><strong>Provinsi:</strong> <?= $state ?></p>
            <p><strong>Negara:</strong> <?= $country ?></p>
            <p><strong>Kode Pos:</strong> <?= $pin_code ?></p>
        </div>

        <div class="product-details">
            <h2>Detail Produk:</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Kuantitas</th>
                        <th>Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($items as $item) {
                        $total_price = $item['price'] * $item['quantity'];
                        $total_price_formatted = 'Rp ' . number_format($total_price, 0, ',', '.');
                    ?>
                        <tr>
                            <td><?php echo $item['name']; ?></td>
                            <td><?php echo 'Rp ' . number_format($item['price'], 0, ',', '.'); ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td><?php echo $total_price_formatted; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <button id="pay-button">Pilih metode pembayaran</button>
    </div>

    <!-- Include Midtrans Snap script -->
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-pZhq8U8wInb_l_Cz"></script>

    <!-- Trigger payment on button click -->
    <script type="text/javascript">
        var snapToken = '<?= $snapToken ?>';
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function() {
            window.snap.pay(snapToken), {
                onSuccess: function(result) {
                    /* You may add your own implementation here */
                    // alert("payment success!");
                    // console.log(result);
                },
                onPending: function(result) {
                    /* You may add your own implementation here */
                    alert("wating your payment!");
                    console.log(result);
                },
                onError: function(result) {
                    /* You may add your own implementation here */
                    alert("payment failed!");
                    console.log(result);
                },
                onClose: function() {
                    /* You may add your own implementation here */
                    alert('you closed the popup without finishing the payment');
                }
            }
        });
    </script>
</body>

</html>