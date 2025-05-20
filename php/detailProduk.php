<?php
session_start();
require_once __DIR__ . "/getConnection.php";

$conn = getConnection();

// Pastikan ada ID produk yang dikirim via GET
if (!isset($_GET['id'])) {
    header("Location: detailProduk.php");
    exit();
}

$id = $_GET['id'];

// Ambil data produk dari database
$sql = "SELECT * FROM produk WHERE id_produk = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);
$produk = $stmt->fetch();

if (!$produk) {
    echo "Produk tidak ditemukan.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>

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
    <div class="container-detail-produk">
        <!-- Detail Produk Start -->
        <div class="detail-produk-container">
            <img src="../images/produk/<?= $produk['foto'] ?>" alt="foto-produk">
            <div class="content">
                <h1><?php echo $produk['nama_produk'] ?></h1>
                <h3>Rp.<?php echo $produk['harga_produk'] ?></h3>
                <div class="stars">
                    ★ ★ ★ ★ ★
                </div>
                <a href="beli.php?id=<?php echo $produk['id_produk']; ?>">Beli Sekarang</a>
            </div>
        </div>
    </div>
    <!-- Detail Produk End -->

    <!-- Icons -->
    <script>
      feather.replace();
    </script>

    <!-- My Script -->
    <script src="../js/script.js"></script>
</body>
</html>