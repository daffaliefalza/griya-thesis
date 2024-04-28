<?php

include '../server/connection.php';

// Get start and end dates from the URL parameters
$startDate = $_GET['start_date'];
$endDate = $_GET['end_date'];

// Construct the SQL query with date filtering
$query = "SELECT * FROM orders WHERE order_date BETWEEN '$startDate' AND '$endDate'";
$result = mysqli_query($conn, $query);

// Set headers for CSV file download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="exported_data.csv"');

// Open file handle to write CSV data
$output = fopen('php://output', 'w');

// Write CSV headers
fputcsv($output, array('No', 'Pelanggan', 'Tanggal', 'Jumlah', 'Status Pesanan', 'Status Pembayaran'));

// Write data rows
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, array($no++, $row['fullname'], $row['order_date'], $row['total_price'], $row['status'], $row['payment_status']));
}

// Close file handle
fclose($output);