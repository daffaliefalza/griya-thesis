<?php

session_start();

include '../server/connection.php';

// ngambil / get start dates dan end dates dari  URL parameters
$startDate = $_GET['start_date'];
$endDate = $_GET['end_date'];

//   SQL query with date filtering dan status conditions
$query = "SELECT orders.*, users.fullname, GROUP_CONCAT(order_items.product_name SEPARATOR ', ') AS product_names, SUM(order_items.quantity) AS total_quantity
          FROM orders 
          LEFT JOIN users ON orders.id_users = users.id_users 
          LEFT JOIN order_items ON orders.order_id = order_items.order_id 
          WHERE order_date BETWEEN '$startDate' AND '$endDate' 
          AND status = 'Selesai' AND payment_status = 'Sudah Dibayar'
          GROUP BY orders.order_id";

$result = mysqli_query($conn, $query);

// Set headers for CSV file download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="exported_data.csv"');

// Open file handle to write CSV data
$output = fopen('php://output', 'w');

//  baris headingnya
fputcsv($output, array('No', 'Pelanggan', 'Tanggal', 'Produk yang Dipesan', 'Quantity', 'Jumlah', 'Status Pesanan', 'Status Pembayaran'));

// data di barisnya
$no = 1;
$total_price = 0;
while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, array($no++, $row['fullname'], $row['order_date'], $row['product_names'], $row['total_quantity'], $row['total_price'], $row['status'], $row['payment_status']));

    // Add total price to the running total
    $total_price += $row['total_price'];
}

// Write total price row
fputcsv($output, array('', '', '', '', '', $total_price, '', ''));

// Close file handle
fclose($output);
