<?php
session_start();
require_once __DIR__ . "/getConnection.php";
$conn = getConnection();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM produk";
$statement = $conn -> prepare($sql);
$statement -> execute();
$produk = $statement->fetchAll();
$conn = null;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    <!-- Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- My Style -->
    <link rel="stylesheet" href="../css/produk.css">
</head>
<body>
    <!-- Navbar Start -->
    <nav class="navbar">
        <a href="#" id="hamburger-menu"><i data-feather="menu"></i></a>

        <a href="../index.php" class="navbar-logo">
            <img src="../images/logo.png" alt="logo">
            <p>Sayur<span>in</span></p>
        </a>

        <div class="navbar-nav">   
            <a href="../index.php"><i data-feather="home"></i>Home</a>
            <a href="#"><i data-feather="shopping-cart"></i>Produk</a>
            <a href="#"><i data-feather="users"></i>Tentang Kami</a>
            <a href="#"><i data-feather="phone"></i>Kontak</a>
        </div>

        <?php if(!isset($_SESSION['user'])) { ?>
            <a href="login.php" class="akun">Login</a>
        <?php } else { ?>
            <a href="profile.php" class="akun-login">
                <?php if(!isset($_SESSION['user']['profile'])) { ?>
                    <img src="../images/profile.jpg" alt="foto">
                <?php } else { ?>
                    <img src="../images/profile/<?= htmlspecialchars($_SESSION['user']['profile']) ?>" alt="foto">
                <?php } ?>
                <p><?php echo $_SESSION['user']['username'] ?></p>
            </a>
        <?php } ?>
    </nav>
    <!-- Navbar End -->

    <!-- Section Produk Start -->
    <section class="produk">
        <?php if(count($produk) > 0) { ?>
            <?php foreach($produk as $row) { ?>
                <div class="content">
                    <img src="../images/produk/<?php echo $row['foto'] ?>" alt="foto-produk">
                    <p class="nama-produk"><?php echo $row['nama_produk'] ?></p>
                    <p class="harga">Rp.<?php echo $row['harga_produk'] ?></p>
                    <a href="detailProduk.php?id=<?php echo $row['id_produk']; ?>" class="btn-edit">Detail Produk</a>
                    <a href="transaksi.php?id_produk=<?php echo $row['id_produk']; ?>" class="beli">Beli</a>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p>Belum ada produk yang ditambahkan</p>
        <?php } ?>
    </section>
    <!-- Section Produk End -->

    <!-- Icons -->
    <script>
      feather.replace();
    </script>

    <!-- My Script -->
    <script src="../js/script.js"></script>
</body>
</html>