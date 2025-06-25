<?php
session_start();
require_once __DIR__ . "/getConnection.php";

$conn = getConnection();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: produk.php"); 
    exit();
}

$id = $_GET['id'];

$sql = "SELECT * FROM produk WHERE id_produk = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);
$produk = $stmt->fetch();

if (!$produk) {
    echo "Produk tidak ditemukan.";
    exit();
}

$sql = "SELECT komentar.*, user.username, user.profile 
        FROM komentar 
        JOIN user ON komentar.id_user = user.id_user 
        WHERE komentar.id_produk = ? 
        ORDER BY komentar.tanggal DESC";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);
$komen = $stmt->fetchAll();

$id_produk = $produk['id_produk'];
$stmt = $conn->prepare("SELECT AVG(rating) as avg_rating FROM komentar WHERE id_produk = :id_produk");
$stmt->execute([':id_produk' => $id_produk]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$average_rating = $row['avg_rating'] ? round($row['avg_rating']) : 0;

$user = $_SESSION['user'];
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
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">

    <!-- Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- My Style -->
    <link rel="stylesheet" href="../css/produk.css">
</head>
<body>
    <div class="container-detail-produk">
        <!-- Detail Produk Start -->
        <div class="detail-produk-container">
            <a href="javascript:window.history.back();"><i data-feather="arrow-left" class="btn-back"></i></a>
            <div class="produk-container">
                <img src="../images/produk/<?= htmlspecialchars($produk['foto']) ?>" alt="foto-produk">
                <div class="content">
                    <h1><?= htmlspecialchars($produk['nama_produk']) ?></h1>
                    <h3>Rp.<?= number_format($produk['harga_produk'], 0, ',', '.') ?>/kg</h3>
                    
                    <div class="rating">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <?php if ($i <= $average_rating): ?>
                                <label for="rating<?= $i ?>" style="color: gold;">★</label>
                            <?php else: ?>
                                <label for="rating<?= $i ?>" style="color: #ccc;">★</label>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>

                    <div class="action-group">
                        <a href="#" class="btn-beli-sekarang" onclick="konfirmasiBeli(<?= $produk['id_produk']; ?>)">
                            Beli Sekarang
                        </a>
                        <span class="stok">
                            Stok: <?= ($produk['stok'] <= 0 || $produk['stok'] === null) ? "Habis" : htmlspecialchars($produk['stok']); ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Detail Produk End -->

        <!-- Komentar Start -->
        <div class="detail-komentar-container">
            <h2>Komentar</h2>
            <div class="komentar-container">
                <?php if(count($komen) > 0) { ?>
                    <?php foreach($komen as $row) { ?>
                        <div class="akun-komen">
                            <div class="profil-pemberi-komen">
                                <?php if($row['profile'] == NULL) { ?>
                                    <img src="../images/profile.jpg" alt="foto">
                                <?php } else { ?>
                                    <img src="../images/profile/<?= htmlspecialchars($row['profile']); ?>" alt="foto">
                                <?php } ?>
                                <strong><?= htmlspecialchars($row['username']); ?></strong>
                                <div class="rating-komentar">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <span style="color: <?= $i <= $row['rating'] ? 'gold' : '#ccc' ?>;">★</span>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <p class="isi-komen"><?php echo $row['komentar']; ?></p>
                            <p><?= date("d M Y, H:i", strtotime($row['tanggal'])); ?></p>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <p class="no-komen">Belum Ada Komentar</p>
                <?php } ?>
            </div>
        </div>
        <!-- Komentar End -->
    </div>

    <!-- Icons -->
    <script>feather.replace();</script>
    <!-- My Script -->
    <script src="../js/script.js"></script>

    <div id="popup-modal" class="popup-overlay">
        <div class="popup-content">
            <h2>Konfirmasi Pembelian</h2>
            <p>Masukkan jumlah produk yang ingin dibeli:</p>
            <input type="number" id="jumlah_pembelian" value="1" min="1" class="jumlah-input">
            <div class="popup-buttons">
            <button onclick="prosesBeli()" class="popup-btn confirm">Beli</button>
            <button onclick="tutupPopup()" class="popup-btn cancel">Batal</button>
            </div>
        </div>
    </div>
</body>
</html>