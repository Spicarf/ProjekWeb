<?php
session_start();
require_once __DIR__ . "/getConnection.php";
$conn = getConnection();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
$user = $_SESSION['user'];

$sql = "SELECT t.tanggal, t.id_produk, p.nama_produk, p.harga_produk AS harga_produk, p.foto
        FROM transaksi t
        JOIN produk p ON t.id_produk = p.id_produk
        WHERE t.id_user = ?
        ORDER BY t.tanggal DESC";
$stmt = $conn->prepare($sql);
$stmt->execute([$user['id_user']]);
$riwayat = $stmt->fetchAll();

$conn = null;
?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    <!-- Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- My Style -->
    <link rel="stylesheet" href="../css/profile.css">
</head>
<body>
  <div class="container">
    <!-- Menu Start -->
    <div class="menu">
      <h3>Menu</h3>
      <a href="profile.php">My Profile</a>
      <a href="pesanan.php">Riwayat Pesanan</a>
      <a href="editProfile.php">Edit Profile</a>
      <a href="editPassword.php">Edit Password</a>
      <a href="../index.php">Beranda</a>
      <a href="logout.php">Logout</a>
    </div>
    <!-- Menu End -->

    <!-- Riwayat Start -->
    <div class="content">
        <h2>Riwayat Pesanan</h2>
        <div class="pesanan">
            <?php if (empty($riwayat)): ?>
                <p>Tidak ada riwayat pesanan.</p>
            <?php else: ?>
                <?php foreach ($riwayat as $item): ?>
                <div class="pesanan-item">
                    <img src="../images/produk/<?= htmlspecialchars($item['foto']) ?>" alt="foto-produk">
                    <div class="pesanan-info">
                        <h1><?= htmlspecialchars($item['nama_produk']) ?></h1>
                        <p>Rp<?= number_format($item['harga_produk'], 0, ',', '.') ?></p>
                        <p><?= date("d-m-Y H:i", strtotime($item['tanggal'])) ?></p>
                        <a href="komentar.php?id_produk=<?php echo $item['id_produk']; ?>">Beri Komentar</a>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <!-- Riwayat End -->
  </div>

  <!-- Icons -->
  <script>
    feather.replace();
  </script>

  <!-- My Script -->
  <script src="js/script.js"></script>
</body>
</html>
