<?php

require('../server/connection.php');

if (isset($_GET['id_produk'])) {
    $id_produk = $_GET['id_produk'];

    // Retrieve existing data based on id_produk
    $sql = "SELECT * FROM produk WHERE id_produk='$id_produk'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Check if form is submitted for updating data
        if (isset($_POST['ubah_data'])) {
            $product_name = $_POST['product_name'];
            $product_category = $_POST['product_category'];
            $image = $_FILES['image']['name']; // Updated to handle file upload
            $image_tmp = $_FILES['image']['tmp_name']; // Temporary location of the file
            $price = $_POST['price'];
            $description = $_POST['description'];
            $stock = $_POST['stock'];

            // Get the last image filename
            $last_image = $row['image'];

            // Define the upload directory
            $upload_directory = "upload_file/";

            // Move the uploaded file to the defined directory if a new image is uploaded
            if (!empty($image)) {
                move_uploaded_file($image_tmp, $upload_directory . $image);
            } else {
                // If no new image is uploaded, use the last image filename
                $image = $last_image;
            }

            // Update the data in the database
            $sql = "UPDATE produk SET product_name='$product_name', product_category='$product_category', image='$image', price=$price, description='$description', stok=$stock WHERE id_produk='$id_produk'";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo '<script>alert("Data produk berhasil diubah."); window.location = "kelola-produk.php";</script>';
            } else {
                echo '<script>alert("Gagal mengubah data!");</script>';
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Produk</title>

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

    <!-- <a href="./kelola-produk.php" class="back">Kembali</a> -->
    <h1 style="text-align: center;">Ubah Data Produk</h1>

    <form action="" method="post" enctype="multipart/form-data"> <!-- enctype="multipart/form-data" is required for file uploads -->
        <label for="product_name">Nama Produk</label><br>
        <input type="text" name="product_name" id="product_name" value="<?php echo $row['product_name']; ?>"><br>

        <label for="product_category">Kategori Produk</label><br>
        <select name="product_category" id="product_category">
            <option value="Jamu" <?php if ($row['product_category'] == 'Jamu') echo 'selected'; ?>>Jamu</option>
            <option value="Instan" <?php if ($row['product_category'] == 'Instan') echo 'selected'; ?>>Instan</option>
        </select><br>


        <label for="image">Gambar</label><br>
        <div class="file-input-wrapper" style="margin-top: 15px;">
            <input type="file" name="image" id="image">
            <label for="image" class="file-label">Choose File</label>
        </div>
        <br>

        <label for="price">Harga</label><br>
        <input type="number" name="price" id="price" value="<?php echo $row['price']; ?>"><br>

        <label for="description">Deskripsi</label><br>
        <textarea name="description" id="description" cols="30" rows="10"><?php echo $row['description']; ?></textarea><br>

        <label for="stock">Stok</label><br>
        <input type="number" name="stock" id="stock" value="<?php echo $row['stok']; ?>"><br>

        <button type="submit" name="ubah_data">Ubah!</button>
    </form>


</body>

</html>