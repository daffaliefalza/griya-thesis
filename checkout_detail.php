<?php
session_start();

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
        <h1>Checkout Details</h1>

        <div class="customer-info">
            <h2>Customer Information:</h2>
            <p><strong>Name:</strong> <?= $name ?></p>
            <p><strong>Phone Number:</strong> <?= $number ?></p>
            <p><strong>Email:</strong> <?= $email ?></p>
        </div>

        <div class="shipping-address">
            <h2>Shipping Address:</h2>
            <p><strong>Address Line 1:</strong> <?= $flat ?></p>
            <p><strong>Address Line 2:</strong> <?= $street ?></p>
            <p><strong>City:</strong> <?= $city ?></p>
            <p><strong>State:</strong> <?= $state ?></p>
            <p><strong>Country:</strong> <?= $country ?></p>
            <p><strong>Pin Code:</strong> <?= $pin_code ?></p>
        </div>

        <div class="product-details">
            <h2>Product Details:</h2>
            <!-- Add product details here -->
        </div>

        <button id="pay-button">Proceed to Payment</button>
    </div>
    <!-- Include Midtrans Snap script -->
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-pZhq8U8wInb_l_Cz"></script>

    <!-- Trigger payment on button click -->
    <script type="text/javascript">
        var snapToken = '<?= $snapToken ?>';
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function() {
            window.snap.pay(snapToken);
        });
    </script>
</body>

</html>