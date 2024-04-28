<?php
session_start();

require('../server/connection.php');

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}


$sql = "SELECT * FROM produk";
$result = mysqli_query($conn, $sql);


// Fetch the count of orders
$sql_order = "SELECT COUNT(*) AS total_orders FROM orders";
$result_order = mysqli_query($conn, $sql_order);
$row_order = mysqli_fetch_assoc($result_order);
$total_orders = $row_order['total_orders'];




// Fetch the count of customer
$sql_customer = "SELECT COUNT(*) AS total_customer FROM users";
$result_customer = mysqli_query($conn, $sql_customer);
$row_customer = mysqli_fetch_assoc($result_customer);
$total_customer = $row_customer['total_customer'];

// fetch the count of transaction done

$sql_transaction = "SELECT COUNT(*) AS total_transaction FROM orders WHERE status = 'done' AND payment_status = 'paid'";
$result_transaction = mysqli_query($conn, $sql_transaction);
$row_transaction = mysqli_fetch_assoc($result_transaction);
$total_transaction = $row_transaction['total_transaction'];

$total_price = 0;

$res = mysqli_query($conn, "SELECT * FROM orders WHERE status = 'done' AND payment_status = 'paid'");

while ($row = mysqli_fetch_assoc($res)) {
    $total_price += $row['total_price'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/default.css" />
    <link rel="stylesheet" href="../css/admin.css">

    <style>
        body {
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        /* 
        .wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        } */







        .main-content-header {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .main-content-header div {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .main-content-header div h2 {
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 1.4rem;
        }

        .main-content-header div p {
            margin-top: 0;
            margin-bottom: 5px;
            font-size: 1rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        table thead {
            background-color: #f2f2f2;
        }

        table th,
        table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        table tbody tr:last-child td {
            border-bottom: none;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        .pagination button {
            padding: 10px 20px;
            background-color: #10439F;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 0 5px;
            transition: background-color 0.3s ease;
        }

        .pagination button:hover {
            background-color: #0c3366;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <?php include 'sidebar.php' ?>
        <div class="top-bar">
            <h2>Dashboard</h2>
            <div class="top-bar-links">
                <h3>Halo, <span style="color: #9f9f9f">Admin</span></h3>
            </div>
        </div>
        <main class="main-content">
            <div class="main-content-header">
                <div>
                    <h2>Jumlah data pesanan</h2>
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <p><?php echo $total_orders; ?></p>
                        <p>Lihat detail</p>
                    </div>
                </div>
                <div>
                    <h2>Jumlah data pelanggan</h2>
                    <div style="display: flex; align-items: center; justify-content: space-between;">

                        <p><?php echo $total_customer ?></p>
                        <p>Lihat detail</p>
                    </div>
                </div>
                <div>
                    <h2>Status transaksi selesai</h2>
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <p><?php echo $total_transaction ?></p>
                        <p>Lihat detail</p>
                    </div>
                </div>
                <div>
                    <h2>Total Pendapatan</h2>
                    <p>Rp. <?php echo number_format($total_price) ?></p>
                </div>
            </div>
            <table>
                <h2>Data Transaksi</h2>
                <thead>
                    <tr>
                        <th>No</th>
                        <!-- Add more table headers here if needed -->
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <!-- Add more table cells here if needed -->
                    </tr>
                </tbody>
            </table>
            <div class="pagination">
                <button>prev</button>
                <p>1</p>
                <p>2</p>
                <p>3</p>
                <button>next</button>
            </div>
        </main>
        <footer class="admin-footer">
            Made with &hearts; - Andi Daffa Liefalza
        </footer>
    </div>
</body>

</html>