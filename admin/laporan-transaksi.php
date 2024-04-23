<?php

session_start();

include '../server/connection.php';

// Initialize variables
$result = null;
$totalPrice = 0;

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the start and end dates from the form
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];

    // Construct the SQL query with date filtering
    $query = "SELECT * FROM orders WHERE order_date BETWEEN '$startDate' AND '$endDate'";

    $result = mysqli_query($conn, $query);

    // Calculate total price
    while ($row = mysqli_fetch_assoc($result)) {
        $totalPrice += $row['total_price']; // Add price to total
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin - Laporan Transaksi</title>
    <link rel="stylesheet" href="../css/default.css" />
    <link rel="stylesheet" href="../css/admin.css">
</head>

<body>
    <div class="wrapper">
        <?php include 'sidebar.php' ?>
        <div class="top-bar">
            <h2>Data Transaksi</h2>
        </div>
        <main class="main-content">
            <!-- Form for date filtering -->
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date">
                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date">
                <button type="submit">Cari</button>
                <!-- Export button -->
                <?php if ($result) : ?>
                    <a href="export_data.php?start_date=<?php echo $startDate ?>&end_date=<?php echo $endDate ?>" class="export-button">Export Data</a>
                <?php endif; ?>
            </form>
            <br>
            <?php if ($result) : ?>
                <table border="1">
                    <thead>
                        <th>No</th>
                        <th>Pelanggan</th>
                        <th>Tanggal</th>
                        <th>Jumlah</th>
                        <th>Status Pesanan</th>
                        <th>Status Pembayaran</th>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        mysqli_data_seek($result, 0); // Reset result pointer
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $row['fullname'] ?></td>
                                <td><?php echo $row['order_date'] ?></td>
                                <td>Rp. <?php echo number_format($row['total_price']) ?></td>
                                <td><?php echo $row['status'] ?></td>
                                <td><?php echo $row['payment_status'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3">Total</th>
                            <td><strong>Rp. <?php echo number_format($totalPrice) ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
            <?php endif; ?>
        </main>
        <footer class="admin-footer">
            Made with &hearts; - Andi Daffa Liefalza
        </footer>
    </div>
</body>

</html>