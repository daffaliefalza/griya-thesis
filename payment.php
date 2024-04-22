<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection
    include 'server/connection.php';

    // Get form data
    $payer_name = $_POST['nama_penyetor'];
    $total_payment = $_POST['payment_amount'];

    // File upload
    $target_dir = "proof_image/";
    $target_file = $target_dir . basename($_FILES["payment_proof"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["payment_proof"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["payment_proof"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["payment_proof"]["tmp_name"], $target_file)) {
            // File uploaded successfully, insert payment information into database
            $payment_proof_path = $target_file;
            $sql = "INSERT INTO payment (payer_name, total_payment, payment_proof) VALUES ('$payer_name', '$total_payment', '$payment_proof_path')";
            if (mysqli_query($conn, $sql)) {
                // Update payment status in checkout_history table
                $order_id = $_GET['order_id'];
                $update_sql = "UPDATE orders SET payment_status = 'Paid' WHERE order_id = '$order_id'";
                if (mysqli_query($conn, $update_sql)) {
                    echo "<script>
                            alert('Terimakasih!');
                            window.location.href = 'checkout_history.php';
                        </script>";
                } else {
                    echo "Error updating payment status: " . mysqli_error($conn);
                }
            } else {
                echo "Error inserting payment information: " . mysqli_error($conn);
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="file"] {
            margin-bottom: 30px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        ul li {
            margin-bottom: 10px;
        }

        div.instructions {
            font-style: italic;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Konfirmasi Pembayaran</h2>
        <form action="" method="post" enctype="multipart/form-data">

            <label for="nama_penyetor">Nama Penyetor:</label>
            <input type="text" id="nama_penyetor" name="nama_penyetor" required>

            <label for="payment_amount">Total Pembayaran:</label>
            <input type="text" id="payment_amount" name="payment_amount" required>

            <label for="payment_proof">Bukti Pembayaran:</label>
            <input type="file" id="payment_proof" name="payment_proof" accept="image/*" required>

            <input type="submit" value="Submit">
        </form>

        <div class="instructions">
            <p>Silahkan pilih opsi pembayaran ke no rekening berikut:</p>
            <ul>
                <li>BCA - 1121321313 (AN) - daffaliefalza</li>
                <li>BRI - 1121321313 (AN) - daffakece</li>
                <li>Mandiri - 112321315 (AN) - daffaliefalzakeren</li>
            </ul>
        </div>
    </div>
</body>

</html>