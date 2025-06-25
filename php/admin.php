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

$sql = "SELECT transaksi.*, produk.nama_produk, produk.harga_produk, user.username 
        FROM transaksi
        JOIN produk ON transaksi.id_produk = produk.id_produk
        JOIN user ON transaksi.id_user = user.id_user
        ORDER BY transaksi.tanggal DESC";

$stmt = $conn->prepare($sql);
$stmt->execute();
$transaksi = $stmt->fetchAll();

$totalPendapatan = 0;
foreach ($transaksi as $row) {
    $totalPendapatan += $row['harga_produk'] * $row['jumlah_pembelian'];
}

$conn = null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    <!-- Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- My Style -->
    <link rel="stylesheet" href="../css/admin.css">
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

    <!-- Dashboard Admin End -->
    <section class="dashboard-admin">
        <h1>Total Pendapatan</h1>
        <h3>Rp.<?php echo number_format($totalPendapatan, 0, ',', '.') ?></h3>

        <h2>Riwayat Transaksi</h2>
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Nama User</th>
                    <th>Nama Produk</th>
                    <th>Jumlah Pembelian</th>
                    <th>Total Harga</th>
                    <th>Tanggal</th>
                    <th>Metode Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transaksi as $row) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['username']) ?></td>
                        <td><?php echo htmlspecialchars($row['nama_produk']) ?></td>
                        <td><?php echo htmlspecialchars($row['jumlah_pembelian']) ?></td>
                        <td>Rp.<?php echo number_format($row['harga_produk'] * $row['jumlah_pembelian'], 0, ',', '.') ?></td>
                        <td><?php echo htmlspecialchars($row['tanggal']) ?></td>
                        <td><?php echo htmlspecialchars($row['metode']) ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </section>
    <!-- Dashboard Admin End -->

    <!-- Icons -->
    <script>
      feather.replace();
    </script>

    <!-- My Script -->
    <script src="../js/script.js"></script>
</body>
</html>