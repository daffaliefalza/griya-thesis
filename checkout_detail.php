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
        <h1>Detail Pembayaran</h1>

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
                    if (isset($_SESSION['items']) && !empty($_SESSION['items'])) {
                        foreach ($_SESSION['items'] as $item) {
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
            window.snap.pay(snapToken);
        });
    </script>


</body>

</html>