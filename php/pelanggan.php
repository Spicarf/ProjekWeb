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

$totalPelanggan = $conn->query("SELECT COUNT(*) AS total FROM user WHERE username != 'admin'")->fetch(PDO::FETCH_ASSOC)['total'];

$statement = $conn->query("SELECT nama, username, email FROM user WHERE username != 'admin'");
$pelanggan = $statement->fetchAll(PDO::FETCH_ASSOC);

$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pelanggan</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">

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

<!-- Daftar Pelanggan Start -->
<section class="daftar-pelanggan">
    <h1>Total Pelanggan</h1>
    <h3><?php echo $totalPelanggan; ?> Pelanggan</h3>

    <h2>Daftar Pelanggan</h2>
    <table>
        <thead>
            <tr>
                <th>Nama Lengkap</th>
                <th>Username</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pelanggan as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['nama']) ?></td>
                    <td><?= htmlspecialchars($p['username']) ?></td>
                    <td><?= htmlspecialchars($p['email']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
<!-- Daftar Pelanggan End -->

<!-- Icons -->
<script>feather.replace();</script>

<!-- My Script -->
<script src="../js/script.js"></script>
</body>
</html>
