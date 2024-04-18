<?php

require('server/connection.php');

$result = mysqli_query($conn, "SELECT * FROM artikel");






?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Blog</title>

  <link rel="stylesheet" href="css/default.css" />
  <link rel="stylesheet" href="css/blog.css" />
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
          <li><a href="produk.php">Produk</a></li>
          <li><a href="artikel.php">Artikel</a></li>
        </ul>
      </nav>
    </div>
  </header>
  <!-- header end -->

  <div class="banner-wrapper">
    <div class="banner">
      <h2>Blog</h2>
      <img src="img/blog-banner.jpg" alt="blog banner" />
    </div>
    <h3 class="credit">Image Credit - Freepik</h3>
  </div>

  <section class="blog-wrapper">
    <div class="container">
      <article class="blog">

        <?php
        while ($row = mysqli_fetch_assoc($result)) {
        ?>

          <div class="blog-post">
            <img src="./img/<?php echo $row['image'] ?>" alt="" />
            <div class="blog-content">
              <h4 class="blog-date"><?php echo $row['date_post'] ?></h4>
              <h3 class="blog-title"><?php echo $row['title'] ?></h3>
              <p class="blog-description">
                <?php echo $row['content'] ?>
              </p>
            </div>
          </div>


        <?php } ?>
      </article>
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

  <script src="js/app.js"></script>
</body>

</html>