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

// Load cart items from the database if the user is logged in
$cart_items = [];
if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  $select_cart = mysqli_query($conn, "SELECT id, name, price, image, quantity FROM `cart` WHERE id_users = '$user_id'");
  if (mysqli_num_rows($select_cart) > 0) {
    while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
      $cart_items[] = $fetch_cart;
    }
  }
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

  // Retrieve the id_produk of the product from the produk table
  $select_produk = mysqli_query($conn, "SELECT id_produk FROM `produk` WHERE nama_produk = '$product_name'");
  if ($select_produk && mysqli_num_rows($select_produk) > 0) {
    $row = mysqli_fetch_assoc($select_produk);
    $id_produk = $row['id_produk'];

    // Check if the item is already in the cart
    $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE id_produk = '$id_produk' AND id_users = '$user_id'");
    if (mysqli_num_rows($select_cart) > 0) {
      echo '<script>alert("Produk sudah berada di keranjang");</script>';
      echo '<script>window.location.href = "produk.php";</script>';
    } else {
      // Add the item to the cart with the user ID and id_produk
      $insert_product = mysqli_query($conn, "INSERT INTO `cart`(id_produk, name, price, image, quantity, id_users) VALUES('$id_produk', '$product_name', '$product_price', '$product_image', '$product_quantity', '$user_id')");
      echo "<script>alert('Produk berhasil ditambahkan!'); window.location.href = 'produk.php';</script>";
    }
  } else {
    echo "<script>alert('Produk tidak ditemukan!');</script>";
  }
}

// Logout functionality
if (isset($_POST['logout'])) {
  // Clear the cart session
  unset($_SESSION['cart']); // Assuming you're storing cart items in $_SESSION['cart']

  // Unset all other session variables
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

    .wrapper {
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .welcome {
      margin-right: 10px;
    }

    .logout-button {}

    .login-link {
      color: #007bff;
      text-decoration: none;
      margin-right: 10px;
    }

    .cart-link {
      color: #000;
      text-decoration: none;
      margin-right: 10px;
    }

    .cart-count {
      background-color: #f44336;
      color: white;
      padding: 2px 6px;
      border-radius: 50%;
      font-size: 12px;
    }



    /* Style for out-of-stock products */
    .out-of-stock {
      /* Example styles to visually indicate that the product is out of stock */
      opacity: 0.6;
      /* Example: reduce opacity to visually indicate unavailable */
      position: relative;
    }

    .out-of-stock::before {
      content: "Stok Habis";
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: rgba(255, 255, 255, 0.8);
      /* Example: semi-transparent white background */
      padding: 5px 10px;
      border-radius: 5px;
    }

    /* Disabled button cursor */
    .pesan[disabled] {
      cursor: not-allowed !important;
    }

    .elegant-link {
      color: #333;
      /* Dark gray */
      text-decoration: none;
      font-weight: bold;
      padding: 8px 12px;
      border-radius: 5px;
      background-color: #f9f9f9;
      /* Light gray */
      transition: all 0.3s ease;
    }

    .elegant-link:hover {
      background-color: #e0e0e0;
      /* Lighter gray on hover */
      color: #000;
      /* Black on hover */
    }
  </style>

  <script>
    // Function to filter products based on category
    function filterProducts(category) {
      // Store the selected category in localStorage
      localStorage.setItem('selectedCategory', category);

      // Send an AJAX request to fetch products of the selected category
      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          // Replace the current product grid with the fetched products
          document.getElementById("product-grid").innerHTML = this.responseText;
        }
      };
      xhr.open("GET", "filter_products.php?category=" + category, true);
      xhr.send();
    }

    // Function to apply the category filter on page load
    window.onload = function() {
      // Check if a category filter is stored in localStorage
      var selectedCategory = localStorage.getItem('selectedCategory');
      if (selectedCategory) {
        // Apply the stored category filter
        filterProducts(selectedCategory);
      }
    };
  </script>
</head>

<body>


  <!-- header start -->
  <header>
    <div class="container">
      <a href="index.php">
        <img src="./img/logo.png" alt="Logo Griya" />
      </a>
      <nav>
        <ul>
          <li><a href="index.php">Beranda</a></li>
          <li><a href="index.php#tentang-kami">Tentang-kami</a></li>
          <li><a href="#">Produk</a></li>
          <li><a href="artikel.php">Artikel</a></li>
          <?php

          if (isset($_SESSION['user_id'])) {
            echo "<li><a href='checkout_history.php' class='elegant-link'>Riwayat Pemesanan</a></li>";
          }


          ?>
        </ul>
      </nav>
      <div class="wrapper">
        <?php echo $username ? "<span>Welcome, $username</span>" : ""; ?>
        <?php echo $username ? '<form action="" method="post"><button type="submit" name="logout" style="  background-color: #d35400 !important;
      color: white !important;
      border: none !important;
      padding: 8px 16px !important;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;

      margin-right: 10px;">Logout</button></form>' : '<a href="login.php" style="text-decoration: none; color: #000;  background-color: #d35400 !important;
      color: white !important;
      border: none !important;
      padding: 8px 16px !important;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;">Login</a>'; ?>
        <?php $row_count = count($cart_items); ?>
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

      <div class="buttons" style="display: flex; justify-content: center; gap: 1rem">
        <button class="btn-jamu" onclick="filterProducts('Jamu')">
          Jamu
        </button>
        <button class="btn-instan" onclick="filterProducts('Instan')">
          Instan
        </button>
      </div>

      <div id="product-grid" class="row">
        <?php
        // Include filter_products.php to display initial products
        include("filter_products.php");
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
            <li><a href="produk.php">Produk</a></li>
            <li><a href="artikel.php">Artikel</a></li>
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