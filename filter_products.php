<?php
// Include connection.php file to establish database connection
require('server/connection.php');

// Check if a category filter is applied
$category_filter = isset($_GET['category']) ? $_GET['category'] : '';

// Modify the SQL query to select products based on the category filter
$select_products = mysqli_query($conn, "SELECT * FROM `produk`" . ($category_filter ? " WHERE product_category = '$category_filter'" : ""));
if (mysqli_num_rows($select_products) > 0) {
    while ($row = mysqli_fetch_assoc($select_products)) {
        $out_of_stock_class = ($row['stok'] == 0) ? 'out-of-stock' : '';
?>
        <form action="" method="post">
            <div class="col <?php echo $out_of_stock_class; ?>">
                <img style="width: 300px;" src="./admin/upload_file/<?php echo $row['image'] ?>" alt="Wedang kencur" />
                <h3><?php echo $row['product_name'] ?></h3>
                <h4 class="harga"><?php echo 'Rp ' . number_format($row['price'], 0, ',', '.') ?></h4>
                <p><?php echo $row['description'] ?></p>
                <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $row['price']; ?>">
                <input type="hidden" name="product_image" value="<?php echo $row['image']; ?>">
                <button class="pesan" type="submit" name="add_to_cart" <?php echo ($out_of_stock_class != '') ? 'disabled' : ''; ?>>Masukkan ke keranjang</button>
            </div>
        </form>
<?php
    }
} else {
    echo "No products found.";
}
?>