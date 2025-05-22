<?php
session_start();
require_once __DIR__ . "/getConnection.php";
$conn = getConnection();

// Cek login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Ambil semua kategori unik (selain NULL/kosong)
$stmt_kategori = $conn->query("SELECT DISTINCT kategori FROM produk WHERE kategori IS NOT NULL AND kategori != ''");
$kategori_list = $stmt_kategori->fetchAll(PDO::FETCH_COLUMN);

// Kategori yang dipilih
$selected_kategori = $_GET['kategori'] ?? 'semua';

// Ambil data produk berdasarkan kategori
if ($selected_kategori === 'semua') {
    $stmt_produk = $conn->query("SELECT * FROM produk");
} else {
    $stmt_produk = $conn->prepare("SELECT * FROM produk WHERE kategori = :kategori");
    $stmt_produk->execute(['kategori' => $selected_kategori]);
}

$produk_list = $stmt_produk->fetchAll(PDO::FETCH_ASSOC);
$conn = null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Produk</title>
    <link rel="stylesheet" href="../css/produk.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <a href="#" id="hamburger-menu"><i data-feather="menu"></i></a>
    <a href="../index.php" class="navbar-logo">
        <img src="../images/logo.png" alt="logo">
        <p>Sayur<span>in</span></p>
    </a>
    <div class="navbar-nav">   
        <a href="../index.php"><i data-feather="home"></i>Home</a>
        <a href="#"><i data-feather="shopping-cart"></i>Produk</a>
        <a href="../index.php#why"><i data-feather="users"></i>Tentang Kami</a>
    </div>

    <?php if(!isset($_SESSION['user'])): ?>
        <a href="login.php" class="akun">Login</a>
    <?php else: ?>
        <a href="profile.php" class="akun-login">
            <?php if(empty($_SESSION['user']['profile'])): ?>
                <img src="../images/profile.jpg" alt="foto">
            <?php else: ?>
                <img src="../images/profile/<?= htmlspecialchars($_SESSION['user']['profile']) ?>" alt="foto">
            <?php endif; ?>
            <p><?= htmlspecialchars($_SESSION['user']['username']) ?></p>
        </a>
    <?php endif; ?>
</nav>

<!-- Filter Kategori Start -->
<nav class="kategori-filter">
    <a href="?kategori=semua" <?= $selected_kategori === 'semua' ? 'class="active"' : '' ?>>Semua</a>
    <?php foreach ($kategori_list as $kategori): ?>
        <a href="?kategori=<?= urlencode($kategori) ?>" <?= $selected_kategori === $kategori ? 'class="active"' : '' ?>>
            <?= htmlspecialchars(ucfirst($kategori)) ?>
        </a>
    <?php endforeach; ?>
</nav>
<!-- Filter Kategori End -->

<!-- Produk Start -->
<section class="produk">
    <?php if(count($produk_list) > 0) { ?>
        <?php foreach($produk_list as $row) { ?>
            <div class="content">
                <img src="../images/produk/<?php echo $row['foto'] ?>" alt="foto-produk">
                <p class="nama-produk"><?php echo $row['nama_produk'] ?></p>
                <p class="harga">Rp.<?php echo $row['harga_produk'] ?>/kg</p>
                <a href="detailProduk.php?id=<?php echo $row['id_produk']; ?>" class="btn-edit">Detail Produk</a>
                <a href="transaksi.php?id_produk=<?php echo $row['id_produk']; ?>" class="beli">Beli</a>
            </div>
        <?php } ?>
    <?php } else { ?>
        <p>Belum ada produk yang ditambahkan</p>
    <?php } ?>
</section>
<!-- Produk End -->

<!-- Icons -->
<script>feather.replace();</script>
<script src="../js/script.js"></script>

</body>
</html>
