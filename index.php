<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    <!-- Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- My Style -->
    <link rel="stylesheet" href="css/style1.css">
</head>
<body>
    <!-- Navbar Start -->
    <nav class="navbar">
        <a href="#" id="hamburger-menu"><i data-feather="menu"></i></a>

        <a href="index.php" class="navbar-logo">
            <img src="images/logo.png" alt="logo">
            <p>Sayur<span>in</span></p>
        </a>

        <div class="navbar-nav">   
            <a href="index.php"><i data-feather="home"></i>Home</a>
            <a href="php/produk.php"><i data-feather="shopping-cart"></i>Produk</a>
            <a href="#"><i data-feather="users"></i>Tentang Kami</a>
            <a href="#"><i data-feather="phone"></i>Kontak</a>
        </div>

        <?php if(!isset($_SESSION['user'])) { ?>
            <a href="php/login.php" class="akun">Login</a>
        <?php } else { ?>
            <a href="php/profile.php" class="akun-login">
                <img src="images/profile.jpg" alt="foto">
                <p><?php echo $_SESSION['user']['username'] ?></p>
            </a>
        <?php }  ?>
    </nav>
    <!-- Navbar End -->

    <!-- Hero Section Start -->
    <section class="hero">
        <main class="content">
            <h1>Mari Beli Sayur dan Buah Disini!</h1>
            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Enim nulla mollitia delectus aliquid? Voluptatum non voluptate, repudiandae porro error ipsam repellat delectus architecto. Odio tempora in illum? Officia, sunt a?</p>
            <a href="php/produk.php" class="cta">Beli Sekarang</a>
        </main>
    </section>
    <!-- Hero Section End -->

    <!-- Icons -->
    <script>
      feather.replace();
    </script>

    <!-- My Script -->
    <script src="js/script.js"></script>
</body>
</html>