<?php
session_start();
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Remobil | Home</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- AOS CSS -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <style>
    html {
      scroll-behavior: smooth;
    }
    :root {
        --main-color: #E4501D;
        --secondary-color: #892D0E;
        --text-color: #FFFFFF;
        --light-bg: #FFF5F2;
        --dark-bg: #2C1006;
    }

    body {
        color: var(--dark-bg);
        font-family: 'Source Sans Pro', sans-serif;
    }

    .hero {
        background-image: url('dist/img/remobil/car.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 100vh;
        position: relative;
        overflow: hidden;
    }

    .hero::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(44, 16, 6, 0.8); /* Adjust the last value (0.8) to change opacity */
    }

    .hero-content {
        position: relative;
        z-index: 1;
    }

    .hero h1 {
        font-size: 4rem;
        font-weight: 700;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    }

    .hero p {
        font-size: 1.5rem;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
    }

    .section {
        padding: 100px 0;
    }

    .navbar {
        background-color: var(--main-color) !important;
        transition: all 0.3s ease;
    }

    .navbar-scrolled {
        background-color: rgba(228, 80, 29, 0.9) !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .navbar-light .navbar-nav .nav-link {
        color: var(--text-color);
        transition: color 0.3s ease;
    }

    .navbar-light .navbar-nav .nav-link:hover {
        color: var(--secondary-color);
    }

    .btn-primary {
        background-color: var(--main-color);
        border-color: var(--main-color);
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: var(--secondary-color);
        border-color: var(--secondary-color);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .bg-light {
        background-color: var(--light-bg) !important;
    }

    .card {
        border-color: var(--main-color);
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    }

    .card-title {
        color: var(--main-color);
    }

    .main-footer {
        background-color: var(--dark-bg);
        color: var(--text-color);
    }

    .main-footer a {
        color: var(--main-color);
        transition: color 0.3s ease;
    }

    .main-footer a:hover {
        color: var(--secondary-color);
    }

    .glow {
        animation: glow 2s ease-in-out infinite alternate;
    }

    @keyframes glow {
        from {
            text-shadow: 0 0 5px #fff, 0 0 10px #fff, 0 0 15px var(--main-color), 0 0 20px var(--main-color);
        }
        to {
            text-shadow: 0 0 10px #fff, 0 0 20px #fff, 0 0 30px var(--main-color), 0 0 40px var(--main-color);
        }
    }

    .carousel-item {
        transition: transform 0.6s ease-in-out;
    }

    .carousel-item-next,
    .carousel-item-prev,
    .carousel-item.active {
        display: flex;
        justify-content: center;
    }

    .carousel-control-prev,
    .carousel-control-next {
        width: 5%;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-color: var(--main-color);
        border-radius: 50%;
        padding: 10px;
    }

    .hover-card {
        transition: all 0.3s ease;
    }

    .hover-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }
  </style>
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-dark fixed-top">
    <div class="container">
      <a href="index.php" class="navbar-brand">
        <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Remobil</span>
      </a>
      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="#home" class="nav-link">Home</a>
          </li>
          <li class="nav-item">
            <a href="#about" class="nav-link">About Us</a>
          </li>
          <li class="nav-item">
            <a href="#services" class="nav-link">Services</a>
          </li>
          <li class="nav-item">
            <a href="#reviews" class="nav-link">Reviews</a>
          </li>
          <li class="nav-item">
            <a href="#contact" class="nav-link">Contact</a>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto">
          <?php if(isset($_SESSION['username'])): ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="logout.php">Logout</a>
              </div>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link" href="login.php">Login</a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Hero/Home Section -->
    <section id="home" class="hero d-flex align-items-center">
      <div class="container text-center hero-content">
        <h1 class="text-white glow" data-aos="fade-down" data-aos-delay="100">Remobil</h1>
        <p class="text-white" data-aos="fade-up" data-aos-delay="200">Rental Mobil Terpecaya.</p>
        <a href="#services" class="btn btn-primary btn-lg mt-3" data-aos="zoom-in" data-aos-delay="300">Our Services</a>
      </div>
    </section>

    <!-- About Us Section -->
    <section id="about" class="section bg-light">
  <div class="container">
    <h2 class="text-center mb-5" data-aos="fade-up" style="color: var(--main-color);">About Us</h2>
    <div class="row align-items-center">
      <div class="col-md-6" data-aos="fade-right">
        <img src="dist/img/remobil/about-us.png" alt="About Remobil" class="img-fluid rounded shadow-lg">
      </div>
      <div class="col-md-6" data-aos="fade-left">
        <p class="lead">Remobil adalah penyedia layanan sewa mobil terkemuka, menawarkan berbagai macam kendaraan untuk memenuhi kebutuhan Anda.</p>
        <p>Dengan komitmen kami terhadap kualitas dan kepuasan pelanggan, kami memastikan pengalaman penyewaan yang lancar dan menyenangkan.</p>
        <ul class="list-unstyled">
          <li><i class="fas fa-check text-success mr-2"></i> Pilihan kendaraan yang beragam</li>
          <li><i class="fas fa-check text-success mr-2"></i> Harga yang kompetitif</li>
          <li><i class="fas fa-check text-success mr-2"></i> Layanan pelanggan yang luar biasa</li>
        </ul>
      </div>
    </div>
  </div>
</section>

    <!-- Services Section -->
    <section id="services" class="section" style="background-color: var(--light-bg); position: relative; overflow: hidden;">
  <!-- Add a subtle background pattern -->
  <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-image: url('data:image/svg+xml,%3Csvg width="20" height="20" xmlns="http://www.w3.org/2000/svg"%3E%3Cpath d="M0 0h20v20H0z" fill="%23ffffff" fill-opacity="0.05"/%3E%3Cpath d="M0 10h20v10H0z" fill="%23000000" fill-opacity="0.05"/%3E%3C/svg%3E'); opacity: 0.5;"></div>

  <div class="container" style="position: relative; z-index: 1;">
    <h2 class="text-center mb-5" style="color: var(--main-color);" data-aos="fade-up">Our Services</h2>
    <div class="row">
      <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
        <div class="card h-100 shadow hover-card">
          <div class="card-body text-center d-flex flex-column">
            <i class="fas fa-car fa-3x mb-3" style="color: var(--main-color);"></i>
            <h5 class="card-title">Rental Mobil</h5>
            <p class="card-text flex-grow-1">Pilih dari berbagai macam kendaraan kami untuk perjalanan sempurna Anda.</p>
            <a href="catalog.php?type=car" class="btn btn-primary mt-3">View More</a>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
        <div class="card h-100 shadow hover-card">
          <div class="card-body text-center d-flex flex-column">
            <i class="fas fa-truck fa-3x mb-3" style="color: var(--main-color);"></i>
            <h5 class="card-title">Sewa Mudah dan Cepat</h5>
            <p class="card-text flex-grow-1">Proses penyewaan yang lancar dan efisien. Nikmati kemudahan dan kecepatan dalam menyewa kendaraan impian Anda!</p>
            <a href="catalog.php?type=van" class="btn btn-primary mt-3">View More</a>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="300">
        <div class="card h-100 shadow hover-card">
          <div class="card-body text-center d-flex flex-column">
            <i class="fas fa-motorcycle fa-3x mb-3" style="color: var(--main-color);"></i>
            <h5 class="card-title">Layanan Ekonomis</h5>
            <p class="card-text flex-grow-1">Nikmati perjalanan dengan kendaraan berkualitas dan harga yang ramah di kantong untuk semua kalangan.</p>
            <a href="catalog.php?type=motorcycle" class="btn btn-primary mt-3">View More</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

    <!-- Reviews Section -->
    <section id="reviews" class="section bg-light">
  <div class="container">
    <h2 class="text-center mb-5" style="color: var(--main-color);" data-aos="fade-up">Customer Reviews</h2>
    <div id="reviewCarousel" class="carousel slide" data-ride="carousel" data-aos="fade-up" data-aos-delay="100">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <div class="card shadow">
            <div class="card-body text-center">
              <i class="fas fa-quote-left fa-2x mb-3" style="color: var(--main-color);"></i>
              <p class="card-text lead">"Mobil kualitas tinggi, dan harga terjangkau."</p>
              <p class="card-text"><small class="text-muted">- Freddy Budianto</small></p>
            </div>
          </div>
        </div>
        <div class="carousel-item">
          <div class="card shadow">
            <div class="card-body text-center">
              <i class="fas fa-quote-left fa-2x mb-3" style="color: var(--main-color);"></i>
              <p class="card-text lead">"Mudah dihubungi, dan penanganan cepat!"</p>
              <p class="card-text"><small class="text-muted">- Humamino Destrianto</small></p>
            </div>
          </div>
        </div>
        <div class="carousel-item">
          <div class="card shadow">
            <div class="card-body text-center">
              <i class="fas fa-quote-left fa-2x mb-3" style="color: var(--main-color);"></i>
              <p class="card-text lead">"Sangat direkomendasikan untuk perjalanan jauh!"</p>
              <p class="card-text"><small class="text-muted">- Muhammad Farhan</small></p>
            </div>
          </div>
        </div>
      </div>
      <a class="carousel-control-prev" href="#reviewCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#reviewCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
  </div>
</section>

    <!-- Contact Section -->
    <section id="contact" class="section" style="background-color: var(--dark-bg); color: var(--text-color);">
  <div class="container">
    <h2 class="text-center mb-5" style="color: var(--main-color);" data-aos="fade-up">Contact Us</h2>
    <div class="row justify-content-center">
      <div class="col-md-8 text-center" data-aos="fade-up" data-aos-delay="100">
        <p class="lead mb-4">Have questions or need assistance? Reach out to us!</p>
        <div class="mb-4">
          <i class="fas fa-envelope mr-2" style="color: var(--main-color);"></i>
          <a href="mailto:info@remobil.com" class="text-white">info@remobil.com</a>
        </div>
        <div class="mb-4">
          <i class="fas fa-phone mr-2" style="color: var(--main-color);"></i>
          <a href="tel:+1234567890" class="text-white">+1 (234) 567-890</a>
        </div>
        <p>Follow us on social media:</p>
        <a href="https://www.instagram.com/your_instagram" target="_blank" class="btn btn-outline-light mr-2">
          <i class="fab fa-instagram"></i> Instagram
        </a>
        <a href="https://www.youtube.com/your_youtube" target="_blank" class="btn btn-outline-light">
          <i class="fab fa-youtube"></i> YouTube
        </a>
      </div>
    </div>
  </div>
</section>
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-inline">
      Remobil - Your Trusted Car Rental Service
    </div>
    <strong>Copyright &copy; 2023 <a href="https://adminlte.io">Remobil</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AOS JS -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init();

  // Navbar scroll effect
  $(window).scroll(function() {
    if ($(this).scrollTop() > 50) {
      $('.navbar').addClass('navbar-scrolled');
    } else {
      $('.navbar').removeClass('navbar-scrolled');
    }
  });

  // Smooth scrolling for navbar links
  // $('a[href^="#"]').on('click', function(event) {
  //   var target = $(this.getAttribute('href'));
  //   if( target.length ) {
  //     event.preventDefault();
  //     $('html, body').stop().animate({
  //       scrollTop: target.offset().top - 70
  //     }, 1000);
  //   }
  // });
</script>
</body>
</html>