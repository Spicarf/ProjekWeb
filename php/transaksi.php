<?php
session_start();
require_once __DIR__ . "/getConnection.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$id_user = $_SESSION['user']['id_user'] ?? null;
$id_produk = isset($_GET['id_produk']) ? (int)$_GET['id_produk'] : 0;
$conn = getConnection();

$pesan = "";
$success = false;

if (!$id_produk) {
    die("Produk tidak valid.");
}

$stmt = $conn->prepare("SELECT harga_produk FROM produk WHERE id_produk = :id_produk");
$stmt->execute(['id_produk' => $id_produk]);
$produk = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produk) {
    die("Produk tidak ditemukan.");
}

$jumlah_pembelian = isset($_GET['jumlah_pembelian']) ? (int)$_GET['jumlah_pembelian'] : 1;
if ($jumlah_pembelian <= 0) {
    $jumlah_pembelian = 1;
}
$total_pembayaran = $produk['harga_produk'] * $jumlah_pembelian;

if ($_SERVER["REQUEST_METHOD"] === "POST" && $id_user) {
    $metode_pembayaran = $_POST['metode_pembayaran'] ?? '';
    $id_produk_post = isset($_POST['id_produk']) ? (int)$_POST['id_produk'] : 0;

    if (!$metode_pembayaran) {
    $pesan = "Silakan pilih metode pembayaran terlebih dahulu.";
} elseif (!$id_produk_post) {
    $pesan = "Produk tidak valid.";
} else {
    // Cek stok dulu
    $stmt = $conn->prepare("SELECT stok FROM produk WHERE id_produk = :id_produk");
    $stmt->execute([':id_produk' => $id_produk_post]);
    $produk_stok = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$produk_stok || $produk_stok['stok'] < $jumlah_pembelian) {
        $pesan = "Stok tidak cukup untuk pembelian ini.";
    } else {
        date_default_timezone_set('Asia/Makassar');
        $tanggal = date("Y-m-d H:i:s");
        try {
            $conn->beginTransaction();

            $stmt = $conn->prepare("INSERT INTO transaksi (id_user, id_produk, tanggal, metode, jumlah_pembelian) VALUES (:id_user, :id_produk, :tanggal, :metode, :jumlah_pembelian)");
            $stmt->execute([
                ':id_user' => $id_user,
                ':id_produk' => $id_produk_post,
                ':tanggal' => $tanggal,
                ':metode' => $metode_pembayaran,
                ':jumlah_pembelian' => $jumlah_pembelian
            ]);

            $stmt = $conn->prepare("UPDATE produk SET stok = stok - :jumlah WHERE id_produk = :id_produk");
            $stmt->execute([
                ':jumlah' => $jumlah_pembelian,
                ':id_produk' => $id_produk_post
            ]);

            $conn->commit();
            $success = true;
        } catch (PDOException $e) {
            $conn->rollBack();
            $pesan = "Error saat proses transaksi: " . $e->getMessage();
        }
    }
}
} elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
    $pesan = "Silakan login terlebih dahulu.";
}

$conn = null;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Transaksi</title>
    <link rel="stylesheet" href="../css/transaksi.css">
</head>
<body data-success="<?= $success ? 'true' : 'false' ?>">

<div class="container-transaksi">
    <h2>Transaksi Pembayaran</h2>

    <?php if (!empty($pesan)): ?>
        <div class="error-message"><?= htmlspecialchars($pesan) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <label>Total Pembayaran</label>
        <input type="text" value="Rp <?= number_format($total_pembayaran, 0, ',', '.') ?>" readonly>

        <label>Metode Pembayaran</label>
        <div class="metode-group">
            <input type="radio" id="ovo" name="metode_pembayaran" value="OVO" <?= (isset($_POST['metode_pembayaran']) && $_POST['metode_pembayaran'] === 'OVO') ? 'checked' : '' ?> required>
            <label for="ovo">OVO</label>

            <input type="radio" id="dana" name="metode_pembayaran" value="DANA" <?= (isset($_POST['metode_pembayaran']) && $_POST['metode_pembayaran'] === 'DANA') ? 'checked' : '' ?> required>
            <label for="dana">DANA</label>

            <input type="radio" id="qris" name="metode_pembayaran" value="QRIS" <?= (isset($_POST['metode_pembayaran']) && $_POST['metode_pembayaran'] === 'QRIS') ? 'checked' : '' ?> required>
            <label for="qris">QRIS</label>
        </div>

        <input type="hidden" name="jumlah_pembelian" value="<?= htmlspecialchars($jumlah_pembelian) ?>">
        <input type="hidden" name="id_produk" value="<?= htmlspecialchars($id_produk) ?>">

        <button type="submit" class="btn-submit">Bayar</button>
        <a href="produk.php" class="btn-batal">Batal</a>
    </form>
</div>

<!-- Success Popup -->
<div id="popup-success" class="popup-modal">
    <div class="popup-content">
        <h3>Berhasil!</h3>
        <p>Pembayaran berhasil dilakukan.</p>
    </div>
</div>

<script src="../js/transaksi.js"></script>

</body>
</html>
