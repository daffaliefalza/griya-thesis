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
$method = $_SESSION['method'];
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
</head>

<body>

    <h1>Checkout Details</h1>

    <h2>Customer Information:</h2>
    <p>Name: <?= $name ?></p>
    <p>Phone Number: <?= $number ?></p>
    <p>Email: <?= $email ?></p>

    <h2>Shipping Address:</h2>
    <p>Address Line 1: <?= $flat ?></p>
    <p>Address Line 2: <?= $street ?></p>
    <p>City: <?= $city ?></p>
    <p>State: <?= $state ?></p>
    <p>Country: <?= $country ?></p>
    <p>Pin Code: <?= $pin_code ?></p>

    <h2>Payment Method:</h2>
    <p><?= $method ?></p>

    <h2>Product Details:</h2>
    <!-- Add product details here -->

    <!-- Include Midtrans Snap script -->
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-pZhq8U8wInb_l_Cz"></script>

    <!-- Trigger payment on button click -->
    <button id="pay-button">Proceed to Payment</button>
    <script type="text/javascript">
        var snapToken = '<?= $snapToken ?>';
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function() {
            window.snap.pay(snapToken);
        });
    </script>
</body>

</html>