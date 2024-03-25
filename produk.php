<?php

require('server/connection.php');

// $sql = "SELECT * FROM produk";
// $result = mysqli_query($conn, $sql);

if (isset($_POST['add_to_cart'])) {

  $product_name = $_POST['product_name'];
  $product_price = $_POST['product_price'];
  $product_image = $_POST['product_image'];
  $product_quantity = 1;

  $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name'");

  if (mysqli_num_rows($select_cart) > 0) {
    $message[] = 'product already added to cart';
  } else {
    $insert_product = mysqli_query($conn, "INSERT INTO `cart`(name, price, image, quantity) VALUES('$product_name', '$product_price', '$product_image', '$product_quantity')");
    $message[] = 'product added to cart succesfully';
  }
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Produk</title>

  <link rel="stylesheet" href="css/default.css" />
  <link rel="stylesheet" href="css/produk.css" />
</head>

<body>


  <?php

  if (isset($message)) {
    foreach ($message as $message) {
      echo '<div class="message"><span>' . $message . '</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
    };
  };

  ?>

  <!-- header start -->

  <header>
    <div class="container">
      <a href="#">
        <img src="./img/logo.png" alt="Logo Griya" />
      </a>
      <nav>
        <ul>
          <li><a href="index.html">Beranda</a></li>
          <li><a href="#">Tentang-kami</a></li>
          <li><a href="#">Produk</a></li>
          <li><a href="#">Artikel</a></li>
        </ul>
      </nav>
      <div class="wrapper">
        <!-- <a href="#">Login</a> -->

        <?php

        $select_rows = mysqli_query($conn, "SELECT * FROM `cart`") or die('query failed');
        $row_count = mysqli_num_rows($select_rows);

        ?>

        <a style="color: #000; text-decoration: none;" href="cart.php" class="cart">cart <span><?php echo $row_count; ?></span> </a>

      </div>
    </div>
  </header>
  <!-- header end -->

  <section class="all-product" id="all-product">
    <div class="container">
      <h2 class="all-product-title">
        <span style="color: #dfb665">Produk</span> Kami
      </h2>
      <div class="line"></div>
      <p class="all-product-text">
        Setiap produk kami menghadirkan keunikan cita rasa yang istimewa,
        <br />dan diolah dengan menggunakan bahan-bahan berkualitas terbaik.
      </p>
      <div class="row">

        <?php

        $select_products = mysqli_query($conn, "SELECT * FROM `produk`");

        if (mysqli_num_rows($select_products) > 0) {
          while ($row = mysqli_fetch_assoc($select_products)) {

        ?>
            <form action="" method="post">
              <div class="col">
                <img src="./img/<?php echo $row['image'] ?>" alt="Wedang kencur" />
                <h3><?php echo $row['nama_produk'] ?></h3>
                <h4 class="harga"><?php echo 'Rp ' . number_format($row['harga'], 0, ',', '.') ?></h4>
                <p>
                  <?php echo $row['deskripsi'] ?>
                </p>
                <input type="hidden" name="product_name" value="<?php echo $row['nama_produk']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $row['harga']; ?>">
                <input type="hidden" name="product_image" value="<?php echo $row['image']; ?>">
                <button class="pesan" type="submit" name="add_to_cart">Masukkan ke keranjang</button>
              </div>

            </form>
        <?php }
        };

        ?>


      </div>
    </div>
  </section>

  <!-- footer start -->
  <footer class="footer" id="footer">
    <div class="container">
      <img src="img/logo.png" alt="logo griya jamoe" />
      <div class="row">
        <div class="col">
          <h5>Minuman Tradisional <br />Rempah Klasik, Rasa Autentik</h5>
          <div class="footer-line"></div>
          <p>Tumbuhkan Kesehatan, Rasakan Kebaikan</p>
        </div>
        <div class="col">
          <h4>Quick Links</h4>
          <ul>
            <li><a href="produk.html">Produk</a></li>
            <li><a href="artikel.html">Artikel</a></li>
          </ul>
        </div>
        <div class="col">
          <h4>Kontak</h4>
          <ul>
            <li>
              <p>
                ✉️ Srengseng Sawah, Kec. Jagakarsa, <br />Kota Jakarta
                Selatan, Daerah Khusus Ibukota Jakarta 12640
              </p>
            </li>
            <li>
              <p>📞 0856-1445-231</p>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <hr />
    <p class="footer-bottom">
      © Griya Jamoe Klasik 2024 - All rights reserved
    </p>
  </footer>

  <!-- footer end -->
</body>

</html>