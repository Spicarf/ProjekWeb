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
    <link rel="stylesheet" href="css/style.css">
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
                <?php if(!isset($_SESSION['user']['profile'])) { ?>
                    <img src="images/profile.jpg" alt="foto">
                <?php } else { ?>
                    <img src="images/profile/<?= htmlspecialchars($_SESSION['user']['profile']) ?>" alt="foto">
                <?php } ?>
                <p><?php echo $_SESSION['user']['username'] ?></p>
            </a>
        <?php } ?>
    </nav>
    <!-- Navbar End -->

    <!-- Hero Section Start -->
    <section class="hero">
        <main class="content">
            <h1>Belanja Sayur & Buah Segar Kini Lebih Mudah!</h1>
            <p>Dapatkan sayur dan buah terbaik langsung dari petani lokal. Segar, sehat, dan hemat — tanpa perlu keluar rumah! Yuk, mulai hidup sehat dari dapurmu hari ini.</p>
            <a href="php/produk.php" class="cta">Beli Sekarang</a>
        </main>

    </section>
    <!-- Hero Section End -->
    
    <!-- Why Section start-->
    <section id="why" class="why">
        <h2>Why <span class="logo1">Sayur</span><span class="logo2">in</span>?</h2>
        <div class = "row">
            <div class="why-card">
                <img src="images/freshPicked.jpg" >
                <h3 class = "why-card-tagline"> Freshly Picked </h3>
                <p class = "why-card-caption">Nikmati sayur dan buah segar pilihan yang langsung dikirim dari petani lokal. Tanpa transit panjang, tanpa lama-lama di gudang</p>
            </div>
            <div class="why-card">
                <img src="images/option.jpg" >
                <h3 class = "why-card-tagline"> Flexible Options </h3>
                <p class = "why-card-caption">Beli satuan, paketan hemat, atau langsung pilih menu siap masak. Cocok buat segala gaya hidup, dari anak kos sampai keluarga sibuk</p>
            </div>
            <div class="why-card">
                <img src="images/pickup.jpg" >
                <h3 class = "why-card-tagline"> Fast & Simple </h3>
                <p class = "why-card-caption">Belanja sayur gak perlu keluar rumah. Tinggal order lewat website, kirim di hari yang sama, dan bisa atur jadwal sesuai kebutuhanmu</p>
            </div>
        </div>
    </section>
    <!-- Why Section end -->

    <!-- About Section Start -->
    <section class = "about">
        <div class="row">
            <div class="about-image">
                <img src="images/box.jpg" alt="">
            </div>
            <div class="content">
                <div>
                    <h1>Ngintip yuk, ada apa aja di dalam box HelloFresh?</h1>
                    <p><span>Sayur & buah segar berkualitas tinggi: </span>Langsung dari petani lokal, dipilih yang terbaik dan masih super fresh.</p>
                    <p><span>Kemasan food-grade & rapi: </span>Dikemas dalam box kokoh yang menjaga kesegaran, aman selama pengiriman..</p>
                    <p><span>Pelindung ekstra di dalam box: </span>Ada pelapis atau kantong pelindung supaya sayur & buah tetap utuh dan tidak rusak.</p>
                    <p><span>Dikirim langsung ke depan pintu rumahmu: </span>Tanpa ribet ke pasar, tinggal duduk manis dan tunggu box datang.</p>
                    <p><span>Cocok buat stok masakan harian: </span>Isi box cukup untuk kebutuhan beberapa hari, pas buat keluarga kecil atau anak kos.</p>
                    <p><span>Label & info isi yang jelas: </span>Setiap item dilabeli, jadi kamu tahu apa saja yang kamu terima.</p>
                </div>
            </div>
        </div>

    </section>
    <!-- About Section End -->

    <!-- footer Section Start -->
    <footer class="footer">
        <div class="socials">
            <a href="https://instagram.com/faridnanda._" target="_blank">
            <i data-feather="instagram"></i>
            <p>@faridnanda._</p>
            </a>
            <a href="https://instagram.com/cindyynatasyaa" target="_blank">
            <i data-feather="instagram"></i>
            <p>@cindyynatasyaa</p>
            </a>
            <a href="https://instagram.com/raffiji" target="_blank">
            <i data-feather="instagram"></i>
            <p>@raffiji</p>
            </a>
        </div>
        <p class="credit">Created by PT. Kelompok Ceria | &copy; 2025</p>
    </footer>
    <!-- footer Section end -->

    <!-- Icons -->
    <script>
      feather.replace();
    </script>

    <!-- My Script -->
    <script src="js/script.js"></script>
</body>
</html>