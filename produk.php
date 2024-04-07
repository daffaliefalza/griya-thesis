<?php
session_start();

// Proceed with adding items to the cart
require('server/connection.php');

// Check if the user is logged in
$username = isset($_SESSION['user_id']) ? fetchUsername($_SESSION['user_id']) : null;

// Fetch username from the database based on the user ID
function fetchUsername($user_id)
{
  global $conn;
  $query = "SELECT username FROM users WHERE id_users = '$user_id'";
  $result = mysqli_query($conn, $query);
  if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    return $row['username'];
  }
  return null;
}

// Add item to cart logic
if (isset($_POST['add_to_cart'])) {

  if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
    exit();
  }

  // Get the user ID from the session
  $user_id = $_SESSION['user_id'];
  $product_name = $_POST['product_name'];
  $product_price = $_POST['product_price'];
  $product_image = $_POST['product_image'];
  $product_quantity = 1;

  // Check if the item is already in the cart
  $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name'");
  if (mysqli_num_rows($select_cart) > 0) {
    echo '<script>alert("Produk sudah berada di keranjang");</script>';
  } else {
    // Add the item to the cart with the user ID
    $insert_product = mysqli_query($conn, "INSERT INTO `cart`(name, price, image, quantity, id_users) VALUES('$product_name', '$product_price', '$product_image', '$product_quantity', '$user_id')");
    echo "<script>alert('Produk berhasil ditambahkan!');</script>";
  }
}

// Logout functionality
if (isset($_POST['logout'])) {
  // Unset all session variables
  $_SESSION = array();
  // Destroy the session
  session_destroy();
  // Redirect to the produk.php page
  header("Location: produk.php");
  exit();
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

  <style>
    /* CSS for Cart Icon */
    .wrapper .cart {
      position: relative;
      color: #000;
      text-decoration: none;
    }

    .wrapper .cart span {
      position: absolute;
      top: -8px;
      right: -20px;
      background-color: #3498db;
      /* Blue background color */
      color: #fff;
      /* White text color */
      font-size: 12px;
      border-radius: 50%;
      width: 20px;
      height: 20px;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    /* Cart icon hover effect */
    .wrapper .cart:hover {
      color: #2980b9;
      /* Darker blue color on hover */
    }
  </style>

</head>

<body>

  <!-- header start -->
  <header>
    <div class="container">
      <a href="#">
        <img src="./img/logo.png" alt="Logo Griya" />
      </a>
      <nav>
        <ul>
          <li><a href="index.html">Beranda</a></li>
          <li><a href="index.html">Tentang-kami</a></li>
          <li><a href="#">Produk</a></li>
          <li><a href="blog.html">Blog</a></li>
        </ul>
      </nav>
      <div class="wrapper">
        <?php echo $username ? "<span>Welcome, $username</span>" : ""; ?>
        <?php echo $username ? '<form action="" method="post"><button type="submit" name="logout">Logout</button></form>' : '<a href="login.php">Login</a>'; ?>
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
                <p><?php echo $row['deskripsi'] ?></p>
                <input type="hidden" name="product_name" value="<?php echo $row['nama_produk']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $row['harga']; ?>">
                <input type="hidden" name="product_image" value="<?php echo $row['image']; ?>">
                <button class="pesan" type="submit" name="add_to_cart">Masukkan ke keranjang</button>
              </div>
            </form>
        <?php
          }
        }
        ?>
      </div>
    </div>
  </section>

  <!-- footer start -->
  <footer class="footer" id="footer">
    <div class="container">
      <img src="img/logo.png" alt="logo griya jamoe" />
      <div class="row">
        <!-- Footer content -->
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