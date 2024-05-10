<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="title" content="Griya Jamoe Klasik" />
  <meta name="description" content="Kami merupakan produsen UMKM yang berdedikasi memproduksi minuman jamu tradisional dan bahan rempah pilihan. Dengan komitmen pada kesehatan dan kearifan lokal, kami hadir untuk menyajikan produk berkualitas tinggi yang merangkul warisan tradisi dan memberikan manfaat kesehatan melalui setiap tetes dan sajian kami." />
  <title>Griya Jamoe Klasik</title>

  <!-- favicon -->
  <link rel="icon" type="image/x-icon" href="img/logo.png" />

  <!-- scroll reveal -->
  <script src="https://unpkg.com/scrollreveal@4"></script>

  <!-- animate css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

  <link rel="icon" type="image/x-icon" href="./assets/logo.png" />

  <link rel="stylesheet" href="./css/default.css" />
  <link rel="stylesheet" href="./css/style.css" />


  <style>
    .loading-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(255, 255, 255, 0.9);
      /* Semi-transparent white background */
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 9999;
      /* Ensure the overlay is above all other elements */
    }

    .loading-text {
      font-size: 24px;
      color: #333;
    }
  </style>

</head>

<body>

  <!-- Loading overlay -->
  <div class="loading-overlay">
    <p class="loading-text">Loading...</p>
  </div>

  <!-- header section start -->
  <header class="header">
    <div class="container animate__animated animate__fadeInDown">
      <nav>
        <a href="#" id="brand"><span style="color: #fff">Griya</span> Jamoe Klasik</a>
      </nav>

      <ul>
        <li><a href="#">Beranda</a></li>
        <li><a href="#tentang-kami">Tentang Kami</a></li>
        <li><a href="produk.php">Produk </a></li>
        <li><a href="artikel.php">Artikel</a></li>
      </ul>
    </div>
    <div class="hero animate__animated animate__fadeIn animate__slow" id="hero">
      <h1 class="hero-title">
        Minuman Tradisional <br />
        Rempah Klasik, Rasa Autentik
      </h1>
      <p class="hero-text">
        Jelajahi kelezatan rempah dan minuman tradisional melalui hidangan
        kami yang unik. Setiap sajian mengundang Anda untuk merasakan sentuhan
        khas cita rasa dan aroma yang tak terlupakan
      </p>
    </div>

    <div class="slogan">
      <div class="slogan-wrapper">
        <h3 class="slogan-title">
          Produk <span style="color: #dfb665">Berkualitas</span>
        </h3>
        <p class="slogan-text">
          “Semua produk kami dibuat dari <br />awal menggunakan bahan-bahan
          berkualitas tinggi”
        </p>
      </div>
    </div>
  </header>

  <!-- header section end -->

  <!-- tentang kami section start-->
  <section class="tentang-kami" id="tentang-kami">
    <div class="container">
      <h2 class="tentang-kami-title">
        Tentang <span style="color: #dfb665">Kami</span>
      </h2>
      <div class="row">
        <p class="tentang-kami-text">
          Kami merupakan produsen UMKM yang berdedikasi memproduksi minuman
          kesehatan tradisional dari bahan rempah pilihan. Dengan komitmen
          pada kesehatan dan kearifan lokal, kami hadir untuk menyajikan
          produk berkualitas tinggi yang merangkul warisan tradisi dan
          memberikan manfaat kesehatan melalui setiap tetes dan sajian kami.
        </p>
        <img src="img/logo.png" alt="logo griya jamoe klasik" />
      </div>
      <div class="shape"></div>
    </div>
  </section>

  <!-- tentang kami section end -->

  <!-- produk kami section start -->
  <section class="produk-kami" id="produk-kami">
    <div class="container">
      <h2 class="produk-kami-title">
        <span style="color: #dfb665">Produk</span> Kami
      </h2>
      <div class="line"></div>
      <div class="row">
        <div class="col">
          <img src="./img/wedang-kencur.png" alt="wedang kencur" />
          <h3>Wedang Kencur</h3>
          <p>
            Wedang kencur adalah minuman tradisional Indonesia yang dikenal
            sebagai penyegar dan penguat stamina, serta dipercaya memiliki
            manfaat kesehatan seperti meredakan masuk angin atau perut
            kembung.
          </p>
        </div>
        <div class="col">
          <img src="./img/teh-rosella.png" alt="Rosella" />
          <h3>Teh Rosella</h3>
          <p>
            Teh rosella adalah minuman herbal yang terbuat dari bunga rosella
            kering yang dikenal karena kandungan antioksidannya yang tinggi
            serta kemampuannya untuk menurunkan tekanan darah dan kolesterol.
          </p>
        </div>
        <div class="col">
          <img src="./img/wedang-mpon.png" alt="wedang mpon" />
          <h3>Wedang Mpon-mpon</h3>
          <p>
            Wedang mpon-mpon, minuman tradisional dari Indonesia, dibuat dari
            campuran jahe, serai, dan rempah-rempah lainnya. Disajikan hangat,
            populer untuk menghangatkan tubuh saat cuaca dingin atau musim
            hujan.
          </p>
        </div>
      </div>
      <a href="produk.php" class="lihat-selengkapnya">Lihat Selengkapnya</a>
    </div>
  </section>
  <!-- produk kami section end -->

  <!-- kenapa kami section start -->
  <section id="kenapa-kami" class="kenapa-kami">
    <div class="container">
      <h2 class="kenapa-kami-title">
        <span style="color: #dfb665">Kenapa</span> pilih kami?
      </h2>
      <div class="line"></div>
      <p class="kenapa-kami-text">
        Kami tidak hanya sekadar produsen minuman kesehatan tradisional tapi
        juga mitra yang peduli pada kesehatan dan kepuasan pelanggan. Kami
        menghadirkan ragam minuman berkualitas tinggi yang tidak hanya lezat,
        tetapi juga mengandung nilai kesehatan yang tinggi. Keberlanjutan dan
        transparansi adalah nilai inti kami, dan kami berkomitmen untuk
        memberikan produk yang ramah lingkungan serta memberdayakan masyarakat
        lokal. Dengan memilih produk kami, Anda tidak hanya mendukung gaya
        hidup sehat tetapi juga berkontribusi pada upaya keberlanjutan dan
        pertumbuhan ekonomi lokal.
      </p>
    </div>
  </section>
  <!-- kenapa kami section end -->

  <!-- testimoni section start -->
  <section id="testimoni" class="testimoni">
    <div class="wrapper">
      <h2 class="testimoni-title">Testimoni</h2>
      <div class="line"></div>
      <div class="wrapper-content">
        <button class="left" style="transform: rotate(180deg); line-height: 50px">
          ➔
        </button>

        <p class="testimoni-quote">
          “Paket mendarat aman sampe bandung, bisa untuk masak bumbu jamu dan
          praktis. Good packaging dan juga sudah ada sertifikasi halal dan
          pirt”
        </p>

        <button class="right">➔</button>
      </div>

      <h4 class="testimoni-person">Icha</h4>
    </div>
  </section>
  <!-- testimoni section end -->

  <!-- temukan kami section start -->

  <section class="temukan-kami" id="temukan-kami">
    <h2 class="temukan-kami-title">
      <span style="color: #dfb665">Temukan</span> Kami
    </h2>
    <div class="line"></div>
    <div class="iframe-wrapper">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.329147754293!2d106.83250787316943!3d-6.351415362134014!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69ec3a1f9ce731%3A0xdce374a4203448ea!2sJl.%20H.%20Shibi%20No.7%2C%20RT.7%2FRW.1%2C%20Srengseng%20Sawah%2C%20Kec.%20Jagakarsa%2C%20Kota%20Jakarta%20Selatan%2C%20Daerah%20Khusus%20Ibukota%20Jakarta%2010550!5e0!3m2!1sid!2sid!4v1711047481205!5m2!1sid!2sid" style="border: 0" allowfullscreen="" loading="lazy" title="maps" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
  </section>

  <!-- temukan kami section end -->

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
                ✉️ Jl. H. Shibi No.7, RT.7/RW.1, Srengseng Sawah, Kec.
                Jagakarsa, <br />Kota Jakarta Selatan, Daerah Khusus Ibukota
                Jakarta 12640
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

  <script>
    // scroll reveals index
    ScrollReveal().reveal(".slogan", {
      delay: 1000,
      origin: "left",
      distance: "100px",
    });

    ScrollReveal().reveal(".tentang-kami-title", {
      delay: 1000,
      origin: "top",
      distance: "100px",
    });

    ScrollReveal().reveal(".tentang-kami-text", {
      delay: 1200,
      origin: "left",
      distance: "100px",
    });

    ScrollReveal().reveal(".produk-kami-title", {
      delay: 1200,
      origin: "top",
      distance: "100px",
    });

    ScrollReveal().reveal(".produk-kami .line", {
      delay: 1200,
      origin: "top",
      distance: "100px",
    });

    ScrollReveal().reveal(".produk-kami .col", {
      delay: 1500,
      origin: "left",
      distance: "100px",
    });

    ScrollReveal().reveal(".kenapa-kami-title", {
      delay: 1000,
      origin: "top",
      distance: "100px",
    });

    ScrollReveal().reveal(".kenapa-kami .line", {
      delay: 1200,
      origin: "top",
      distance: "100px",
    });

    ScrollReveal().reveal(".kenapa-kami-text", {
      delay: 1700,
      origin: "left",
      distance: "100px",
    });

    // ScrollReveal().reveal(".testimoni .wrapper", {
    //   delay: 1700,
    //   origin: "left",
    //   distance: "100px",
    // });

    // Hide loading overlay when the page finishes loading
    window.addEventListener('load', function() {
      document.querySelector('.loading-overlay').style.display = 'none';
    });
  </script>

  <!-- footer end -->

  <script src="js/data.js"></script>
</body>

</html>