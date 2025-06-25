<?php
session_start();
require_once __DIR__ . "/getConnection.php";
$conn = getConnection();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['user']['username'] != "admin" && $_SESSION['user']['email'] != "adminsayurin@gmail.com") {
    header("Location: ../index.php");
    exit();
}

$sql = "SELECT * FROM produk";
$statement = $conn -> prepare($sql);
$statement -> execute();
$produk = $statement->fetchAll();

$stmt_kategori = $conn->query("SELECT DISTINCT kategori FROM produk WHERE kategori IS NOT NULL AND kategori != ''");
$kategori_list = $stmt_kategori->fetchAll(PDO::FETCH_COLUMN);

$selected_kategori = $_GET['kategori'] ?? 'semua';
if ($selected_kategori === 'semua') {
    $stmt_produk = $conn->query("SELECT * FROM produk");
} else {
    $stmt_produk = $conn->prepare("SELECT * FROM produk WHERE kategori = :kategori");
    $stmt_produk->execute(['kategori' => $selected_kategori]);
}
$produk_list = $stmt_produk->fetchAll(PDO::FETCH_ASSOC);

$user = $_SESSION['user'];
$conn = null;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk</title>

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

        <a href="admin.php" class="navbar-logo">
            <img src="../images/logo.png" alt="logo">
            <p>Sayur<span>in</span></p>
        </a>

        <div class="navbar-nav">   
            <a href="admin.php"><i data-feather="home"></i>Dashboard</a>
            <a href="tambahProduk.php"><i data-feather="plus"></i>Tambah Produk</a>
            <a href="kelolaProduk.php"><i data-feather="settings"></i>Kelola Produk</a>
            <a href="pelanggan.php"><i data-feather="users"></i>Lihat Pelanggan</a>
        </div>

        <?php if(!isset($_SESSION['user'])) { ?>
            <a href="login.php" class="akun">Login</a>
        <?php } else { ?>
            <a href="logout.php" class="akun-login">
                <img src="../images/profile.jpg" alt="foto">
                <p><?php echo $_SESSION['user']['username'] ?></p>
            </a>
        <?php }  ?>
    </nav>
    <!-- Navbar End -->
    
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
                    <p class="stok">Stok: <?php if ($row['stok'] > 0) echo $row['stok']; else echo "Habis"; ?></p>
                    <a href="editProduk.php?id=<?php echo $row['id_produk']; ?>" class="btn-edit">Edit</a>
                    <a href="hapusProduk.php?id=<?php echo $row['id_produk']; ?>" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</a>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p>Belum ada produk yang ditambahkan</p>
        <?php } ?>
    </section>
    <!-- Produk End -->

    <!-- Icons -->
    <script>
      feather.replace();
    </script>

    <!-- My Script -->
    <script src="../js/script.js"></script>
</body>
</html>