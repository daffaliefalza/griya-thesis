<?php

require('../server/connection.php');

if (isset($_POST['tambah_data'])) {

    $product_name = $_POST['product_name'];
    $product_category = $_POST['product_category'];
    $image = $_FILES['image']['name']; // Updated to handle file upload
    $image_tmp = $_FILES['image']['tmp_name']; // Temporary location of the file
    $price = $_POST['price'];
    $description = $_POST['description'];
    $stock = $_POST['stock'];

    $upload_directory = "upload_file/"; // Define the upload directory

    move_uploaded_file($image_tmp, $upload_directory . $image); // Move the uploaded file to the defined directory

    $sql = "INSERT INTO produk VALUES ('', '$product_name', '$product_category', '$image', $price, '$description', $stock)";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo '<script>alert("Data produk berhasil ditambah."); window.location = "index.php";</script>';
    } else {
        echo '<script>alert("Gagal menambahkan data!");</script>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>

    <link rel="stylesheet" href="../css/default.css">
    <link rel="stylesheet" href="../css/form-admin.css">

    <style>
        /* Style for input file */
        input[type="file"] {
            width: 100%;
            border: 1px solid #ccc;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
        }

        .file-input-wrapper {
            position: relative;
            width: 100%;
        }

        .file-input-wrapper label {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        /* Style for select */
        select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            margin-bottom: 10px;
        }
    </style>

</head>

<body>

    <a href="./index.php" class="back">Kembali</a>

    <h1 style="text-align: center;">Tambah Data Produk</h1>

    <form action="" method="post" enctype="multipart/form-data"> <!-- enctype="multipart/form-data" is required for file uploads -->
        <label for="product_name">Nama Produk</label>
        <br>
        <input type="text" name="product_name" id="product_name" required>
        <br>

        <label for="product_category">Kategori Produk</label>
        <br>
        <select name="product_category" id="product_category" required>
            <option value="Jamu">Jamu</option>
            <option value="Instan">Instan</option>
        </select>
        <br>

        <label for="image">Gambar</label>
        <br>

        <input type="file" name="image" id="image" required> <!-- Change input type to file for image upload -->
        <br>

        <label for="price">Harga</label>
        <br>
        <input type="number" name="price" id="price" required>
        <br>

        <label for="description">Deskripsi</label>
        <br>
        <textarea name="description" id="description" cols="30" rows="10"></textarea>
        <br>

        <label for="stock">Stok</label>
        <br>
        <input type="number" name="stock" id="stock" required>
        <br>

        <button type="submit" name="tambah_data">Tambah!</button>

    </form>

</body>

</html>